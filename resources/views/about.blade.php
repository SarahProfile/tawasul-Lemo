@extends('layouts.app')

@section('title', 'About Us - Tawasul Limousine')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
<style>
    /* About Us Page Styles */
    
    /* Section One - Banner */
    .about-banner-section {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 46%;
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    
    .about-banner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset('assets/about-banner-new.jpg') }}') no-repeat center center;
        background-size: cover;
        background-attachment: scroll;
        z-index: 1;
    }
    
    .about-banner-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
    }
    
    .about-banner-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        max-width: 1400px;
        margin: 0 auto;
        padding: 8rem 1rem 6rem 1rem;
        width: 100%;
        display: flex;
        align-items: center;
        z-index: 3;
    }
    
    .about-banner-content {
        max-width: 600px;
        color: white;
        z-index: 2;
    }
    
    .about-banner-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 300;
        margin-bottom: 2rem;
        line-height: 1.2;
        color: white;
    }
    
    .about-banner-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #929292;
        font-weight: lighter;
        margin: 0;
    }
    
    /* Looping Text Bar */
    .looping-text-bar {
        background: #000000;
        color: white;
        padding: 1rem 0;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        width: 100%;
    }
    
    .looping-text-content {
        display: inline-flex;
        align-items: center;
        animation: scroll-text 15s linear infinite;
        font-size: 1.1rem;
        font-weight: 400;
        white-space: nowrap;
    }
    
    .looping-text-content span {
        display: inline-flex;
        align-items: center;
        margin-right: 1rem;
    }
    
    .looping-icon {
        width: auto;
        height: auto;
        margin: 0 1rem;
        filter: brightness(0) invert(1);
    }
    
    @keyframes scroll-text {
        0% {
            transform: translateX(0%);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .about-banner-section {
            padding-bottom: 75%; /* Adjust for mobile aspect ratio */
        }
        
        .about-banner-section::before {
            background-size: cover;
        }
        
        .about-banner-container {
            padding: 6rem 1rem 4rem 1rem;
        }
        
        .about-banner-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .about-banner-text {
            font-size: 1rem;
        }
        
        .looping-text-content {
            font-size: 1rem;
        }
        
        .looping-icon {
            width: auto;
            height: auto;
        }
    }
    
    @media (max-width: 480px) {
        .about-banner-container {
            padding: 0 0.75rem;
        }
        
        .about-banner-title {
            font-size: 1.8rem;
        }
        
        .about-banner-text {
            font-size: 0.9rem;
        }
        
        .looping-text-content {
            font-size: 0.9rem;
        }
    }
    
    /* Section Two - Vision */
    .vision-section {
        padding: 6rem 0;
        background: #FFFFFF;
    }
    
    .vision-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    
    .vision-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .vision-content {
        padding: 2rem 0;
    }
    
    .vision-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 300;
        color: #000000;
        margin-bottom: 2rem;
        line-height: 1.2;
    }
    
    .vision-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #6D6D6D;
        font-weight: lighter;
        margin: 0;
    }
    
    /* Mobile Vision Section */
    @media (max-width: 768px) {
        .vision-section {
            padding: 4rem 0;
        }
        
        .vision-container {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 0 0.75rem;
        }
        
        .vision-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .vision-text {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        .vision-container {
            padding: 0 0.5rem;
        }
        
        .vision-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        
        .vision-text {
            font-size: 0.85rem;
        }
    }
    
    /* Section Three - Mission */
    .mission-section {
        padding: 6rem 0;
        background: #FFFFFF;
    }
    
    .mission-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    
    .mission-content {
        padding: 2rem 0;
        order: 1;
    }
    
    .mission-image-container {
        order: 2;
    }
    
    .mission-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .mission-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 300;
        color: #000000;
        margin-bottom: 2rem;
        line-height: 1.2;
    }
    
    .mission-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #6D6D6D;
        font-weight: lighter;
        margin: 0;
    }
    
    /* Mobile Mission Section */
    @media (max-width: 768px) {
        .mission-section {
            padding: 4rem 0;
        }
        
        .mission-container {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 0 0.75rem;
        }
        
        .mission-content {
            order: 2;
        }
        
        .mission-image-container {
            order: 1;
        }
        
        .mission-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .mission-text {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        .mission-container {
            padding: 0 0.5rem;
        }
        
        .mission-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        
        .mission-text {
            font-size: 0.85rem;
        }
    }
    
    /* Section 4 - Updated with new container design */
    .section-4 {
        padding: 4rem 0;
        background: #FFFFFF !important;
    }
    
    .section-4-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .section-4-container {
        background: url('{{ asset('assets/section4-desktop.jpg') }}') no-repeat center center;
        background-size: contain;
        border-radius: 20px;
        position: relative;
        min-height: 500px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }
    
    .section-4-content-wrapper {
        width: 100%;
        display: flex;
        justify-content: flex-end;
        padding: 1rem 2rem;
        padding-bottom: 3rem;
    }
    
    .section-4-text-container {
        background: #00000063;
        padding: 2rem;
        border-radius: 15px;
        max-width: 500px;
        width: 100%;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        margin-bottom: 1rem;
    }
    
    .section-4-text-container h2 {
        font-size: 2rem;
        font-weight: 600;
        color: #000000;
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    
    .section-4-text-container p {
        font-size: 1rem;
        color: white;
        line-height: 1.2;
        margin-bottom: 2rem;
        flex: 1;
    }
    
    .apply-now-btn {
        background: #ffffff;
        color: rgb(0, 0, 0);
        padding: 1rem 2.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Sequel Sans', Arial, sans-serif;
        align-self: flex-end;
        width: auto;
    }
    
    /* Section 4 Footer inside container */
    .section-4-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: black;
        padding: 1rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .section-4-footer-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        justify-content: space-between;
    }
    
    .section-4-footer-logo img {
        height: 80px;
        width: auto;
    }
    
    .section-4-footer-text {
        color: #6D6D6D;
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    /* Mobile styles for Section 4 */
    @media (max-width: 768px) {
        .section-4 {
            padding: 2rem 0;
        }
    
        .section-4-content {
            padding: 0 0.75rem;
        }
    
        .section-4-container {
            min-height: 300px;
            border-radius: 15px;
            background: url('{{ asset('assets/section4-mobile.jpg') }}') no-repeat center center;
            background-size: cover;
        }
    
        .section-4-content-wrapper {
            padding: 2rem 1rem;
            justify-content: center;
            padding-bottom: 25rem;
        }
    
        .section-4-text-container {
            max-width: 100%;
            padding: 2rem;
            margin-bottom: 2rem;
        }
    
        .section-4-text-container h2 {
            font-size: 1.5rem;
            margin-bottom: 0.8rem;
        }
    
        .section-4-text-container p {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
    
        .apply-now-btn {
            padding: 0.8rem 2rem;
            font-size: 1rem;
            align-self: flex-end;
        }
    
        .section-4-footer {
            padding: 1rem;
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto auto auto auto;
            gap: 1rem;
            text-align: center;
        }
    
        .section-4-footer-logo {
            grid-row: 1;
            justify-self: center;
        }
    
        .section-4-footer-logo img {
            height: 60px;
        }
    
        .section-4-footer-text {
            grid-row: 2;
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 480px) {
        .section-4-content-wrapper {
            padding: 1.5rem 0.5rem;
            padding-bottom: 25rem;
        }
    
        .section-4-text-container {
            padding: 1.5rem;
            margin-bottom: 0;
        }
    
        .section-4-text-container h2 {
            font-size: 1.3rem;
        }
    
        .section-4-text-container p {
            font-size: 0.85rem;
        }
    
        .section-4-footer {
            padding: 0.8rem;
        }
    
        .section-4-footer-text {
            font-size: 0.75rem;
        }
    }
    
    /* FAQ Section Styles */
    .faq-section {
        padding: 4rem 0;
        background: #FFFFFF !important;
    }
    
    .faq-section h2 {
        text-align: center;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 300;
        margin-bottom: 3rem;
        color: #000000;
    }
    
    .faq-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    
    .faq-column {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .faq-item {
        background: #F5F5F5;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .faq-question {
        padding: 1.5rem 2rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 1rem;
        font-weight: 500;
        color: #000000;
        background: #EEEEEE;
        transition: background-color 0.3s ease;
    }
    
    .faq-icon {
        font-size: 1.5rem;
        font-weight: 300;
        color: #666666;
        transition: all 0.3s ease;
        flex-shrink: 0;
        margin-right: 1rem;
        width: 20px;
        text-align: center;
    }
    
    .faq-answer {
        padding: 0 2rem;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #EEEEEE;
    }
    
    .faq-item.active .faq-answer {
        padding: 0 2rem 1.5rem 4rem;
        max-height: 200px;
    }
    
    .faq-answer p {
        color: #666666;
        font-size: 0.9rem;
        line-height: 1.6;
        margin: 0;
    }
    
    .section-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        text-align: left;
    }
    
    /* Mobile FAQ Styles */
    @media (max-width: 768px) {
        .faq-section {
            padding: 2rem 0;
        }
    
        .faq-section h2 {
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }
    
        .faq-container {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 0 0.75rem;
        }
    
        .faq-question {
            padding: 1.2rem 1.5rem;
            font-size: 0.9rem;
        }
    
        .faq-icon {
            font-size: 1.3rem;
            margin-right: 0.5rem;
        }
    
        .faq-item.active .faq-answer {
            padding: 0 1.5rem 1.2rem 1.5rem;
        }
    
        .faq-answer p {
            font-size: 0.85rem;
        }
    }
    
    @media (max-width: 480px) {
        .faq-container {
            padding: 0 0.5rem;
        }
    
        .faq-question {
            padding: 1rem 1.2rem;
            font-size: 0.85rem;
        }
    
        .faq-item.active .faq-answer {
            padding: 0 1.2rem 1rem 1.2rem;
        }
    
        .faq-answer p {
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Section One: Banner -->
    <section class="about-banner-section">
        <div class="about-banner-container">
            <div class="about-banner-content">
                <h1 class="about-banner-title">Driven by Excellence</h1>
                <p class="about-banner-text">
                    Tawasul Limousine redefines premium transport in the UAE, offering luxury mobility services that blend elegance, safety, and innovation. Whether it's a corporate transfer, hotel pickup, or private ride, we deliver a seamless experience powered by smart technologies and elite customer service.
                </p>
            </div>
        </div>
    </section>
    
    <!-- Looping Text Bar -->
    <section class="looping-text-bar">
        <div class="looping-text-content">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
            <span>Your Journey, Our Privilege</span>
            <img src="{{ asset('assets/car-icon.png') }}" alt="Car Icon" class="looping-icon">
        </div>
    </section>
    
    <!-- Section Two: Vision -->
    <section class="vision-section">
        <div class="vision-container">
            <div class="vision-image-container">
                <img src="{{ asset('assets/vision-image.jpg') }}" alt="Our Vision" class="vision-image">
            </div>
            <div class="vision-content">
                <h2 class="vision-title">Our Vision</h2>
                <p class="vision-text">
                    To become the UAE's benchmark for luxury mobility by blending cutting-edge technology with refined services, delivering seamless, intelligent, and sustainable limousine experiences.
                </p>
            </div>
        </div>
    </section>
    
    <!-- Section Three: Mission -->
    <section class="mission-section">
        <div class="mission-container">
            <div class="mission-content">
                <h2 class="mission-title">Our Mission</h2>
                <p class="mission-text">
                    To deliver a world-class limousine experience powered by innovation. Using AI, real-time booking, and smart mobility solutions, we ensure every journey is safe, punctual, and luxuriously comfortable.
                </p>
            </div>
            <div class="mission-image-container">
                <img src="{{ asset('assets/mission-image.jpg') }}" alt="Our Mission" class="mission-image">
            </div>
        </div>
    </section>
    
    <!-- Section 4 - Updated with new container design -->
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
@endsection