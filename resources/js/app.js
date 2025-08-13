import './bootstrap';

// Console log for Google Maps API loading
console.log('Loading Google Maps API...');

// Global variables for Google Maps
let map;
let marker;
let currentLocationType = null;
let selectedLocation = null;

// Enhanced scroll detection for sticky header
let lastScrollTop = 0;
const header = document.querySelector('header');

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    // Add scrolled class for enhanced backdrop effect
    if (scrollTop > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
    
    lastScrollTop = scrollTop;
});

// Mobile menu functionality
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    const overlay = document.querySelector('.mobile-menu-overlay');
    
    mobileMenu.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Prevent body scroll when menu is open
    if (mobileMenu.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    const overlay = document.querySelector('.mobile-menu-overlay');
    
    mobileMenu.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

function closeMapModal() {
    const modal = document.getElementById('mapModal');
    if (modal) {
        modal.style.display = 'none';
    }
    selectedLocation = null;
}

// This function is now defined later in the file to handle both contexts

// Booking form submission
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBookingBtn');
            const originalText = submitBtn.textContent;
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            const formData = new FormData(this);
            
            // Basic validation for required fields
            const city = formData.get('city');
            const date = formData.get('date');
            const time = formData.get('time');
            const pickup = formData.get('pickup_location');
            const dropoff = formData.get('dropoff_location');
            const mobile = formData.get('mobile');
            const email = formData.get('email');
            
            if (!city || !date || !time || !pickup || !dropoff || !mobile || !email) {
                alert('Please fill in all required fields');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Mobile validation (basic check for numbers and common phone characters)
            const mobileRegex = /^[\d\s\-\+\(\)]+$/;
            if (!mobileRegex.test(mobile) || mobile.replace(/[\s\-\+\(\)]/g, '').length < 7) {
                alert('Please enter a valid mobile number');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('Security token not found. Please refresh the page and try again.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Add CSRF token
            formData.append('_token', csrfToken.getAttribute('content'));
            
            // Get base URL for the request
            const baseUrl = window.location.origin;
            const bookingUrl = baseUrl + '/booking';
            
            console.log('Attempting to submit booking to:', bookingUrl);
            console.log('Form data:', Object.fromEntries(formData.entries()));
            
            fetch(bookingUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Error response text:', text);
                        throw new Error(`HTTP ${response.status}: ${response.statusText} - ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert(data.message);
                    this.reset(); // Reset form
                    // Clear hidden fields and location inputs
                    const pickupField = document.getElementById('pickup');
                    const dropoffField = document.getElementById('dropoff');
                    const pickupLatField = document.getElementById('pickup_lat');
                    const pickupLngField = document.getElementById('pickup_lng');
                    const dropoffLatField = document.getElementById('dropoff_lat');
                    const dropoffLngField = document.getElementById('dropoff_lng');
                    
                    if (pickupField) pickupField.value = '';
                    if (dropoffField) dropoffField.value = '';
                    if (pickupLatField) pickupLatField.value = '';
                    if (pickupLngField) pickupLngField.value = '';
                    if (dropoffLatField) dropoffLatField.value = '';
                    if (dropoffLngField) dropoffLngField.value = '';
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        let errorMsg = 'Please correct the following errors:\n';
                        for (const field in data.errors) {
                            errorMsg += `- ${data.errors[field][0]}\n`;
                        }
                        alert(errorMsg);
                    } else {
                        alert('Error: ' + (data.message || 'Please check your information and try again.'));
                    }
                }
            })
            .catch(error => {
                console.error('Booking Error Details:', {
                    error: error,
                    message: error.message,
                    stack: error.stack,
                    url: bookingUrl || '/booking',
                    timestamp: new Date().toISOString()
                });
                
                let errorMessage = 'An error occurred. Please try again.';
                let debugInfo = '';
                
                if (error.message.includes('HTTP 405')) {
                    errorMessage = 'Booking endpoint not configured correctly. Please contact support.';
                    debugInfo = ' (Error 405: Method Not Allowed)';
                } else if (error.message.includes('HTTP 419')) {
                    errorMessage = 'Your session has expired. Please refresh the page and try again.';
                    debugInfo = ' (Error 419: CSRF Token Expired)';
                } else if (error.message.includes('HTTP 500')) {
                    errorMessage = 'Server error occurred. Please try again later or contact support.';
                    debugInfo = ' (Error 500: Server Error)';
                } else if (error.message.includes('NetworkError') || error.message.includes('Failed to fetch')) {
                    errorMessage = 'Network error. Please check your connection and try again.';
                    debugInfo = ' (Network Error)';
                } else if (error.message.includes('HTTP')) {
                    const httpMatch = error.message.match(/HTTP (\d+)/);
                    if (httpMatch) {
                        debugInfo = ` (HTTP ${httpMatch[1]})`;
                    }
                }
                
                // Show detailed error in console for debugging
                console.error('Booking submission failed:', {
                    url: bookingUrl || '/booking',
                    error: error.message,
                    formData: typeof formData !== 'undefined' ? Object.fromEntries(formData.entries()) : 'N/A'
                });
                
                alert(errorMessage + debugInfo + '\n\nPlease contact support at support@tawasullimo.ae if the problem persists.');
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});

function subscribeNewsletter() {
    const email = document.querySelector('.newsletter-input input[type="email"]').value;
    if (email) {
        alert('Thank you for subscribing! We will keep you updated.');
        document.querySelector('.newsletter-input input[type="email"]').value = '';
    } else {
        alert('Please enter a valid email address');
    }
}

// New functions for Section 4
function applyNow() {
    // Redirect to the booking page
    window.location.href = '/booking';
}

function downloadApps() {
    alert('Our mobile app will be available soon! We will notify you.');
}

// FAQ Toggle Functionality
function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const icon = element.querySelector('.faq-icon');
    
    // Close all other FAQ items
    const allFaqItems = document.querySelectorAll('.faq-item');
    allFaqItems.forEach(item => {
        if (item !== faqItem) {
            item.classList.remove('active');
            const otherIcon = item.querySelector('.faq-icon');
            otherIcon.textContent = '+';
        }
    });
    
    // Toggle current FAQ item
    faqItem.classList.toggle('active');
    
    if (faqItem.classList.contains('active')) {
        icon.textContent = '×';
    } else {
        icon.textContent = '+';
    }
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileMenu = document.getElementById('mobileMenu');
    const toggle = document.querySelector('.mobile-menu-toggle');
    
    if (mobileMenu && toggle && !mobileMenu.contains(event.target) && !toggle.contains(event.target)) {
        closeMobileMenu();
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        closeMobileMenu();
    }
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Populate date dropdown with next 30 days
function populateDateDropdown() {
    const dateSelect = document.getElementById('date');
    if (!dateSelect) return;
    
    const today = new Date();
    
    for (let i = 0; i < 30; i++) {
        const date = new Date(today);
        date.setDate(today.getDate() + i);
        
        const option = document.createElement('option');
        const dateString = date.toISOString().split('T')[0];
        const displayDate = date.toLocaleDateString('en-US', { 
            weekday: 'short', 
            month: 'short', 
            day: 'numeric',
            year: 'numeric'
        });
        
        option.value = dateString;
        option.textContent = displayDate;
        dateSelect.appendChild(option);
    }
}

// Initialize Google Maps (with fallback)
window.initMap = function() {
    console.log('initMap called');
    try {
        const mapElement = document.getElementById('map');
        console.log('Map element found:', mapElement);
        
        if (!mapElement) {
            console.error('Map container element not found!');
            return;
        }
        
        // Default location: Dubai
        const defaultLocation = { lat: 25.2048, lng: 55.2708 };
        console.log('Creating map with default location:', defaultLocation);
        
        map = new google.maps.Map(mapElement, {
            zoom: 13,
            center: defaultLocation,
        });
        
        console.log('Map created successfully:', map);

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });

        // Add click listener to map
        map.addListener('click', function(event) {
            const clickedLocation = {
                lat: event.latLng.lat(),
                lng: event.latLng.lng()
            };
            
            marker.setPosition(clickedLocation);
            
            // Get address from coordinates
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: clickedLocation }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    selectedLocation = {
                        address: results[0].formatted_address,
                        lat: clickedLocation.lat,
                        lng: clickedLocation.lng
                    };
                }
            });
        });

        // Add drag listener to marker
        marker.addListener('dragend', function() {
            const position = marker.getPosition();
            const location = {
                lat: position.lat(),
                lng: position.lng()
            };
            
            // Get address from coordinates
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: location }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    selectedLocation = {
                        address: results[0].formatted_address,
                        lat: location.lat,
                        lng: location.lng
                    };
                }
            });
        });

        // Initialize Places Autocomplete
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Search for a location...';
        input.style.cssText = 'margin: 10px; padding: 10px; width: calc(100% - 40px); border: 1px solid #ccc; border-radius: 5px;';
        
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (place.geometry) {
                map.setCenter(place.geometry.location);
                map.setZoom(15);
                marker.setPosition(place.geometry.location);
                
                selectedLocation = {
                    address: place.formatted_address,
                    lat: place.geometry.location.lat(),
                    lng: place.geometry.location.lng()
                };
            }
        });

        // Initialize Places Autocomplete for the search input
        const searchInput = document.getElementById('mapSearch');
        if (searchInput) {
            const autocomplete = new google.maps.places.Autocomplete(searchInput, {
                types: ['establishment', 'geocode'],
                componentRestrictions: { country: 'ae' } // Restrict to UAE
            });

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    const location = {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng()
                    };
                    
                    // Center map on the selected place
                    map.setCenter(location);
                    map.setZoom(16);
                    
                    // Move marker to the selected place
                    marker.setPosition(location);
                    
                    // Update selected location
                    selectedLocation = {
                        address: place.formatted_address || place.name,
                        lat: location.lat,
                        lng: location.lng
                    };
                }
            });
        }
    } catch (error) {
        console.log('Google Maps API not available. Using fallback location input.');
        // If Google Maps fails, convert location inputs to text inputs
        const pickupInput = document.getElementById('pickup');
        const dropoffInput = document.getElementById('dropoff');
        
        if (pickupInput) {
            pickupInput.removeAttribute('readonly');
            pickupInput.removeAttribute('onclick');
            pickupInput.placeholder = 'Enter pickup address manually';
        }
        
        if (dropoffInput) {
            dropoffInput.removeAttribute('readonly');
            dropoffInput.removeAttribute('onclick');
            dropoffInput.placeholder = 'Enter drop-off address manually';
        }
    }
}

// Handle location input - try map selector first, fallback to manual input
function handleLocationInput(type) {
    console.log('handleLocationInput called with type:', type);
    
    // Check if Google Maps is available first
    if (typeof google === 'undefined' || !google.maps) {
        console.log('Google Maps not available, enabling manual input');
        enableManualLocationInput(type);
        return;
    }
    
    // Try to open map selector
    try {
        openMapSelector(type);
    } catch (error) {
        console.error('Error opening map selector:', error);
        enableManualLocationInput(type);
    }
}

// Enable manual location input when maps are not available
function enableManualLocationInput(type) {
    const inputField = document.getElementById(type === 'pickup' ? 'pickup' : 'dropoff');
    if (inputField) {
        inputField.removeAttribute('readonly');
        inputField.removeAttribute('onclick');
        inputField.focus();
        
        // Only show alert once per session
        const alertKey = 'manual-location-alert-shown';
        if (!sessionStorage.getItem(alertKey)) {
            inputField.placeholder = 'Type your address here';
            alert('Map selector not available. Please type the address manually.');
            sessionStorage.setItem(alertKey, 'true');
        } else {
            inputField.placeholder = 'Type your address here';
        }
    }
}

// Map selector functions with fallback
function openMapSelector(type) {
    console.log('openMapSelector called with type:', type);
    
    const inputField = document.getElementById(type === 'pickup' ? 'pickup' : 'dropoff');
    
    // Check if Google Maps is available
    if (typeof google === 'undefined' || !google.maps) {
        console.log('Google Maps not available, enabling manual input');
        // Google Maps not available - allow manual input
        if (inputField) {
            inputField.removeAttribute('onclick');
            inputField.focus();
            // Show a one-time message about manual input
            if (!inputField.hasAttribute('data-manual-mode')) {
                inputField.setAttribute('data-manual-mode', 'true');
                inputField.placeholder = 'Type your address here';
                alert('Map selector not available. Please type the address manually.');
            }
        }
        return;
    }
    
    console.log('Google Maps available, opening modal');
    currentLocationType = type;
    const modal = document.getElementById('mapModal');
    const title = document.getElementById('mapModalTitle');
    
    if (!modal) {
        console.error('Map modal not found!');
        // Fallback to manual input
        if (inputField) {
            inputField.focus();
            alert('Map interface not available. Please type the address manually.');
        }
        return;
    }
    
    if (modal && title) {
        title.textContent = type === 'pickup' ? 'Select Pickup Location' : 'Select Drop-off Location';
        modal.style.display = 'block';
        
        // Reinitialize map when modal opens
        setTimeout(() => {
            if (map) {
                google.maps.event.trigger(map, 'resize');
                console.log('Map resized');
                
                // Check if there's already a location set for this input
                const inputField = document.getElementById(type === 'pickup' ? 'pickup' : 'dropoff');
                const latField = document.getElementById(type + '_lat');
                const lngField = document.getElementById(type + '_lng');
                
                if (latField && lngField && latField.value && lngField.value) {
                    // Show existing location on map
                    const existingLocation = {
                        lat: parseFloat(latField.value),
                        lng: parseFloat(lngField.value)
                    };
                    map.setCenter(existingLocation);
                    marker.setPosition(existingLocation);
                    selectedLocation = {
                        address: inputField.value,
                        lat: existingLocation.lat,
                        lng: existingLocation.lng
                    };
                } else if (type === 'pickup' && navigator.geolocation) {
                    // Try to get current location for pickup if no location is set
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        marker.setPosition(userLocation);
                        
                        // Get address from coordinates
                        const geocoder = new google.maps.Geocoder();
                        geocoder.geocode({ location: userLocation }, function(results, status) {
                            if (status === 'OK' && results[0]) {
                                selectedLocation = {
                                    address: results[0].formatted_address,
                                    lat: userLocation.lat,
                                    lng: userLocation.lng
                                };
                            }
                        });
                    });
                }
            } else {
                console.error('Map not initialized!');
            }
        }, 100);
    }
}

// Use current location in map modal
function useCurrentLocationInMap() {
    const currentLocationBtn = document.getElementById('useCurrentLocationBtn');
    
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by this browser.');
        return;
    }
    
    // Disable button and show loading
    currentLocationBtn.disabled = true;
    currentLocationBtn.textContent = '📍 Getting Location...';
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            if (map && marker) {
                map.setCenter(userLocation);
                marker.setPosition(userLocation);
                
                // Get address from coordinates
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: userLocation }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        selectedLocation = {
                            address: results[0].formatted_address,
                            lat: userLocation.lat,
                            lng: userLocation.lng
                        };
                        
                        // Re-enable button
                        currentLocationBtn.disabled = false;
                        currentLocationBtn.textContent = '📍 Use Current Location';
                    } else {
                        console.error('Geocoding failed:', status);
                        selectedLocation = {
                            address: `Current Location (${userLocation.lat.toFixed(6)}, ${userLocation.lng.toFixed(6)})`,
                            lat: userLocation.lat,
                            lng: userLocation.lng
                        };
                        
                        // Re-enable button
                        currentLocationBtn.disabled = false;
                        currentLocationBtn.textContent = '📍 Use Current Location';
                    }
                });
            }
        },
        function(error) {
            console.error('Geolocation error:', error);
            alert('Unable to get your current location. Please try again or select manually.');
            
            // Re-enable button
            currentLocationBtn.disabled = false;
            currentLocationBtn.textContent = '📍 Use Current Location';
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 300000 // 5 minutes
        }
    );
}

// Initialize date dropdown on page load
document.addEventListener('DOMContentLoaded', function() {
    populateDateDropdown();
    initializeDateTimeInputs();
    
    // Initialize current location after a short delay to ensure Google Maps is loaded
    setTimeout(() => {
        initializeCurrentLocation();
    }, 1000);
    
    // Fallback initialization for Google Maps if callback doesn't work
    setTimeout(() => {
        if (typeof google !== 'undefined' && google.maps && !map) {
            console.log('Initializing Google Maps via fallback');
            initMap();
        }
    }, 2000);
});

// Initialize current location for pickup field
function initializeCurrentLocation() {
    const pickupInput = document.getElementById('pickup');
    const pickupLatInput = document.getElementById('pickup_lat');
    const pickupLngInput = document.getElementById('pickup_lng');
    
    if (!pickupInput) return;
    
    // Check if geolocation is supported
    if (navigator.geolocation) {
        // Show loading state
        pickupInput.placeholder = 'Getting your current location...';
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                // Use reverse geocoding to get the address
                if (typeof google !== 'undefined' && google.maps && google.maps.Geocoder) {
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ location: userLocation }, function(results, status) {
                        if (status === 'OK' && results[0]) {
                            pickupInput.value = results[0].formatted_address;
                            pickupLatInput.value = userLocation.lat;
                            pickupLngInput.value = userLocation.lng;
                            pickupInput.placeholder = 'Click to select on map or type address';
                        } else {
                            console.error('Geocoding failed:', status);
                            // Fallback to coordinates
                            pickupLatInput.value = userLocation.lat;
                            pickupLngInput.value = userLocation.lng;
                            pickupInput.value = `Current Location (${userLocation.lat.toFixed(6)}, ${userLocation.lng.toFixed(6)})`;
                            pickupInput.placeholder = 'Type address or keep current location';
                        }
                    });
                } else {
                    // If Google Maps is not available, just store coordinates with better user experience
                    pickupLatInput.value = userLocation.lat;
                    pickupLngInput.value = userLocation.lng;
                    pickupInput.value = `Your Current Location (${userLocation.lat.toFixed(4)}, ${userLocation.lng.toFixed(4)})`;
                    pickupInput.placeholder = 'Type address or keep current location';
                    // Make the input editable since maps aren't available
                    pickupInput.removeAttribute('readonly');
                    pickupInput.removeAttribute('onclick');
                }
            },
            function(error) {
                console.error('Geolocation error:', error);
                
                // Set appropriate placeholder based on whether maps are available
                if (typeof google === 'undefined' || !google.maps) {
                    pickupInput.placeholder = 'Type your pickup address';
                    pickupInput.removeAttribute('readonly');
                    pickupInput.removeAttribute('onclick');
                } else {
                    pickupInput.placeholder = 'Click to select on map or type address';
                }
                
                // Handle different error cases
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        console.log('User denied the request for Geolocation.');
                        break;
                    case error.POSITION_UNAVAILABLE:
                        console.log('Location information is unavailable.');
                        break;
                    case error.TIMEOUT:
                        console.log('The request to get user location timed out.');
                        break;
                    default:
                        console.log('An unknown error occurred.');
                        break;
                }
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000 // 5 minutes
            }
        );
    } else {
        console.log('Geolocation is not supported by this browser.');
        // Set appropriate placeholder based on whether maps are available
        if (typeof google === 'undefined' || !google.maps) {
            pickupInput.placeholder = 'Type your pickup address';
            pickupInput.removeAttribute('readonly');
            pickupInput.removeAttribute('onclick');
        } else {
            pickupInput.placeholder = 'Click to select on map or type address';
        }
    }
}

// Initialize date and time inputs with better UX
function initializeDateTimeInputs() {
    const dateInput = document.getElementById('date');
    const timeInput = document.getElementById('time');
    
    // Set minimum date to today
    if (dateInput) {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        dateInput.setAttribute('min', formattedDate);
        
        // Set default to today if no value
        if (!dateInput.value) {
            dateInput.value = formattedDate;
        }
        
        // Add validation for past dates
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                alert('Please select a date from today onwards.');
                this.value = today.toISOString().split('T')[0];
            }
        });
    }
    
    // Set default time to current time + 1 hour
    if (timeInput && !timeInput.value) {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        timeInput.value = `${hours}:${minutes}`;
    }
}

// Smooth scroll functionality for "Book Your Trip" navigation
document.addEventListener('DOMContentLoaded', function() {
    // Handle smooth scrolling for Book Your Trip navigation links
    const bookTripLinks = document.querySelectorAll('a[href*="#bookingForm"]');
    
    bookTripLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Check if we're on the same page (home)
            const currentPage = window.location.pathname;
            const linkHref = this.getAttribute('href');
            
            // If we're linking to the same page with anchor
            if (linkHref.includes('#bookingForm') && (currentPage === '/' || linkHref.includes(currentPage))) {
                e.preventDefault();
                
                // Close mobile menu if open
                if (typeof closeMobileMenu === 'function') {
                    closeMobileMenu();
                }
                
                // Scroll to booking form
                scrollToBookingForm();
            }
        });
    });
    
    // Handle direct hash navigation (when page loads with #bookingForm)
    if (window.location.hash === '#bookingForm') {
        setTimeout(function() {
            scrollToBookingForm();
        }, 500); // Small delay to ensure page is fully loaded
    }
});

function scrollToBookingForm() {
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        // Calculate offset to account for fixed header
        const headerHeight = document.querySelector('header').offsetHeight || 80;
        const elementPosition = bookingForm.offsetTop;
        const offsetPosition = elementPosition - headerHeight - 20; // Extra 20px padding
        
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
        
        // Optional: Add a subtle highlight effect
        bookingForm.style.transition = 'background-color 0.3s ease';
        bookingForm.style.backgroundColor = 'rgba(83, 84, 86, 0.05)';
        
        setTimeout(function() {
            bookingForm.style.backgroundColor = '';
        }, 2000);
    }
}

// Google Maps is initialized via window.initMap callback

// Booking Modal Functions
function openBookingModal() {
    const modal = document.getElementById('bookingModal');
    if (modal) {
        modal.style.display = 'flex';
        // Use setTimeout to trigger animation after display is set
        setTimeout(() => {
            modal.classList.add('active');
        }, 50);
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Initialize form with current date/time
        initializeModalForm();
    }
}

function closeBookingModal() {
    const modal = document.getElementById('bookingModal');
    if (modal) {
        modal.classList.remove('active');
        // Wait for animation to complete before hiding
        setTimeout(() => {
            modal.style.display = 'none';
        }, 1200);
        
        // Restore body scroll
        document.body.style.overflow = '';
    }
}

function initializeModalForm() {
    // Set minimum date to today
    const dateInput = document.getElementById('modal_date');
    if (dateInput) {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        dateInput.setAttribute('min', formattedDate);
        dateInput.value = formattedDate;
    }
    
    // Set default time to current time + 1 hour
    const timeInput = document.getElementById('modal_time');
    if (timeInput) {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        timeInput.value = `${hours}:${minutes}`;
    }
}

// Handle booking modal form submission
document.addEventListener('DOMContentLoaded', function() {
    const bookingModalForm = document.getElementById('bookingModalForm');
    if (bookingModalForm) {
        bookingModalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.see-prices-btn');
            const originalText = submitBtn.textContent;
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            const formData = new FormData(this);
            
            // Basic validation for required fields
            const city = formData.get('city');
            const date = formData.get('date');
            const time = formData.get('time');
            const pickup = formData.get('pickup_location');
            const dropoff = formData.get('dropoff_location');
            const mobile = formData.get('mobile');
            const email = formData.get('email');
            
            if (!city || !date || !time || !pickup || !dropoff || !mobile || !email) {
                alert('Please fill in all required fields');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Mobile validation (basic check for numbers and common phone characters)
            const mobileRegex = /^[\d\s\-\+\(\)]+$/;
            if (!mobileRegex.test(mobile) || mobile.replace(/[\s\-\+\(\)]/g, '').length < 7) {
                alert('Please enter a valid mobile number');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('Security token not found. Please refresh the page and try again.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }
            
            // Add CSRF token
            formData.append('_token', csrfToken.getAttribute('content'));
            
            // Get base URL for the request
            const baseUrl = window.location.origin;
            const bookingUrl = baseUrl + '/booking';
            
            console.log('Attempting to submit booking to:', bookingUrl);
            console.log('Form data:', Object.fromEntries(formData.entries()));
            
            fetch(bookingUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    this.reset(); // Reset form
                    closeBookingModal(); // Close modal after successful submission
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        let errorMsg = 'Please correct the following errors:\n';
                        for (const field in data.errors) {
                            errorMsg += `- ${data.errors[field][0]}\n`;
                        }
                        alert(errorMsg);
                    } else {
                        alert('Error: ' + (data.message || 'Please check your information and try again.'));
                    }
                }
            })
            .catch(error => {
                console.error('Booking Error Details:', {
                    error: error,
                    message: error.message,
                    stack: error.stack,
                    url: bookingUrl || '/booking',
                    timestamp: new Date().toISOString()
                });
                
                let errorMessage = 'An error occurred. Please try again.';
                let debugInfo = '';
                
                if (error.message.includes('HTTP 405')) {
                    errorMessage = 'Booking endpoint not configured correctly. Please contact support.';
                    debugInfo = ' (Error 405: Method Not Allowed)';
                } else if (error.message.includes('HTTP 419')) {
                    errorMessage = 'Your session has expired. Please refresh the page and try again.';
                    debugInfo = ' (Error 419: CSRF Token Expired)';
                } else if (error.message.includes('HTTP 500')) {
                    errorMessage = 'Server error occurred. Please try again later or contact support.';
                    debugInfo = ' (Error 500: Server Error)';
                } else if (error.message.includes('NetworkError') || error.message.includes('Failed to fetch')) {
                    errorMessage = 'Network error. Please check your connection and try again.';
                    debugInfo = ' (Network Error)';
                } else if (error.message.includes('HTTP')) {
                    const httpMatch = error.message.match(/HTTP (\d+)/);
                    if (httpMatch) {
                        debugInfo = ` (HTTP ${httpMatch[1]})`;
                    }
                }
                
                // Show detailed error in console for debugging
                console.error('Booking submission failed:', {
                    url: bookingUrl || '/booking',
                    error: error.message,
                    formData: typeof formData !== 'undefined' ? Object.fromEntries(formData.entries()) : 'N/A'
                });
                
                alert(errorMessage + debugInfo + '\n\nPlease contact support at support@tawasullimo.ae if the problem persists.');
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});

// Close modal when clicking on the dark overlay (not the content)
document.addEventListener('click', function(event) {
    const modal = document.getElementById('bookingModal');
    const modalContent = document.querySelector('.booking-modal-content');
    
    // Only close if clicking directly on the modal overlay (dark background)
    if (modal && modal.classList.contains('active') && event.target === modal) {
        closeBookingModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    const modal = document.getElementById('bookingModal');
    if (event.key === 'Escape' && modal && modal.classList.contains('active')) {
        closeBookingModal();
    }
});

// Handle modal location input - specifically for booking modal
function handleModalLocationInput(type) {
    console.log('handleModalLocationInput called with type:', type);
    
    // Set current location type for the confirmation
    currentLocationType = type;
    
    // Try to open map selector
    try {
        openMapSelector(type);
    } catch (error) {
        console.error('Error opening map selector:', error);
        // Fallback to manual input
        const inputField = document.getElementById(type === 'pickup' ? 'modal_pickup' : 'modal_dropoff');
        if (inputField) {
            inputField.removeAttribute('readonly');
            inputField.removeAttribute('onclick');
            inputField.placeholder = 'Type your address here';
            inputField.focus();
            alert('Map selector not available. Please type the address manually.');
        }
    }
}

// Update confirmLocation function to work with modal inputs
function confirmLocation() {
    if (selectedLocation && currentLocationType) {
        let inputField, latField, lngField;
        
        // Check if we're in the booking modal context
        if (document.getElementById('bookingModal').classList.contains('active')) {
            inputField = document.getElementById(currentLocationType === 'pickup' ? 'modal_pickup' : 'modal_dropoff');
            latField = document.getElementById('modal_' + currentLocationType + '_lat');
            lngField = document.getElementById('modal_' + currentLocationType + '_lng');
        } else {
            // Default behavior for home page
            inputField = document.getElementById(currentLocationType === 'pickup' ? 'pickup' : 'dropoff');
            latField = document.getElementById(currentLocationType + '_lat');
            lngField = document.getElementById(currentLocationType + '_lng');
        }
        
        if (inputField && latField && lngField) {
            inputField.value = selectedLocation.address;
            latField.value = selectedLocation.lat;
            lngField.value = selectedLocation.lng;
        }
        
        closeMapModal();
    } else {
        alert('Please select a location on the map first.');
    }
}

// Make functions globally available
window.toggleMobileMenu = toggleMobileMenu;
window.closeMobileMenu = closeMobileMenu;
window.openBookingModal = openBookingModal;
window.closeBookingModal = closeBookingModal;
window.handleLocationInput = handleLocationInput;
window.handleModalLocationInput = handleModalLocationInput;
window.closeMapModal = closeMapModal;
window.confirmLocation = confirmLocation;
window.useCurrentLocationInMap = useCurrentLocationInMap;
window.subscribeNewsletter = subscribeNewsletter;
window.applyNow = applyNow;
window.downloadApps = downloadApps;
window.toggleFAQ = toggleFAQ;