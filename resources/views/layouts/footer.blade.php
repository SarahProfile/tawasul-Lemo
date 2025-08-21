    <footer>
        <div class="footer-content">
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/logo.png') }}" alt="TravelEase Logo">
                    </a>
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
                    <a href="https://www.instagram.com/tawasullimo/" target="_blank">Instagram</a>
                    <a href="https://www.facebook.com/profile.php?id=61569536035140" target="_blank">Facebook</a>
                    <a href="#linkedin">LinkedIn</a>
                    <a href="#youtube">YouTube</a>
                </nav>
            </div>
        </div>
    </footer>