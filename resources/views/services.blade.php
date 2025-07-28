@extends('layouts.app')

@section('title', 'Services - Tawasul Limousine')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
<style>
    /* Services Page Styles */
    
    /* Section One - Banner */
    .services-banner-section {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    
    .services-banner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset(\App\Models\PageContent::getContent('services', 'banner', 'background_image', 'assets/services-banner.jpg')) }}') no-repeat center center;
        background-size: cover;
        background-attachment: scroll;
        z-index: 1;
    }
    
    .services-banner-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
    }
    
    .services-banner-container {
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
    
    .services-banner-content {
        max-width: 600px;
        color: white;
        z-index: 2;
    }
    
    .services-banner-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 300;
        margin-bottom: 2rem;
        line-height: 1.2;
        color: white;
    }
    
    .services-banner-text {
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
        margin-top: 0;
        z-index: 3;
    }
    
    .looping-text-content {
        display: inline-flex;
        align-items: center;
        animation: scroll-text 15s linear infinite;
        font-size: 1.4rem;
        font-weight: 400;
        white-space: nowrap;
        width: calc(200%);
    }
    
    .looping-text-content span {
        display: inline-flex;
        align-items: center;
        margin-right: 2rem;
    }
    
    .looping-icon {
        height: 18px;
        width: auto;
        margin: 0 1rem;
        filter: brightness(0) invert(1);
    }
    
    @keyframes scroll-text {
        0% {
            transform: translateX(0%);
        }
        100% {
            transform: translateX(-50%);
        }
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .services-banner-section {
            padding-bottom: 75%; /* Adjust for mobile aspect ratio */
        }
        
        .services-banner-section::before {
            background-size: cover;
        }
        
        .services-banner-container {
            padding: 6rem 1rem 4rem 1rem;
        }
        
        .services-banner-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .services-banner-text {
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
        .services-banner-container {
            padding: 0 0.75rem;
        }
        
        .services-banner-title {
            font-size: 1.8rem;
        }
        
        .services-banner-text {
            font-size: 0.9rem;
        }
        
        .looping-text-content {
            font-size: 0.9rem;
        }
    }
    
    /* Section Two - Service Selection */
    .services-selection-section {
        padding: 4rem 0rem 0rem 0rem;
        background: #FFFFFF;
    }
    
    .services-selection-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    
    .services-selection-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .services-selection-content {
        padding: 2rem 0;
    }
    
    .services-selection-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 300;
        color: #000000;
        margin-bottom: 2rem;
        line-height: 1.2;
    }
    
    .services-selection-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #6D6D6D;
        font-weight: lighter;
        margin-bottom: 2rem;
    }
    
    .services-boxes-container {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .service-box {
        background: #F3F3F3;
        border-radius: 10px;
        padding: 1.5rem;
        position: relative;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        background-size: 50px 50px;
        background-repeat: no-repeat;
        background-position: calc(100% - 15px) 15px;
        min-height: 120px;
    }
    
    .service-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .service-box.luxury-selection {
        background-image: url('{{ asset('assets/luxury-selection-icon.jpg') }}'), linear-gradient(to bottom, #F3F3F3, #F3F3F3);
    }
    
    .service-box.day-to-day {
        background-image: url('{{ asset('assets/day-to-day-icon.jpg') }}'), linear-gradient(to bottom, #F3F3F3, #F3F3F3);
    }
    
    .service-box.exclusive-request {
        background-image: url('{{ asset('assets/exclusive-request-icon.jpg') }}'), linear-gradient(to bottom, #F3F3F3, #F3F3F3);
    }
    
    .service-box-content {
        position: relative;
        z-index: 2;
        max-width: 70%;
    }
    
    .service-box-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #000000;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    
    .service-box-text {
        font-size: 0.9rem;
        color: #6D6D6D;
        font-weight: lighter;
        line-height: 1.4;
        margin: 0;
    }
    
    /* Mobile Services Selection Section */
    @media (max-width: 768px) {
        .services-selection-section {
            padding: 4rem 0;
        }
        
        .services-selection-container {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 0 0.75rem;
        }
        
        .services-selection-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .services-selection-text {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .services-boxes-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .service-box {
            padding: 1.2rem;
            min-height: 100px;
        }
        
        .service-box-content {
            max-width: 65%;
        }
        
        .service-box-title {
            font-size: 1rem;
        }
        
        .service-box-text {
            font-size: 0.85rem;
        }
    }
    
    @media (max-width: 480px) {
        .services-selection-container {
            padding: 0 0.5rem;
        }
        
        .services-selection-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        
        .services-selection-text {
            font-size: 0.85rem;
        }
        
        .service-box {
            padding: 1rem;
            min-height: 90px;
        }
        
        .service-box-content {
            max-width: 60%;
        }
        
        .service-box-title {
            font-size: 0.95rem;
        }
        
        .service-box-text {
            font-size: 0.8rem;
        }
    }
    
    /* Section Three - Fleet Excellence */
    .fleet-excellence-section {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 36%;
        background: url('{{ asset('assets/services-section3-bg.jpg') }}') no-repeat center center;
        background-size: contain;
        background-attachment: scroll;
        color: white;
        overflow: hidden;
    }
    
    .fleet-excellence-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
    }
    
    .fleet-excellence-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        align-items: center;
        width: 100%;
        height: 100%;
    }
    
    .fleet-excellence-left {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    
    .fleet-excellence-title {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 300;
        color: white;
        line-height: 1.2;
        text-align: left;
        margin: 0;
    }
    
    .fleet-excellence-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    
    .fleet-excellence-text {
        font-size: 14px;
        line-height: 1.6;
        color: #929292;
        font-weight: 100;
        margin: 0;
        max-width: 60%;
        margin-left: auto;
        margin-right: 1rem;
        padding: 1rem 0;
    }
    
    /* Mobile Fleet Excellence Section */
    @media (max-width: 768px) {
        .fleet-excellence-section {
            padding: 4rem 0;
        }
        
        .fleet-excellence-container {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 0 0.75rem;
            text-align: center;
        }
        
        .fleet-excellence-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .fleet-excellence-text {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        .fleet-excellence-container {
            padding: 0 0.5rem;
        }
        
        .fleet-excellence-title {
            font-size: 1.8rem;
        }
        
        .fleet-excellence-text {
            font-size: 0.85rem;
        }
    }
    
    /* Section Four - Range of Luxury Vehicles */
    .luxury-vehicles-section {
        padding: 4rem 0;
        background: #FFFFFF;
    }
    
    .luxury-vehicles-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: flex-start;
    }
    
    .luxury-vehicles-left {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .luxury-vehicles-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 300;
        color: #000000;
        line-height: 1.2;
        margin-bottom: 2rem;
    }
    
    .luxury-vehicles-image-container {
        width: 100%;
    }
    
    .luxury-vehicles-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .luxury-vehicles-right {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        margin-top: 0;
        height: auto;
        min-height: 500px;
    }
    
    .vehicles-list {
        width: 100%;
        max-width: 400px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        min-height: 500px;
    }
    
    .vehicle-item {
        display: flex;
        align-items: center;
        position: relative;
        flex: 1;
        margin-bottom: 0;
    }
    
    .vehicle-number {
        font-size: 0.8rem;
        font-weight: 100;
        color: #A2A2A2;
        margin-right: 1.5rem;
        min-width: 20px;
    }
    
    .vehicle-name {
        font-size: 1.3rem;
        font-weight: 400;
        color: #707070;
        flex-grow: 1;
        margin-bottom: 0.5rem;
    }
    
    .vehicle-line {
        position: absolute;
        bottom: -0.5rem;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #E0E0E0;
    }
    
    /* Mobile Luxury Vehicles Section */
    @media (max-width: 768px) {
        .luxury-vehicles-section {
            padding: 4rem 0;
        }
        
        .luxury-vehicles-container {
            grid-template-columns: 1fr;
            gap: 3rem;
            padding: 0 0.75rem;
        }
        
        .luxury-vehicles-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .luxury-vehicles-left {
            align-items: center;
        }
        
        .vehicle-number {
            font-size: 0.75rem;
            margin-right: 1.2rem;
        }
        
        .vehicle-name {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .luxury-vehicles-container {
            padding: 0 0.5rem;
            gap: 2rem;
        }
        
        .luxury-vehicles-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        
        .vehicle-number {
            font-size: 0.7rem;
            margin-right: 1rem;
        }
        
        .vehicle-name {
            font-size: 0.9rem;
        }
    }
    
    /* Section Five - Our Services */
    .our-services-section {
        padding: 4rem 0;
        background: #FFFFFF;
    }
    
    .our-services-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: flex-start;
    }
    
    .our-services-left {
        width: 100%;
    }
    
    .our-services-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .our-services-right {
        display: flex;
        flex-direction: column;
    }
    
    .our-services-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 300;
        color: #000000;
        line-height: 1.2;
        margin-bottom: 2rem;
    }
    
    .services-lists-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
    
    .services-left-list,
    .services-right-list {
        display: flex;
        flex-direction: column;
    }
    
    .service-item {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .service-item:last-child {
        margin-bottom: 0;
    }
    
    .service-name {
        font-size: 1rem;
        font-weight: 400;
        color: #707070;
        line-height: 1.4;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .service-line {
        width: 100%;
        height: 1px;
        background-color: #E0E0E0;
        margin-top: 0.5rem;
    }
    
    /* Mobile Our Services Section */
    @media (max-width: 768px) {
        .our-services-section {
            padding: 4rem 0;
        }
        
        .our-services-container {
            grid-template-columns: 1fr;
            gap: 3rem;
            padding: 0 0.75rem;
        }
        
        .our-services-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .services-lists-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .service-name {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        .our-services-container {
            padding: 0 0.5rem;
            gap: 2rem;
        }
        
        .our-services-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        
        .services-lists-container {
            gap: 1.5rem;
        }
        
        .service-name {
            font-size: 0.85rem;
        }
        
        .service-item {
            margin-bottom: 1.5rem;
        }
    }
    
    /* Section Six - Our Technology */
    .our-technology-section {
        padding: 4rem 0;
        background: #FFFFFF;
    }
    
    .our-technology-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: flex-start;
    }
    
    .our-technology-left {
        display: flex;
        flex-direction: column;
    }
    
    .our-technology-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 300;
        color: #000000;
        line-height: 1.2;
        margin-bottom: 2rem;
    }
    
    .technology-lists-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
    
    .technology-left-list,
    .technology-right-list {
        display: flex;
        flex-direction: column;
    }
    
    .technology-item {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .technology-item:last-child {
        margin-bottom: 0;
    }
    
    .technology-name {
        font-size: 1rem;
        font-weight: 400;
        color: #6D6D6D;
        line-height: 1.4;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .technology-line {
        width: 100%;
        height: 1px;
        background-color: #E0E0E0;
        margin-top: 0.5rem;
    }
    
    .our-technology-right {
        width: 100%;
    }
    
    .our-technology-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    
    /* Mobile Our Technology Section */
    @media (max-width: 768px) {
        .our-technology-section {
            padding: 4rem 0;
        }
        
        .our-technology-container {
            grid-template-columns: 1fr;
            gap: 3rem;
            padding: 0 0.75rem;
        }
        
        .our-technology-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .technology-lists-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .technology-name {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        .our-technology-container {
            padding: 0 0.5rem;
            gap: 2rem;
        }
        
        .our-technology-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        
        .technology-lists-container {
            gap: 1.5rem;
        }
        
        .technology-name {
            font-size: 0.85rem;
        }
        
        .technology-item {
            margin-bottom: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Section One: Banner -->
    <section class="services-banner-section">
        <div class="services-banner-container">
            <div class="services-banner-content">
                <h1 class="services-banner-title">{{ \App\Models\PageContent::getContent('services', 'banner', 'title', 'Setting a new standard in premium experience.') }}</h1>
                <p class="services-banner-text">
                    {{ \App\Models\PageContent::getContent('services', 'banner', 'description', 'Tawasul Limousine presents a renewed range of vehicles designed to suit every occasion, from executive travel to everyday convenience. Each vehicle combines luxury, comfort, and intelligent technology to deliver a seamless, elevated experience that meets the highest standards of modern mobility.') }}
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
    
    <!-- Section Two: Service Selection -->
    <section class="services-selection-section">
        <div class="services-selection-container">
            <div class="services-selection-image-container">
                <img src="{{ asset(\App\Models\PageContent::getContent('services', 'selection', 'image', 'assets/services-section2-left.jpg')) }}" alt="Service Selection" class="services-selection-image">
            </div>
            <div class="services-selection-content">
                <h2 class="services-selection-title">{{ \App\Models\PageContent::getContent('services', 'selection', 'title', 'Tailored luxury for every journey') }}</h2>
                <p class="services-selection-text">
                    {{ \App\Models\PageContent::getContent('services', 'selection', 'description_1', 'At Tawasul Limousine, every vehicle in our fleet is chosen with purpose. Our Luxury Selection is crafted for moments that demand more than just transportation. These are vehicles where sophistication meets indulgence, ideal for formal occasions, executive transfers, or any instance where presence matters.') }}
                </p>
                <p class="services-selection-text">
                    {{ \App\Models\PageContent::getContent('services', 'selection', 'description_2', 'For everyday travel, our Day-to-Day Selection offers a seamless blend of comfort and elevated style, ensuring that routine journeys still feel refined. For clients with unique needs or preferences, additional premium models are available upon request, allowing us to deliver a truly bespoke experience.') }}
                </p>
                
                <div class="services-boxes-container">
                    <div class="service-box luxury-selection">
                        <div class="service-box-content">
                            <h3 class="service-box-title">Luxury Selection</h3>
                            <p class="service-box-text">Where sophistication meets indulgence.</p>
                        </div>
                    </div>
                    
                    <div class="service-box day-to-day">
                        <div class="service-box-content">
                            <h3 class="service-box-title">Day to Day<br>Selection</h3>
                            <p class="service-box-text">Effortless comfort with elevated style.</p>
                        </div>
                    </div>
                    
                    <div class="service-box exclusive-request">
                        <div class="service-box-content">
                            <h3 class="service-box-title">Exclusive<br>by Request</h3>
                            <p class="service-box-text">Premium models tailored to your specific needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section Three: Fleet Excellence -->
    <section class="fleet-excellence-section">
        <div class="fleet-excellence-container">
            <div class="fleet-excellence-left">
                <h2 class="fleet-excellence-title">{{ \App\Models\PageContent::getContent('services', 'fleet', 'title', 'Fleet of Excellence') }}</h2>
            </div>
            <div class="fleet-excellence-right">
                <p class="fleet-excellence-text">
                    What sets Tawasul Limousine apart is not just the elegance of its vehicles, but the thoughtfulness behind every option. Our fleet is meticulously curated to cater to diverse needs, whether it's the refined luxury of our high-end models or the elevated ease of our day-to-day selection.
                    <br><br>
                    Each vehicle is maintained to the highest standards and equipped with advanced infotainment, smart safety systems, and discreet chauffeurs. For clients seeking something truly exceptional, bespoke premium models are available upon request, ensuring that no journey feels ordinary. At Tawasul, every ride is a reflection of precision, comfort, and class.
                </p>
            </div>
        </div>
    </section>
    
    <!-- Section Four: Range of Luxury Vehicles -->
    <section class="luxury-vehicles-section">
        <div class="luxury-vehicles-container">
            <div class="luxury-vehicles-left">
                <h2 class="luxury-vehicles-title">{{ \App\Models\PageContent::getContent('services', 'luxury_vehicles', 'title', 'Range of Luxury Vehicles') }}</h2>
                <div class="luxury-vehicles-image-container">
                    <img src="{{ asset(\App\Models\PageContent::getContent('services', 'luxury_vehicles', 'image', 'assets/luxury-vehicles-range.jpg')) }}" alt="Range of Luxury Vehicles" class="luxury-vehicles-image">
                </div>
            </div>
            <div class="luxury-vehicles-right">
                <div class="vehicles-list">
                    <div class="vehicle-item">
                        <span class="vehicle-number">01</span>
                        <span class="vehicle-name">Standard Luxury Sedan</span>
                        <div class="vehicle-line"></div>
                    </div>
                    <div class="vehicle-item">
                        <span class="vehicle-number">02</span>
                        <span class="vehicle-name">Seater-7 Standard Luxury</span>
                        <div class="vehicle-line"></div>
                    </div>
                    <div class="vehicle-item">
                        <span class="vehicle-number">03</span>
                        <span class="vehicle-name">Premium Luxury SUV & Sedan</span>
                        <div class="vehicle-line"></div>
                    </div>
                    <div class="vehicle-item">
                        <span class="vehicle-number">04</span>
                        <span class="vehicle-name">Luxury MPV & Luxury Bus</span>
                        <div class="vehicle-line"></div>
                    </div>
                    <div class="vehicle-item">
                        <span class="vehicle-number">05</span>
                        <span class="vehicle-name">Electric Luxury Sedan</span>
                        <div class="vehicle-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section Five: Our Services -->
    <section class="our-services-section">
        <div class="our-services-container">
            <div class="our-services-left">
                <img src="{{ asset(\App\Models\PageContent::getContent('services', 'our_services', 'image', 'assets/section5-image.jpg')) }}" alt="Our Services" class="our-services-image">
            </div>
            <div class="our-services-right">
                <h2 class="our-services-title">{{ \App\Models\PageContent::getContent('services', 'our_services', 'title', 'Our Services') }}</h2>
                <div class="services-lists-container">
                    <div class="services-left-list">
                        <div class="service-item">
                            <span class="service-name">Airport Transfers (Arrivals & Departures)</span>
                            <div class="service-line"></div>
                        </div>
                        <div class="service-item">
                            <span class="service-name">Corporate and Executive Chauffeur</span>
                            <div class="service-line"></div>
                        </div>
                        <div class="service-item">
                            <span class="service-name">Hotel Transfers</span>
                            <div class="service-line"></div>
                        </div>
                        <div class="service-item">
                            <span class="service-name">Chauffeur Services</span>
                            <div class="service-line"></div>
                        </div>
                        <div class="service-item">
                            <span class="service-name">Event and Protocol Transport</span>
                            <div class="service-line"></div>
                        </div>
                    </div>
                    <div class="services-right-list">
                        <div class="service-item">
                            <span class="service-name">Long term & short-term Car rental with Driver</span>
                            <div class="service-line"></div>
                        </div>
                        <div class="service-item">
                            <span class="service-name">Customized Transport Solutions for Weddings, Conferences, and Special Occasions.</span>
                            <div class="service-line"></div>
                        </div>
                        <div class="service-item">
                            <span class="service-name">Sightseeing Tours</span>
                            <div class="service-line"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section Six: Our Technology -->
    <section class="our-technology-section">
        <div class="our-technology-container">
            <div class="our-technology-left">
                <h2 class="our-technology-title">{{ \App\Models\PageContent::getContent('services', 'technology', 'title', 'Our Technology') }}</h2>
                <div class="technology-lists-container">
                    <div class="technology-left-list">
                        <div class="technology-item">
                            <span class="technology-name">AI Powered dispatch and route optimization</span>
                            <div class="technology-line"></div>
                        </div>
                        <div class="technology-item">
                            <span class="technology-name">Real-time app based bookings</span>
                            <div class="technology-line"></div>
                        </div>
                        <div class="technology-item">
                            <span class="technology-name">Live vehicle tracking & ETA updates</span>
                            <div class="technology-line"></div>
                        </div>
                        <div class="technology-item">
                            <span class="technology-name">Seamless integration with hotels and airports</span>
                            <div class="technology-line"></div>
                        </div>
                    </div>
                    <div class="technology-right-list">
                        <div class="technology-item">
                            <span class="technology-name">Sustainable fleet with eco-conscious operations</span>
                            <div class="technology-line"></div>
                        </div>
                        <div class="technology-item">
                            <span class="technology-name">Automated dispatch for faster response times and fewer delays</span>
                            <div class="technology-line"></div>
                        </div>
                        <div class="technology-item">
                            <span class="technology-name">Secure digital payment and invoice system with instant receipts</span>
                            <div class="technology-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="our-technology-right">
                <img src="{{ asset(\App\Models\PageContent::getContent('services', 'technology', 'image', 'assets/section6-image.jpg')) }}" alt="Our Technology" class="our-technology-image">
            </div>
        </div>
    </section>
    
    <!-- Section Seven: Apply for Business (Same as Home Section 4) -->
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

    <!-- Section Eight: FAQ (Same as Home Section 5) -->
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