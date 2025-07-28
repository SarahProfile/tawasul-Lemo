@extends('layouts.app')

@section('title', 'Contact Us - Tawasul Limousine')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
<style>
    /* Contact Page Styles */
    
    /* Section One - Banner */
    .contact-banner-section {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 46%;
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    
    .contact-banner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset(\App\Models\PageContent::getContent('contact', 'banner', 'background_image', 'assets/contact-banner.jpg')) }}') no-repeat center center;
        background-size: cover;
        background-attachment: scroll;
        z-index: 1;
    }
    
    /* Section Two - Get in Touch */
    .get-in-touch-section {
        background: #FFFFFF;
        position: relative;
        z-index: 2;
        margin-top: -200px;
        padding: 2rem 0 4rem 0;
        width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .get-in-touch-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .get-in-touch-title {
        text-align: center;
        font-size: clamp(3rem, 6vw, 4rem);
        font-weight: 300;
        color: #000000;
        margin-bottom: 3rem;
        background: #FFFFFF;
        padding: 1.5rem 2rem;
        border-radius: 10px;
        display: inline-block;
        width: auto;
        margin-left: 50%;
        transform: translateX(-50%);
        line-height: 1.2;
    }
    
    .contact-content {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    
    .map-container {
        width: 100%;
        height: 600px;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    
    .contact-form-container {
        background: #000000;
        border-radius: 5px;
        padding: 3rem;
        position: relative;
    }
    
    .form-title {
        color: #FFFFFF;
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 2rem;
        text-align: right;
    }
    
    .contact-form {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    
    .form-field {
        position: relative;
    }
    
    .form-field label {
        display: block;
        color: #FFFFFF;
        font-size: 1rem;
        font-weight: 400;
        margin-bottom: 0.5rem;
    }
    
    .form-field input,
    .form-field textarea {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1px solid #A1A1A1;
        color: #FFFFFF;
        font-size: 1rem;
        font-weight: 100;
        padding: 0.8rem 0;
        outline: none;
        transition: border-color 0.3s ease;
    }
    
    .form-field input::placeholder,
    .form-field textarea::placeholder {
        color: #A1A1A1;
        font-weight: 100;
    }
    
    .form-field input:focus,
    .form-field textarea:focus {
        border-bottom-color: #FFFFFF;
    }
    
    .form-field textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .submit-btn {
        background: #FFFFFF;
        color: #000000;
        border: none;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 0px;
        cursor: pointer;
        transition: all 0.3s ease;
        align-self: center;
        width: 100%;
        max-width: 100%;
    }
    
    .submit-btn:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .contact-banner-section {
            padding-bottom: 75%;
        }
        
        .get-in-touch-section {
            margin-top: -50px;
            padding: 1.5rem 0 3rem 0;
            width: 100%;
        }
        
        .get-in-touch-container {
            padding: 0 0.75rem;
        }
        
        .get-in-touch-title {
            font-size: 1.8rem;
            margin-bottom: 2rem;
            padding: 0.8rem 1.5rem;
        }
        
        .contact-content {
            gap: 0;
        }
        
        .map-container {
            height: 450px;
        }
        
        .contact-form-container {
            padding: 2rem;
        }
        
        .form-title {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .contact-form {
            gap: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .get-in-touch-container {
            padding: 0 0.5rem;
        }
        
        .get-in-touch-title {
            font-size: 1.6rem;
            padding: 0.6rem 1rem;
        }
        
        .map-container {
            height: 350px;
        }
        
        .contact-form-container {
            padding: 1.5rem;
        }
        
        .form-title {
            font-size: 1.2rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Section One: Banner -->
    <section class="contact-banner-section">
    </section>
    
    <!-- Section Two: Get in Touch -->
    <section class="get-in-touch-section">
        <div class="get-in-touch-container">
            <h1 class="get-in-touch-title">{!! nl2br(\App\Models\PageContent::getContent('contact', 'get_in_touch', 'title', "Get in\ntouch")) !!}</h1>
            
            <div class="contact-content">
                <!-- Map Container -->
                <div class="map-container">
                    @if($contactLocation)
                        <iframe 
                            src="{{ $contactLocation->map_embed_url }}" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            <div class="text-center">
                                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No location configured</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2 class="form-title" style="text-align: left;">{{ \App\Models\PageContent::getContent('contact', 'get_in_touch', 'form_title', 'Send a Message') }}</h2>
                    
                    <form class="contact-form" id="contactForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="form-field">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" required>
                        </div>
                        
                        <div class="form-field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Your@email.com" required>
                        </div>
                        
                        <div class="form-field">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="+1234567890" required>
                        </div>
                        
                        <div class="form-field">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Tell Us About Your Project" required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section Three: Apply for Business (Same as Home Section 4) -->
    <section class="section-4">
        <div class="section-4-content">
            <div class="section-4-container">
                <div class="section-4-content-wrapper">
                    <div class="section-4-text-container">
                        <p style="font-size: 30px; font-weight: 100 !important;">Apply And Start Reaping The Benefits Of Using Tawasul <br> Limousine For business</p>
                        <button class="apply-now-btn" onclick="applyNow()">Apply Now  → </button>
                    </div>
                </div>
                
                <!-- Footer inside the container -->
                <div class="section-4-footer">
                    <div class="section-4-footer-left">
                        <div class="section-4-footer-logo">
                            <img src="{{ asset('assets/logo.png') }}" alt="Travel Logo">
                        </div>
                        <div class="section-4-footer-text">
                            Rating Tawasul Limousine<br>
                            on Google Play and App Store
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Four: FAQ (Same as Home Section 5) -->
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
@endsection

@push('scripts')
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    const submitBtn = this.querySelector('.submit-btn');
    
    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending...';
    
    // Simple validation
    const name = formData.get('name');
    const email = formData.get('email');
    const phone = formData.get('phone');
    const message = formData.get('message');
    
    if (!name || !email || !phone || !message) {
        alert('Please fill in all fields');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Send Message';
        return;
    }
    
    // Send data to server
    fetch('{{ route("contact.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            this.reset();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error sending your message. Please try again.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Send Message';
    });
});

function applyNow() {
    // Handle apply now button click for business
    alert('Applying for business benefits');
    // Here you can add functionality to redirect to business application form
}

function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const isActive = faqItem.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
        item.querySelector('.faq-icon').textContent = '+';
    });
    
    // If this item wasn't active, open it
    if (!isActive) {
        faqItem.classList.add('active');
        element.querySelector('.faq-icon').textContent = '×';
    }
}
</script>
@endpush