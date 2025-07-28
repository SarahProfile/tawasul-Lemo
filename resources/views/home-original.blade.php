<!DOCTYPE html>
<html lang="en">
<head>
    <!-- this the 6 version -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elevated Travel Experience</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sequel+Sans:wght@400;600;700&display=swap');
        
        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            max-width: 100%;
        }

        /* Hide default browser date and time icons */
        .form-group input[type="date"]::-webkit-calendar-picker-indicator,
        .form-group input[type="time"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            position: absolute;
            right: 0;
            width: 2rem;
            height: 100%;
            cursor: pointer;
        }

        /* Google Places Autocomplete z-index fix */
        .pac-container {
            z-index: 10001 !important;
        }
        
        /* Map modal search input styling */
        #mapSearch {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Enhanced date and time inputs */
        .date-input, .time-input {
            position: relative;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 45px 12px 16px !important;
            font-size: 14px;
            font-family: 'Sequel Sans', Arial, sans-serif;
            color: #333;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .date-input:focus, .time-input:focus {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        /* Custom icons for date and time inputs */
        .date-input {
            background-image: url('{{ asset('assets/calendar-icon.png') }}');
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px;
        }

        .time-input {
            background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23666"%3E%3Cpath d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/%3E%3Cpath d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/%3E%3C/svg%3E');
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px;
        }

        /* Show native picker on hover/focus */
        .date-input::-webkit-calendar-picker-indicator,
        .time-input::-webkit-calendar-picker-indicator {
            position: absolute;
            right: 12px;
            width: 18px;
            height: 18px;
            opacity: 0;
            cursor: pointer;
        }

        .date-input:hover::-webkit-calendar-picker-indicator,
        .time-input:hover::-webkit-calendar-picker-indicator,
        .date-input:focus::-webkit-calendar-picker-indicator,
        .time-input:focus::-webkit-calendar-picker-indicator {
            opacity: 1;
        }

        /* City dropdown positioning fix */
        .form-group select {
            position: relative;
            z-index: 10000;
        }

        /* Fix dropdown positioning in mobile view */
        @media (max-width: 768px) {
            .form-group select {
                position: relative;
                z-index: 10001 !important;
                transform: none;
                top: 0;
                bottom: auto;
                appearance: menulist;
                -webkit-appearance: menulist;
                -moz-appearance: menulist;
            }
            
            /* Ensure dropdown opens downward below the field */
            .form-group {
                position: relative;
                overflow: visible;
            }
            
            /* Force dropdown to open downward */
            select option {
                direction: ltr;
            }
        }

        /* Location input mobile sizing adjustment */

        /* Mobile responsive styling for enhanced date and time inputs */
        @media (max-width: 768px) {
            .date-input, .time-input {
                padding: 10px 40px 10px 12px !important;
                font-size: 16px !important; /* Prevents zoom on iOS */
                background-size: 16px !important;
                background-position: right 10px center !important;
            }
            
            /* Location inputs mobile styling */
            #pickup, #dropoff {
                background-size: 16px !important;
                background-position: right 10px center !important;
                padding-right: 35px !important;
            }
        }
        @media (max-width: 480px) {
            .date-input, .time-input {
                padding: 8px 35px 8px 10px !important;
                font-size: 16px !important;
                background-size: 14px !important;
                background-position: right 8px center !important;
            }
            
            /* Location inputs mobile styling */
            #pickup, #dropoff {
                background-size: 14px !important;
                background-position: right 8px center !important;
                padding-right: 30px !important;
            }
        }

        body {
            font-family: 'Sequel Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: white;
        }
        
        /* Fixed Header Styles - More Reliable Than Sticky */
        header {
            background: #000000;
            color: white;
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 100%;
            transition: all 0.3s ease;
        }

        /* Enhanced scroll behavior */
         header.scrolled {
        background: #000000 !important; /* Force solid black */
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }

        /* Add top padding to body to compensate for fixed header */
        body {
            font-family: 'Sequel Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: white;
            height: auto;
            min-height: 100%;
            padding-top: 80px; /* Adjust based on header height */
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            padding: 0 1rem;
            gap: 2rem;
            width: 100%;
        }
        
        .logo img {
            width: 150px;
            height: auto;
        }
        
        nav {
            justify-self: center;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        nav a {
            color: #E1E1D5;
            text-decoration: none;
            transition: opacity 0.3s ease;
            font-size: 14px;
            font-weight: 400;
            white-space: nowrap;
        }
        
        nav a:hover {
            opacity: 0.8;
        }
        
        .header-buttons {
            display: flex;
            gap: 1rem;
            justify-self: end;
        }
        
        .header-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #E1E1D5;
            background: transparent;
            color: #E1E1D5;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            font-family: 'Sequel Sans', Arial, sans-serif;
            white-space: nowrap;
        }
        
        .header-btn.user-greeting {
            border: none;
            background: none;
            cursor: default;
        }
        
        .header-btn:hover {
            background: #e1e1d5a0;
            color: #E1E1D5;
        }
        
        .header-btn.primary {
            background: white;
            color: #000000;
        }
        
        .header-btn.primary:hover {
            background: #000000;
            color: #F5F5F5;
        }

        /* Mobile Menu Styles */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #E1E1D5;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 1001;
        }

        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background: #000000;
            z-index: 1001;
            transition: right 0.3s ease;
            padding: 2rem 1rem;
            box-shadow: -2px 0 10px rgba(0,0,0,0.3);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            color: #E1E1D5;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-menu ul {
            list-style: none;
            margin-top: 3rem;
        }

        .mobile-menu ul li {
            margin-bottom: 1.5rem;
        }

        .mobile-menu ul li a {
            color: #E1E1D5;
            text-decoration: none;
            font-size: 1.1rem;
            display: block;
            padding: 0.5rem 0;
            border-bottom: 1px solid #333;
        }

        .mobile-menu .mobile-menu-buttons {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        /* Hero Section */
        .hero-section {
            background: white;
            min-height: 70vh;
            display: flex;
            align-items: stretch;
            padding: 2rem 0;
            padding-top: 5rem;
            width: 100%;
        }
        
        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            padding: 0 1rem;
            width: 100%;
            align-items: center;
        }
        
        .hero-content {
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 300;
            margin-bottom: 2rem;
            line-height: 1.2;
            color: #000000;
        }
        
        .booking-form {
            background: transparent;
            margin-bottom: 2rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            color: #B6B6B6;
            font-weight: 400;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .form-group select,
        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="time"] {
            padding: 0.8rem 0;
            border: none;
            border-bottom: 1px solid #CCCCCC;
            border-radius: 0;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background: transparent;
            color: #000000;
            width: 100%;
            appearance: none;
            cursor: pointer;
            background-image: url('{{ asset('assets/calendar-icon.png') }}') !important;
            background-repeat: no-repeat;
            background-position: right 0 center;
            background-size: 1rem;
            padding-right: 2rem;
        }

        /* Standard placeholder styling for all inputs */
        .form-group input::placeholder {
            color: #B6B6B6;
            opacity: 1;
        }

        /* Black placeholder color for date and time fields */
        .form-group input[name="date"]::placeholder,
        .form-group input[name="time"]::placeholder {
            color: #000000;
            opacity: 1;
        }

        /* Override date and time input icons on mobile */
        @media (max-width: 768px) {
            .form-group input[type="date"],
            .form-group input[type="time"] {
                background-image: url('{{ asset('assets/calendar-icon.png') }}') !important;
                background-size: 0.6rem !important;
                padding-right: 1rem !important;
            }
        }

        @media (max-width: 480px) {
            .form-group input[type="date"],
            .form-group input[type="time"] {
                background-image: url('{{ asset('assets/calendar-icon.png') }}') !important;
                background-size: 0.5rem !important;
                padding-right: 0.8rem !important;
            }
        }
        
        .form-group select:focus,
        .form-group input:focus {
            outline: none;
            border-bottom-color: #000000;
        }
        
        .location-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        
        .form-bottom {
            display: flex;
            flex-direction: row;
            gap: 2rem;
            align-items: flex-start;
            margin-top: 2rem;
        }
        
        .see-prices-btn {
            background: #000000;
            color: white;
            padding: 0.8rem 2rem;
           border-width: 1px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Sequel Sans', Arial, sans-serif;
            min-width: 150px;
        }
        
        .see-prices-btn:hover {
            background: #ffffff;
            color:#000000;
            border-color: black;
         
        }
        
        .login-link {
            color: #5D5D5D;
            text-decoration: underline;
            font-size: 0.9rem;
            cursor: pointer;
            transition: color 0.3s ease;
            padding-top: 6px;
        }
        
        .app-downloads {
            display: flex;
            gap: 1rem;
            justify-content: flex-start;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .app-button {
            display: inline-block;
            transition: transform 0.3s ease;
        }
        
        .app-button img {
            height: 50px;
            width: auto;
            display: block;
        }
        
        .hero-image {
            position: relative;
            height: 100%;
            min-height: 400px;
            width: 100%;
            overflow: hidden;
            background: #f0f0f0;
            border-radius: 10px;
        }
        
        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        /* Mobile-specific hero image */
        @media (max-width: 768px) {
            .hero-image img {
                content: url('{{ asset('assets/hero-mobile.jpg') }}');
            }
        }
        
        /* Features Section */
        .features-section {
            padding: 4rem 0;
            background: #F5F5F5;
        }

        .features-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4rem;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .feature-box {
            background: #F3F3F3;
            padding: 4rem 2.5rem;
            border-radius: 18px;
            text-align: center;
            border: none;
        }

        .feature-image {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 100;
            color: #000000;
            margin-bottom: 0.8rem;
            font-family: 'Sequel Sans', Arial, sans-serif;
        }

        .feature-text {
            font-size: 0.9rem;
            color: #6D6D6D;
            line-height: 1.6;
            margin: 0;
        }

        /* Mobile Features Slider - Updated for 2 full + 20% of third */
        @media (max-width: 768px) {
            .features-container {
                display: flex;
                overflow-x: auto;
                scroll-behavior: smooth;
                scroll-snap-type: x mandatory;
                gap: 2rem;
                padding: 0 1rem;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .features-container::-webkit-scrollbar {
                display: none;
            }

            .feature-box {
                min-width: 36%;
                max-width: 39% !important;
                flex-shrink: 0;
                scroll-snap-align: start;
                padding: 2.5rem 0.8rem;
            }

            .feature-box:last-child {
                margin-right: 1rem;
            }

            .feature-image {
                width: 35px;
                height: 35px;
                margin-bottom: 0.6rem;
            }

            .feature-title {
                font-size: 0.85rem;
                margin-bottom: 0.4rem;
                line-height: 1.2;
            }

            .feature-text {
                font-size: 0.7rem;
                line-height: 1.3;
            }
        }

        @media (max-width: 480px) {
            .features-container {
                gap: 2rem;
                padding: 0 0.75rem;
            }

            .feature-box {
                min-width: 36%;
                max-width: 39% !important;
                flex-shrink: 0;
                padding: 2.5rem 0.6rem;
            }

            .feature-box:last-child {
                margin-right: 0.75rem;
            }

            .feature-image {
                width: 30px;
                height: 30px;
                margin-bottom: 0.5rem;
            }

            .feature-title {
                font-size: 0.8rem;
                margin-bottom: 0.3rem;
            }

            .feature-text {
                font-size: 0.65rem;
                line-height: 1.2;
            }
        }
        
        /* Sections */
        .section {
            padding: 4rem 0;
            background: #F5F5F5;
        }
        
        .section:nth-child(even) {
            background: #FFFFFF;
            padding-top: 8rem;
            padding-bottom:8rem;
           
        }
        
        /* Benefits Section - Updated Style for Better Desktop and Mobile Views */
        .benefits-section {
            background: url('{{ asset('assets/hero-desktop.jpg') }}') no-repeat center center;
            background-size: cover;
            background-attachment: scroll;
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: flex-start;
            padding-top: 0;
        }

        .benefits-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .benefits-title {
            text-align: center;
            color: #000000;
            margin-bottom: 6rem;
            padding-top: 6rem;
        }

        .benefits-title h2 {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 300;
            line-height: 1;
            margin: 0;
        }

        .benefits-title .line1 {
            display: block;
            margin-bottom: 0.5rem;
        }

        .benefits-title .line2 {
            display: block;
        }

        .benefits-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        .benefits-left {
            display: flex;
            flex-direction: column;
            gap: 3rem;
            text-align: left;
        }

        .benefits-right {
            display: flex;
            flex-direction: column;
            gap: 3rem;
            text-align: right;
        }

        .benefit-item {
            color: #000000;
        }

        .benefits-left .benefit-item {
            align-items: flex-start;
        }

        .benefits-right .benefit-item {
            align-items: flex-end;
        }

        .benefit-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        
            border-radius: 50%;
        }

        .benefits-left .benefit-icon {
            margin-left: 0;
            margin-right: auto;
        }

        .benefits-right .benefit-icon {
            margin-left: auto;
            margin-right: 0;
        }

        .benefit-icon img {
            width: 50px;
            height: 50px;
            filter: none;
        }

        .benefit-item h3 {
            font-size: 1.4rem;
            font-weight: 500;
            margin-bottom: 0.8rem;
            line-height: 1.3;
            color: #000000;
        }

        .benefit-item p {
            font-size: 0.95rem;
            line-height: 1.5;
            max-width: 250px;
            color: #6D6D6D;
    font-weight: lighter;
        }

        .benefits-left .benefit-item p {
            margin-left: 0;
            margin-right: auto;
        }

        .benefits-right .benefit-item p {
            margin-left: auto;
            margin-right: 0;
        }

        /* Desktop specific improvements - using cover to show full image */
        @media (min-width: 769px) {
            .benefits-section {
                background-size: cover;
                min-height: 100vh;
                padding-top: 0;
                padding-bottom: 4rem;
            }

            .benefits-title {
                margin-bottom: 8rem;
                padding-top: 1rem;
            }

            .benefits-title h2 {
                font-size: 3rem;
                font-weight: 300;
            }
        }

        /* Large desktop improvements */
        @media (min-width: 1200px) {
            .benefits-section {
                min-height: auto;
                padding-top: 0;
                padding-bottom: 10rem;
            }

            .benefits-title {
                margin-bottom: 10rem;
                padding-top: 1rem;
            }

            .benefits-content {
                gap: 6rem;
            }
        }

        /* Ultra-wide desktop improvements */
        @media (min-width: 1600px) {
            .benefits-section {
                background-size: contain;
                min-height: auto;
                padding-top: 0;
                padding-bottom: 12rem;
            }

            .benefits-title {
                padding-top: 5rem;
                margin-bottom: 8rem;
            }
        }

        /* For very wide screens, ensure the background doesn't get too small */
        @media (min-width: 1920px) {
            .benefits-section {
                /* background-size: auto; */
                min-height: auto;
            }
        }

        /* Mobile styles for benefits section */
        @media (max-width: 768px) {
            .benefits-section {
                min-height: auto;
                padding: 0;
                background: white;
                background-attachment: scroll;
                position: relative;
                display: block;
            }

            .benefits-section::before {
                content: '';
                display: block;
                width: 100%;
                height: 100vh;
                background: url('{{ asset('assets/benefits-mobile.jpg') }}') no-repeat center center;
                background-size: cover;
                margin: 0;
                position: relative;
            }

            .benefits-section::after {
                content: "Better Benefits \A For Tawasul Limousine";
                position: absolute;
                top: 3%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: #000000;
                font-size: 1.5rem;
                font-weight: 300;
                text-align: center;
                z-index: 10;
                width: 90%;
                padding: 0 1rem;
                line-height: 1.3;
                white-space: pre-line;
            }

            .benefits-container {
                padding: 0;
                position: relative;
                z-index: 2;
                margin: 0;
            }

            .benefits-title {
                display: none;
            }

            .benefits-content {
                display: flex;
                flex-direction: column;
                gap: 0;
                padding: 0;
                margin: 0;
            }

            .benefits-left,
            .benefits-right {
                display: flex;
                flex-direction: column;
                gap: 0;
                text-align: center;
                padding: 0;
                margin: 0;
            }

            .benefit-item {
                color: #000000;
                padding: 2rem 1rem;
                margin: 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .benefit-item:last-child {
                border-bottom: none;
            }

            .benefits-left .benefit-icon,
            .benefits-right .benefit-icon {
                margin: 0 auto 0.8rem auto;
            }

            .benefits-left .benefit-item p,
            .benefits-right .benefit-item p {
                margin: 0 auto;
                text-align: center;
                font-weight: lighter;
                color:#6D6D6D;
            }

            .benefit-icon {
                width: 50px;
                height: 50px;
             
            }

            .benefit-icon img {
                width: 50px;
                height: 50px;
                filter: none;
            }

            .benefit-item h3 {
                font-size: 1.2rem;
                margin-bottom: 0.6rem;
                color: #000000;
            }

            .benefit-item p {
                font-size: 0.9rem;
                max-width: 100%;
               color: #6D6D6D;
    font-weight: lighter;
            }
        }

        @media (max-width: 480px) {
            .benefits-section::after {
                font-size: 1.3rem;
                top: 3%;
                width: 85%;
                padding: 0.8rem;
            }

            .benefits-container {
                padding: 0;
                margin: 0;
            }

            .benefits-content {
                gap: 0;
                padding: 0;
                margin: 0;
            }

            .benefits-left,
            .benefits-right {
                gap: 0;
            }

            .benefit-item {
                padding: 1.5rem 0.75rem;
            }

            .benefit-icon {
                width: 45px;
                height: 45px;
                margin-bottom: 0.6rem;
            }

            .benefit-icon img {
                width: 50px;
                height: 50px;
            }

            .benefit-item h3 {
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }

            .benefit-item p {
                font-size: 0.85rem;
            }
        }

        /* Section 4 - Updated with new container design */
        .section-4 {
            padding: 4rem 0;
            background: #F3F3F3 !important;
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

        .section-4-footer-center {
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: center;
        }

        .section-4-footer-center img {
            height: 35px;
            width: auto;
        }

        .download-now-btn {
           background: TRANSPARENT;
    color: #ffffff;
    padding: 0.8rem 1.5rem;
    border: 1PX SOLID;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Sequel Sans', Arial, sans-serif;
    white-space: nowrap;
        }

        .download-now-btn:hover {
            background: white;
            color: #000000;
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

            .section-4-footer-apps {
                grid-row: 3;
                justify-self: center;
                gap: 0.5rem;
            }

            .section-4-footer-apps img {
                height: 28px;
            }

            .download-now-btn {
                grid-row: 4;
                justify-self: center;
                padding: 0.6rem 1.2rem;
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
        
        .section-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            text-align: left;
        }
        
        .section h2 {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            margin-bottom: 1rem;
            color: #333;
                    line-height: 1.2;
        }
        
        .section p {
            font-size: 14px;
            color: #6D6D6D;
            max-width: 100%;
            margin: 0 auto;
            
        }
            .faq-answer p {
            font-size: 14px;
            color: #6D6D6D;
            max-width: 100%;
            margin: 0 auto;
           
        }
          .section  p {
            font-size: 14px;
            color: #6D6D6D;
            max-width: 100%;
            margin: 0 auto;
         
        }
        
         /* Footer Styles */
        footer {
            background: #000000;
            color: white;
            padding: 3rem 0 2rem;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .footer-top {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 4rem;
            margin-bottom: 3rem;
        }
        
        .footer-brand {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .footer-brand img {
            width: 150px;
            margin-bottom: 1rem;
        }
        
       footer-brand p {
    color: #959595 !important;
    font-size: 14px;
    font-weight: lighter ;
    line-height: 1.5;
    margin: 0;
}
        
        .footer-right {
            display: grid;
            grid-template-columns: 1fr 1fr;
            
            padding-left: 400px;
        }
        
        .footer-menu {
            display: flex;
            flex-direction: column;
        }
        
        .footer-menu h4 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: white;
        }
        
        .footer-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-menu ul li {
            margin-bottom: 0.8rem;
        }
        
        .footer-menu ul li a {
            color: #B6B6B6;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s ease;
        }
        
        .footer-newsletter {
            grid-column: 1 / -1;
            margin-top: 2rem;
        }
        
        .footer-newsletter h4 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: white;
        }
        
        .newsletter-form {
            display: flex;
            gap: 1rem;
            align-items: end;
            border-bottom:1px solid;
            border-color: #3C3C3C;
            padding-bottom: 10px;
        }
        
        .newsletter-input {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .newsletter-input input[type="email"] {
            padding: 0.8rem 0;
            border: none;
            border-radius: 0;
            font-size: 14px;
            transition: border-color 0.3s ease;
            background: transparent;
            color: white;
            width: 100%;
        }
        
        .newsletter-input input[type="email"]::placeholder {
            color: #323232;
        }
        
        .newsletter-input input[type="email"]:focus {
            outline: none;
            border-bottom-color: rgba(255, 255, 255, 0);
        }
        
        .notify-btn {
            background: rgba(255, 255, 255, 0);
            color: white;
            padding: 0.5rem 2rem;
            border-color: white;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 100;
            border-width: 1px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Sequel Sans', Arial, sans-serif;
            white-space: nowrap;
        }
        
        .footer-bottom {
            border-top: 1px solid #333333;
            padding-top: 2rem;
            display: flex;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            justify-content: space-between;
        }
        
        .footer-apps {
            display: flex;
            gap: 3rem;
        }
        
        .footer-apps .app-button {
            display: inline-block;
            overflow: hidden;
        }
        
        .footer-apps .app-button img {
            height: 40px;
            width: auto;
            display: block;
        }
        
        .footer-copyright {
            text-align: center;
            color: #B6B6B6;
            font-size: 0.9rem;
        }
        
        .footer-bottom-menu {
            display: flex;
            gap: 2rem;
        }
        
        .footer-bottom-menu a {
            color: #94A190;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        /* Tablet Styles */
        @media (max-width: 1024px) {
            .header-content {
                gap: 1rem;
            }
            
            nav ul {
                gap: 1.5rem;
            }
            
            nav a {
                font-size: 12px;
            }
            
            .hero-container {
                gap: 2rem;
            }
            
            .hero-title {
                margin-bottom: 1.5rem;
            }
            
            .footer-right {
                gap: 1.5rem;
            }
            
            .benefits-section::before {
                height: 130vh;
            }
        }
        
        /* Enhanced Mobile Styles for Sticky Header */
        @media (max-width: 768px) {
            html, body {
                overflow-x: hidden !important;
                width: 100vw !important;
                max-width: 100vw !important;
            }

            * {
                max-width: 100vw !important;
            }

            /* Mobile Header - Fixed Position */
            header {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 9999 !important;
                background: #000000;
                transition: all 0.3s ease;
                width: 100vw;
                max-width: 100vw;
            }

            header.scrolled {
                background: rgba(0, 0, 0, 0.98) !important;
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                box-shadow: 0 2px 25px rgba(0,0,0,0.3);
            }

            /* Ensure body has proper padding for mobile */
            body {
                padding-top: 90px !important; /* Increased mobile spacing */
            }

            .header-content {
                grid-template-columns: auto 1fr auto;
                gap: 0.5rem;
                align-items: center;
                padding: 0 0.75rem;
                max-width: 100vw;
                width: 100vw;
            }
            
            .logo img {
                width: 90px !important;
                max-width: 90px !important;
            }
            
            nav {
                display: none;
            }
            
            .header-buttons {
                justify-self: end;
                gap: 0.25rem;
                display: flex;
                flex-shrink: 0;
            }

            .header-btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
                white-space: nowrap;
                min-width: auto;
            }
            
            .mobile-menu-toggle {
                display: block;
                justify-self: end;
                margin-left: 0.25rem;
                padding: 0.25rem;
                font-size: 1.2rem;
            }

            .mobile-menu-overlay.active {
                display: block;
            }

            .mobile-menu {
                display: block;
                width: 250px;
                max-width: 80vw;
                z-index: 1001;
            }
            
            /* Mobile Hero Section */
            .hero-section {
                padding: 0;
                min-height: auto;
                width: 100vw;
                max-width: 100vw;
            }

            .hero-container {
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: left;
                padding: 0;
                max-width: 100vw;
                width: 100vw;
                margin: 0;
            }
            
            .hero-content {
                order: 2;
                width: 100%;
                max-width: 100%;
                padding: 0 0.75rem;
            }
            
            .hero-image {
                order: 1;
                position: relative;
                height: 100%;
                min-height: 50vh;
                border-radius: 0;
                width: 100vw;
                max-width: 100vw;
                margin: 0;
            }
            
            .hero-image::before {
                content: "Elevated Travel";
                position: absolute;
                top: 70%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 1.8rem;
                font-weight: bold;
                text-align: center;
                z-index: 10;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
                width: 100%;
                padding: 0 0.5rem;
                line-height: 1.2;
            }

            .hero-image::after {
                content: "Experience";
                position: absolute;
                top: 80%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 1.8rem;
                font-weight: bold;
                text-align: center;
                z-index: 10;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
                width: 100%;
                padding: 0 0.5rem;
            }
            
            .hero-title {
                display: none;
            }

            .booking-form {
                padding: 0.75rem 0;
                margin-bottom: 1rem;
                width: 100%;
                max-width: 100%;
            }
            
            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 0.75rem;
                width: 100%;
                margin-bottom: 1.5rem;
                align-items: end;
            }
            
            .location-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
                width: 100%;
                margin-bottom: 1.5rem;
                align-items: end;
            }


            .form-group select,
            .form-group input {
                width: 100%;
                max-width: 100%;
                padding: 0.6rem 0;
                font-size: 10px !important;
                background-size: 0.6rem;
                padding-right: 1rem;
                text-align: left;
            }

            /* Ensure date and time fields match exactly */
            .form-group input[name="date"],
            .form-group input[name="time"] {
                font-size: 10px !important;
                width: 100%;
                max-width: 100%;
                padding: 0.6rem 0;
                padding-right: 1rem;
                background-size: 0.6rem;
            }

            .form-group label {
                font-size: 0.65rem;
                margin-bottom: 0.3rem;
            }

            .form-group {
                width: 100%;
                max-width: 100%;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                justify-content: flex-start;
            }

            .form-bottom {
                flex-direction: column;
                gap: 2rem;
                align-items: center;
                width: 100%;
                     }

            .see-prices-btn {
                width: auto;
                text-align: center;
                padding: 0.8rem 2rem;
                min-width: 150px;
            }

            .login-link {
                text-align: left;
                font-size: 0.65rem;
                padding-top: 6px;
            }

            .app-downloads {
                margin-top: 1rem;
                justify-content: center;
                gap: 0.5rem;
                width: 100%;
            }

            .app-button img {
                height: 40px;
                max-width: 120px;
            }

            /* Mobile Sections */
            .section {
                padding: 1.5rem 0;
                width: 100vw;
                max-width: 100vw;
            }

            .section-content {
                padding: 0 0.75rem;
                width: 100%;
                max-width: 100%;
            }

            .section h2 {
                font-size: 1.75rem;
            }

            .section p {
                font-size: 10px;
             
            }
              .faq-answer p {
                font-size: 10px;
                padding-left: 25px;
            }
            
            /* Mobile Footer Styles */
            footer {
                padding: 1.5rem 0 1rem;
                width: 100vw;
                max-width: 100vw;
            }

            .footer-content {
                padding: 0 0.75rem;
                max-width: 100vw;
                width: 100vw;
                margin: 0;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin-bottom: 0rem;
                width: 100%;
            }
            
            .footer-brand {
                align-items: flex-start;
                margin-bottom: 0.75rem;
                width: 100%;
            }

            .footer-brand img {
                width: 90px;
                margin-bottom: 0.75rem;
                max-width: 90px;
            }

            .footer-brand p {
                font-size: 10px;
                margin-bottom: 1rem;
                line-height: 1.3;
                width: 100%;
                padding-right: 10px;
            }
            
            .footer-right {
           
                gap: 1rem;
                padding-left: 0;
                margin-bottom: 1rem;
                width: 100%;
            }

            .footer-menu {
                width: 100%;
            }

            .footer-menu ul li {
                margin-bottom: 0.4rem;
            }

            .footer-menu ul li a {
                font-size: 10px;
            }

            .footer-newsletter {
                margin-top: 0;
                margin-bottom: 0;
                width: 100%;
            }
            
            .newsletter-form {
                flex-direction: row;
                gap: 0.5rem;
                margin-bottom: 0;
                align-items: end;
                width: 100%;
                border-bottom: solid;
                border-color: #3C3C3C;
                padding-bottom: 10px;
                border-width: 1px;
            }

            .newsletter-input {
                flex: 1;
                width: auto;
            }

            .newsletter-input input[type="email"] {
                padding: 0.6rem 0;
                font-size: 12px;
                width: 100%;
            }

            .notify-btn {
                font-size: 11px;
                padding: 0.6rem 1.5rem;
                white-space: nowrap;
                width: auto;
                flex-shrink: 0;
            }
            
            .footer-bottom {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: left;
                padding-top: 1rem;
                width: 100%;
                border-top: none;
            }

            .footer-bottom-menu {
                justify-content: center;
                order: 1;
                margin-bottom: 0.75rem;
                flex-wrap: wrap;
                gap: 3rem;
                width: 100%;
            }

            .footer-bottom-menu a {
                font-size: 11px;
            }
            
            .footer-apps {
                justify-content: flex-start;
                order: 2;
                margin-bottom: 0.75rem;
                gap: 0.75rem;
                width: 100%;
            }

            .footer-apps .app-button img {
                height: 28px;
                max-width: 100px;
            }

            .footer-copyright {
                order: 3;
                width: 100%;
                text-align: left;
            }

            .footer-copyright p {
                font-size: 8px;
            }
        }

        /* Small Mobile Styles */
        @media (max-width: 480px) {
            /* Small Mobile - Fixed Header */
            header {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 9999 !important;
            }

            /* Ensure proper body padding */
            body {
                padding-top: 80px !important; /* Restored proper spacing for small mobile */
            }

            .header-content {
                padding: 0 0.5rem;
            }
            
            .logo img {
                width: 100px;
            }
            
            .header-btn {
                padding: 0.3rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .hero-section {
                padding: 0;
            }
            
            .hero-container {
                gap: 1rem;
            }
            
            .hero-image {
                height: 100%;
                min-height: 40vh;
                margin: 0;
                width: 100vw;
                max-width: 100vw;
            }
            
            .hero-image::before {
                font-size: 2rem;
                top: 75%;
                font-weight: 100;
            }

            .hero-image::after {
                font-size: 2rem;
                font-weight: 100;
                top: 85%;
            }
            
            .booking-form {
                margin-bottom: 1rem;
            }
            
            .form-row,
            .location-row {
                gap: 0.5rem;
                align-items: end;
            }
            
            .form-row {
                grid-template-columns: 1fr 1fr 1fr;
            }
            
            .location-row {
                grid-template-columns: 1fr 1fr;
            }

            .form-group select,
            .form-group input {
                padding: 0.5rem 0;
                font-size: 10px !important;
                background-size: 0.5rem;
                padding-right: 0.8rem;
                text-align: left;
            }

            /* Ensure date and time fields match exactly on small mobile */
            .form-group input[name="date"],
            .form-group input[name="time"] {
                font-size: 10px !important;
                width: 100%;
                max-width: 100%;
                padding: 0.5rem 0;
                padding-right: 0.8rem;
                background-size: 0.5rem;
            }

            .form-group label {
                font-size: 0.6rem;
                margin-bottom: 0.2rem;
                text-align: left;
            }

            .see-prices-btn {
                padding: 0.6rem 1.2rem;
                font-size: 11px;
                min-width: 120px;
            }

            .login-link {
                font-size: 0.6rem;
                padding-top: 4px;
            }
            
            .app-button img {
                height: 35px;
            }
            
            .section {
                padding: 1.5rem 0;
            }
            
            .section-content {
                padding: 0 0.5rem;
            }
            
            .footer-content {
                padding: 0 0.5rem;
            }
            
            .footer-right {
               
                text-align: left;
            }
            
            .footer-bottom-menu {
                flex-wrap: wrap;
            }
            
            .footer-bottom-menu a {
                font-size: 12px;
            }
        }

        /* Large Desktop Styles */
        @media (min-width: 1440px) {
            .header-content,
            .hero-container,
            .section-content,
            .footer-content {
                max-width: 1400px;
            }
            
            .hero-title {
                font-size: 4rem;
            }
            
            .section h2 {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Travel Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="#home">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Careers</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
            </nav>
            <div class="header-buttons">
                @auth
                    <span class="header-btn user-greeting">Hello, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="header-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="header-btn primary">Login</a>
                @endauth
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">☰</button>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu-overlay" onclick="closeMobileMenu()"></div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <button class="mobile-menu-close" onclick="closeMobileMenu()">×</button>
            <ul>
                <li><a href="#home" onclick="closeMobileMenu()">About Us</a></li>
                <li><a href="#services" onclick="closeMobileMenu()">Services</a></li>
                <li><a href="#contact" onclick="closeMobileMenu()">Careers</a></li>
                <li><a href="#contact" onclick="closeMobileMenu()">Contact Us</a></li>
            </ul>
            <div class="mobile-menu-buttons">
                @auth
                    <span class="header-btn user-greeting">Hello, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        <button type="submit" class="header-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="header-btn primary" onclick="closeMobileMenu();">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="hero-section">
            <div class="hero-container">
                <div class="hero-content">
                    <h1 class="hero-title">Book. Ride. Arrive in Luxury.</h1>
                    
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
                                <input type="text" id="pickup" name="pickup_location" placeholder="Enter pickup location" readonly onclick="openMapSelector('pickup')" required>
                                <input type="hidden" id="pickup_lat" name="pickup_lat">
                                <input type="hidden" id="pickup_lng" name="pickup_lng">
                            </div>
                            <div class="form-group">
                                <label for="dropoff">Drop-off Location</label>
                                <input type="text" id="dropoff" name="dropoff_location" placeholder="Enter drop-off location" readonly onclick="openMapSelector('dropoff')" required>
                                <input type="hidden" id="dropoff_lat" name="dropoff_lat">
                                <input type="hidden" id="dropoff_lng" name="dropoff_lng">
                            </div>
                        </div>

                        
                        <div class="form-bottom">
                            <button type="submit" class="see-prices-btn" id="submitBookingBtn">Book Now</button>
                        </div>
                    </form>
                </div>
                
                <div class="hero-image">
                    <img src="{{ asset('assets/travel-experience.png') }}" alt="Travel Experience">
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
        <section class="benefits-section">
            <div class="benefits-container">
                <!-- Title at the top -->
                <div class="benefits-title">
                    <h2>
                        <span class="line1">Better Benefits </span>
                        <span class="line2">For Tawasul Limousine</span>
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
        
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-top">
                <div class="footer-brand">
                    <img src="{{ asset('assets/logo.png') }}" alt="TravelEase Logo">
                    <p style="color:#959595">Tawasul Limousine for business — service for corporate customers. Tawasul Limousine is an informational service and not a transportation or taxi services provider. Transportation services are provided by third parties. Any statements displayed are for informational purposes only and do not constitute an offer or promise.</p>
                </div>
                
                <div class="footer-right">
                    <div class="footer-menu">
                        <ul>
                            <li><a href="#permissions">App Permissions</a></li>
                            <li><a href="#privacy">Privacy Policy</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-menu">
                        <ul>
                            <li><a href="{{ route('register') }}">Registration Form</a></li>
                            <li><a href="#contact">Contact Us</a></li>
                        </ul>
                    </div>
                       <div>
                        
                     <p style="color: #B6B6B6;font-size: 12px;">Book Your Journey Today</p>
                   <p style="color: #B6B6B6;font-size: 12px;"> Booking:<a href="tel:600 55 95 95" style="color: #B6B6B6;font-size: 12px;"> 600 55 95 95</a></p>
                    </div>
                    <div class="footer-newsletter">

                        <div class="newsletter-form">
                            <div class="newsletter-input">
                                <input type="email" placeholder="Enter your email" required>
                            </div>
                            <button class="notify-btn" onclick="subscribeNewsletter()">Notify Me</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-copyright">
                    <p>&copy; Copyright © 2025. Tawasul Limousine</p>
                </div>
                
                <nav class="footer-bottom-menu">
                    <a href="#instagram">Instagram</a>
                    <a href="#facebook">Facebook</a>
                    <a href="#linkedin">LinkedIn</a>
                    <a href="#youtube">YouTube</a>
                </nav>
            </div>
        </div>
    </footer>

    <!-- Google Maps API -->
    <script>
        console.log('Loading Google Maps API...');
    </script>
    <script async defer 
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', 'your_google_maps_api_key_here') }}&libraries=places&callback=initMap"
        onerror="console.error('Failed to load Google Maps API')">
    </script>
    
    <!-- Map Modal -->
    <div id="mapModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; max-width: 600px; height: 70%; background: white; border-radius: 10px; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 id="mapModalTitle">Select Location</h3>
                <button onclick="closeMapModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
            </div>
            <input id="mapSearch" type="text" placeholder="Search for a place..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; margin-bottom: 10px;">
            <div id="map" style="width: 100%; height: 70%; border-radius: 8px;"></div>
            <div style="margin-top: 15px; text-align: right;">
                <button onclick="closeMapModal()" style="background: #ccc; border: none; padding: 10px 20px; margin-right: 10px; border-radius: 5px; cursor: pointer;">Cancel</button>
                <button onclick="confirmLocation()" style="background: #000; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Confirm Location</button>
            </div>
        </div>
    </div>

    <script>
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
            document.getElementById('mapModal').style.display = 'none';
            selectedLocation = null;
        }

        function confirmLocation() {
            if (selectedLocation && currentLocationType) {
                const inputField = document.getElementById(currentLocationType === 'pickup' ? 'pickup' : 'dropoff');
                const latField = document.getElementById(currentLocationType + '_lat');
                const lngField = document.getElementById(currentLocationType + '_lng');
                
                inputField.value = selectedLocation.address;
                latField.value = selectedLocation.lat;
                lngField.value = selectedLocation.lng;
                
                closeMapModal();
            } else {
                alert('Please select a location on the map first.');
            }
        }

        // Booking form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBookingBtn');
            const originalText = submitBtn.textContent;
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            const formData = new FormData(this);
            
            // Add CSRF token
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
             fetch('{{ route("booking.store") }}', {
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
                    this.reset(); // Reset form
                    // Clear hidden fields and location inputs
                    document.getElementById('pickup').value = '';
                    document.getElementById('dropoff').value = '';
                    document.getElementById('pickup_lat').value = '';
                    document.getElementById('pickup_lng').value = '';
                    document.getElementById('dropoff_lat').value = '';
                    document.getElementById('dropoff_lng').value = '';
                } else {
                    alert('Error: ' + (data.message || 'Please check your information and try again.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
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
            window.location.href = '/register';
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
            
            if (!mobileMenu.contains(event.target) && !toggle.contains(event.target)) {
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
            try {
                // Default location: Dubai
                const defaultLocation = { lat: 25.2048, lng: 55.2708 };
                
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 13,
                    center: defaultLocation,
                });

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
                document.getElementById('pickup').removeAttribute('readonly');
                document.getElementById('dropoff').removeAttribute('readonly');
                document.getElementById('pickup').removeAttribute('onclick');
                document.getElementById('dropoff').removeAttribute('onclick');
                document.getElementById('pickup').placeholder = 'Enter pickup address manually';
                document.getElementById('dropoff').placeholder = 'Enter drop-off address manually';
            }
        }

        // Map selector functions with fallback
        function openMapSelector(type) {
            if (typeof google === 'undefined' || !google.maps) {
                alert('Location picker not available. Please enter the address manually in the text field.');
                return;
            }
            
            currentLocationType = type;
            const modal = document.getElementById('mapModal');
            const title = document.getElementById('mapModalTitle');
            
            title.textContent = type === 'pickup' ? 'Select Pickup Location' : 'Select Drop-off Location';
            modal.style.display = 'block';
            
            // Reinitialize map when modal opens
            setTimeout(() => {
                google.maps.event.trigger(map, 'resize');
                
                // Try to get current location for pickup
                if (type === 'pickup' && navigator.geolocation) {
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
            }, 100);
        }

        // Initialize date dropdown on page load
        document.addEventListener('DOMContentLoaded', function() {
            populateDateDropdown();
            initializeDateTimeInputs();
        });

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
            }
            
            // Set default time to current time + 1 hour
            if (timeInput && !timeInput.value) {
                const now = new Date();
                now.setHours(now.getHours() + 1);
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                timeInput.value = `${hours}:${minutes}`;
            }
            
            // Add validation for past dates
            if (dateInput) {
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
        }

        // Google Maps is initialized via window.initMap callback
    </script>
</body>
</html>