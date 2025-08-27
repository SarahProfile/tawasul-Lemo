@extends('layouts.app')

@section('title', 'Career - Tawasul Limousine')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
<style>
    /* Career Page Styles */
    
    /* Section One - Banner */
    .career-banner-section {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 46%;
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    
    .career-banner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset(\App\Models\PageContent::getContent('career', 'banner', 'background_image', 'assets/career-banner.jpg')) }}') no-repeat center center;
        background-size: cover;
        background-attachment: scroll;
        z-index: 1;
    }
    
    /* Section Two - Join Our Team */
    .join-team-section {
        background: #FFFFFF;
        position: relative;
        z-index: 2;
        margin-top: -200px;
        padding: 2rem 0 4rem 0;
        width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .join-team-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .join-team-title {
        text-align: center;
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 300;
        color: #000000;
        margin-bottom: 3rem;
        background: #FFFFFF;
        padding: 1rem 2rem;
        border-radius: 10px;
        display: inline-block;
        width: auto;
        margin-left: 50%;
        transform: translateX(-50%);
    }
    
    .career-boxes-container {
        display: flex;
        flex-direction: column;
        gap: 3rem;
    }
    
    .career-box {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: flex-start;
        background: #FFFFFF;
        border-radius: 15px;
        padding: 2rem;
        transition: all 0.3s ease;
    }
    
    .career-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .career-content {
        display: flex;
        flex-direction: column;
    }
    
    .career-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #000000;
        margin-bottom: 1.5rem;
        line-height: 1.3;
    }
    
    .career-list {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem 0;
    }
    
    .career-list li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
        font-size: 0.95rem;
        line-height: 1.5;
        color: #555555;
    }
    
    .career-list li:before {
        content: '•';
        position: absolute;
        left: 0;
        color: #000000;
        font-weight: bold;
    }
    
    .apply-btn {
        background: none;
        border: none;
        color: #000000;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0;
        text-decoration: none;
        transition: all 0.3s ease;
        align-self: flex-start;
    }
    
    .apply-btn:hover {
        color: #333333;
        transform: translateX(5px);
    }
    
    .apply-btn::after {
        content: '→';
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    
    .apply-btn:hover::after {
        transform: translateX(3px);
    }
    
    /* No Careers Empty State */
    .no-careers-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
        padding: 3rem 2rem;
    }
    
    .no-careers-content {
        text-align: center;
        max-width: 500px;
        background: #FFFFFF;
        border-radius: 15px;
        padding: 3rem 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    .no-careers-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        display: block;
    }
    
    .no-careers-title {
        font-size: 1.8rem;
        font-weight: 500;
        color: #000000;
        margin-bottom: 1rem;
    }
    
    .no-careers-description {
        font-size: 1rem;
        line-height: 1.6;
        color: #555555;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .career-banner-section {
            padding-bottom: 75%;
        }
        
        .join-team-section {
            margin-top: -50px;
            padding: 1.5rem 0 3rem 0;
        }
        
        .join-team-container {
            padding: 0 0.75rem;
        }
        
        .join-team-title {
            font-size: 1.8rem;
            margin-bottom: 2rem;
            padding: 0.8rem 1.5rem;
        }
        
        .career-boxes-container {
            gap: 2rem;
        }
        
        .career-box {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 1.5rem;
        }
        
        .career-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .career-list li {
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
        }
        
        .apply-btn {
            align-self: flex-start;
        }
        
        /* No Careers Mobile */
        .no-careers-container {
            min-height: 300px;
            padding: 2rem 1rem;
        }
        
        .no-careers-content {
            padding: 2rem 1.5rem;
        }
        
        .no-careers-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .no-careers-title {
            font-size: 1.5rem;
        }
        
        .no-careers-description {
            font-size: 0.95rem;
        }
    }
    
    @media (max-width: 480px) {
        .join-team-container {
            padding: 0 0.5rem;
        }
        
        .join-team-title {
            font-size: 1.6rem;
            padding: 0.6rem 1rem;
        }
        
        .career-box {
            padding: 1rem;
        }
        
        .career-title {
            font-size: 1.2rem;
        }
        
        .career-list li {
            font-size: 0.85rem;
            padding-left: 1.2rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Section One: Banner -->
    <section class="career-banner-section">
    </section>
    
    <!-- Section Two: Join Our Team -->
    <section class="join-team-section">
        <div class="join-team-container">
            <h1 class="join-team-title">{{ \App\Models\PageContent::getContent('career', 'join_team', 'title', 'Join Our Team') }}</h1>
            
            @if($careerPositions->isEmpty())
                <div class="no-careers-container">
                    <div class="no-careers-content">
                        <div class="no-careers-icon">
                            💼
                        </div>
                        <h3 class="no-careers-title">No Open Positions</h3>
                        <p class="no-careers-description">
                            We don't have any open positions at the moment, but we're always looking for talented individuals to join our team. Please check back later for new opportunities.
                        </p>
                    </div>
                </div>
            @else
            <div class="career-boxes-container">
                @foreach($careerPositions as $position)
                <div class="career-box">
                    <div class="career-image-container">
                        <img src="{{ asset($position->image) }}" alt="{{ $position->title }}" class="career-image">
                    </div>
                    <div class="career-content">
                        <h2 class="career-title">{{ $position->title }}</h2>
                        <ul class="career-list">
                            @foreach($position->responsibilities as $responsibility)
                                <li>{{ $responsibility }}</li>
                            @endforeach
                        </ul>
                        <button class="apply-btn" onclick="applyForPosition('{{ $position->title }}')">Apply Now</button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    
    <!-- Section Three: Apply for Business (Same as Home Section 4) -->
    <section class="section-4">
        <div class="section-4-content">
            <div class="section-4-container" style="--section4-bg-desktop: url('{{ asset(\App\Models\PageContent::getContent('career', 'section4', 'background_desktop', 'assets/section4-desktop.jpg')) }}'); --section4-bg-mobile: url('{{ asset(\App\Models\PageContent::getContent('career', 'section4', 'background_mobile', 'assets/section4-mobile.jpg')) }}');">
                <div class="section-4-content-wrapper">
                    <div class="section-4-text-container">
                        <p style="font-size: 30px; font-weight: 100 !important;">{{ \App\Models\PageContent::getContent('career', 'section4', 'title', 'Apply And Start Reaping The Benefits Of Using Tawasul Limousine For business') }}</p>
                        <button class="apply-now-btn" onclick="applyNow()">{{ \App\Models\PageContent::getContent('career', 'section4', 'button_text', 'Apply Now') }}  → </button>
                    </div>
                </div>
                
                <!-- Footer inside the container -->
                <div class="section-4-footer">
                    <div class="section-4-footer-left">
                        <div class="section-4-footer-logo">
                            <img src="{{ asset(\App\Models\PageContent::getContent('career', 'section4', 'logo', 'assets/logo.png')) }}" alt="Travel Logo">
                        </div>
                        <div class="section-4-footer-text">
                            {{ \App\Models\PageContent::getContent('career', 'section4', 'footer_text', 'Rating Tawasul Limousine on Google Play and App Store') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Four: FAQ (Same as Home Section 5) -->
    <section class="faq-section section" style="--faq-bg-desktop: url('{{ asset(\App\Models\PageContent::getContent('career', 'faq', 'background_desktop', 'assets/faq-desktop.jpg')) }}'); --faq-bg-mobile: url('{{ asset(\App\Models\PageContent::getContent('career', 'faq', 'background_mobile', 'assets/faq-mobile.jpg')) }}');">
        <div class="section-content">
            <h2>{{ \App\Models\PageContent::getContent('career', 'faq', 'title', 'Frequently Asked Questions') }}</h2>
            
            <div class="faq-container">
                <div class="faq-column">
                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="faq-icon">+</span>
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
function applyForPosition(position) {
    // Handle apply button click
    alert('Applying for position: ' + position);
    // Here you can add functionality to redirect to application form or send email
}

function applyNow() {
    // Handle apply now button click for business
    alert('Applying for business benefits');
    // Here you can add functionality to redirect to business application form
}

</script>
@endpush