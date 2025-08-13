        <!-- Hero Section -->
        <section id="home" class="hero-section" style="--mobile-banner: url('{{ asset(\App\Models\PageContent::getContent('home', 'hero', 'mobile_banner', 'assets/hero-mobile-banner.jpg')) }}');">
            <div class="hero-container">
                <div class="hero-content">
                    <h1 class="hero-title">{{ \App\Models\PageContent::getContent('home', 'hero', 'title', 'Book. Ride. Arrive in Luxury.') }}</h1>
                    
                    <form id="bookingForm" class="booking-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select id="city" name="city" required>
                                    <option value="">Select City</option>
                                    <option value="Abu Dhabi">Abu Dhabi</option>
                                    <option value="Dubai">Dubai</option>
                                    <option value="Sharjah">Sharjah</option>
                                    <option value="Ajman">Ajman</option>
                                    <option value="Umm Al Quwain">Umm Al Quwain</option>
                                    <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                                    <option value="Fujairah">Fujairah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="date" required min="" class="date-input">
                            </div>
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" id="time" name="time" required class="time-input">
                            </div>
                        </div>
                        
                        <div class="location-row">
                            <div class="form-group">
                                <label for="pickup">Pickup Location</label>
                                <input type="text" id="pickup" name="pickup_location" placeholder="Getting current location..." onclick="handleLocationInput('pickup')" required readonly>
                                <input type="hidden" id="pickup_lat" name="pickup_lat">
                                <input type="hidden" id="pickup_lng" name="pickup_lng">
                            </div>
                            <div class="form-group">
                                <label for="dropoff">Drop-off Location</label>
                                <input type="text" id="dropoff" name="dropoff_location" placeholder="Click to select on map or type address" onclick="handleLocationInput('dropoff')" required readonly>
                                <input type="hidden" id="dropoff_lat" name="dropoff_lat">
                                <input type="hidden" id="dropoff_lng" name="dropoff_lng">
                            </div>
                        </div>

                        <div class="contact-row">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                            </div>
                        </div>
                        
                        <div class="form-bottom">
                            <button type="submit" class="see-prices-btn" id="submitBookingBtn">Book Now</button>
                        </div>
                    </form>
                </div>
                
                <div class="hero-image">
                    <img src="{{ asset(\App\Models\PageContent::getContent('home', 'hero', 'image', 'assets/travel-experience.png')) }}" alt="Travel Experience">
                </div>
            </div>
        </section>

        <!-- Feature Section -->
        <section class="features-section section">
            <div class="section-content">
                <div class="features-container">
                    <div class="feature-box">
                        <div class="feature-image">
                            <img src="{{ asset('assets/location-icon.png') }}" alt="Choose location">
                        </div>
                        <h3 class="feature-title">Choose location</h3>
                        <p class="feature-text">Choose your and find <br> your best car</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-image">
                            <img src="{{ asset('assets/date-icon.png') }}" alt="Pick-up date">
                        </div>
                        <h3 class="feature-title">Pick-up date</h3>
                        <p class="feature-text">Select your pick up date and  time to book your way</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-image">
                            <img src="{{ asset('assets/booking-icon.png') }}" alt="Book your way">
                        </div>
                        <h3 class="feature-title">Book your way</h3>
                        <p class="feature-text">Book your way and we will deliver  it directly to you</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section with Background Image -->
        <section class="benefits-section" style="--benefits-bg-desktop: url('{{ asset(\App\Models\PageContent::getContent('home', 'benefits', 'background_desktop', 'assets/hero-desktop.jpg')) }}'); --benefits-bg-mobile: url('{{ asset(\App\Models\PageContent::getContent('home', 'benefits', 'background_mobile', 'assets/benefits-mobile.jpg')) }}');">
            <div class="benefits-container">
                <!-- Title at the top -->
                <div class="benefits-title">
                    <h2>
                        <span class="line1">{{ \App\Models\PageContent::getContent('home', 'benefits', 'title_line1', 'Better Benefits') }} </span>
                        <span class="line2">{{ \App\Models\PageContent::getContent('home', 'benefits', 'title_line2', 'For Tawasul Limousine') }}</span>
                    </h2>
                </div>

                <!-- Benefits Content -->
                <div class="benefits-content">
                    <!-- Left Side Features -->
                    <div class="benefits-left">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="{{ asset('assets/24-7-icon.png') }}" alt="24/7 Availability">
                            </div>
                            <h3>24/7 Availability</h3>
                            <p>Tawasul Limo is available around the clock to serve you anytime, anywhere.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="{{ asset('assets/fleet-icon.png') }}" alt="Luxurious & Well-Maintained Fleet">
                            </div>
                            <h3>Luxurious & Well-Maintained Fleet</h3>
                            <p>Travel in style with our fleet of premium, meticulously maintained vehicles.</p>
                        </div>
                         <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="{{ asset('assets/chauffeur-icon.png') }}" alt="Professional Chauffeurs">
                            </div>
                            <h3>Professional Chauffeurs</h3>
                            <p>Our experienced chauffeurs ensure a smooth, respectful, and professional journey every time.</p>
                        </div>
                    </div>

                    <!-- Right Side Features -->
                    <div class="benefits-right">
                         <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="{{ asset('assets/service-icon.png') }}" alt="Personalized Customer Service">
                            </div>
                            <h3>Personalized Customer Service</h3>
                            <p>We tailor every ride to your needs with attentive, personalized service.</p>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="{{ asset('assets/pricing-icon.png') }}" alt="Transparent Pricing">
                            </div>
                            <h3>Transparent Pricing</h3>
                            <p>Enjoy peace of mind with our clear, upfront pricing and no hidden charges.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <img src="{{ asset('assets/safety-icon.png') }}" alt="Commitment to Safety and Privacy">
                            </div>
                            <h3>Commitment to Safety and Privacy</h3>
                            <p>Your safety and privacy are our top priorities throughout your journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 4 - Updated with new container design -->
        <section class="section-4">
            <div class="section-4-content">
                <div class="section-4-container" style="--section4-bg-desktop: url('{{ asset(\App\Models\PageContent::getContent('home', 'section4', 'background_desktop', 'assets/section4-desktop.jpg')) }}'); --section4-bg-mobile: url('{{ asset(\App\Models\PageContent::getContent('home', 'section4', 'background_mobile', 'assets/section4-mobile.jpg')) }}');">
                    <div class="section-4-content-wrapper">
                        <div class="section-4-text-container">
                            <p style="font-size: 30px; font-weight: 100 !important;">{{ \App\Models\PageContent::getContent('home', 'section4', 'title', 'Apply And Start Reaping The Benefits Of Using Tawasul Limousine For business') }}</p>
                            <button class="apply-now-btn" onclick="applyNow()">{{ \App\Models\PageContent::getContent('home', 'section4', 'button_text', 'Apply Now') }}  → </button>
                        </div>
                    </div>
                    
                    <!-- Footer inside the container -->
                    <div class="section-4-footer">
                        <div class="section-4-footer-left">
                            <div class="section-4-footer-logo">
                                <img src="{{ asset(\App\Models\PageContent::getContent('home', 'section4', 'logo', 'assets/logo.png')) }}" alt="Travel Logo">
                            </div>
                            <div class="section-4-footer-text">
                                {{ \App\Models\PageContent::getContent('home', 'section4', 'footer_text', 'Rating Tawasul Limousine on Google Play and App Store') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section section">
            <div class="section-content">
                <h2>Frequently Asked Questions</h2>
                
                <div class="faq-container">
                    <div class="faq-column">
                        <div class="faq-item active">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">×</span>
                                <span>How can I book a ride with Tawasul Limo?</span>
                            </div>
                            <div class="faq-answer">
                                <p>You can book your ride by calling our call center 600 55 95 95 or by sending your details to support@tawasullimo.ae.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">+</span>
                                <span>Is your service available 24/7?</span>
                            </div>
                            <div class="faq-answer">
                                <p>Yes, Tawasul Limo operates 24 hours a day, 7 days a week, including holidays.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">+</span>
                                <span>What information do I need to provide to book a ride?</span>
                            </div>
                            <div class="faq-answer">
                                <p>Please share your name, pickup location, drop-off location, date, time, and number of passengers when you contact us.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">+</span>
                                <span>How do I know if my booking is confirmed?</span>
                            </div>
                            <div class="faq-answer">
                                <p>You will receive a confirmation by email or phone once your booking is processed.</p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-column">
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">+</span>
                                <span>Can I make changes to my booking?</span>
                            </div>
                            <div class="faq-answer">
                              <p>Yes, just contact our support team via phone or email and we'll assist you with any changes.</p>                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">+</span>
                                <span>What types of vehicles do you offer?</span>
                            </div>
                            <div class="faq-answer">
                                <p>
                                    We provide a luxurious fleet of sedans, SUVs, and executive vehicles — all clean, comfortable, and well-maintained.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">+</span>
                                <span>Are your drivers trained and professional?</span>
                            </div>
                            <div class="faq-answer">
                                <p>
                                    Absolutely. All our chauffeurs are licensed, experienced, and professionally trained to ensure a safe and pleasant journey.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span class="faq-icon">+</span>
                                <span>How can I share feedback or a complaint?</span>
                            </div>
                            <div class="faq-answer">
                                <p>You can email us anytime at support@tawasullimo.ae or call our customer care team directly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>