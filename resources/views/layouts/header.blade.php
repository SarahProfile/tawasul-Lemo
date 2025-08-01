    <header>
        <div class="header-content">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/logo.png') }}" alt="Travel Logo">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('about') }}" class="{{ Request::routeIs('about') ? 'active' : '' }}">About Us</a></li>
                    <li><a href="{{ route('services') }}" class="{{ Request::routeIs('services') ? 'active' : '' }}">Services</a></li>
                    <li><a href="{{ route('career') }}" class="{{ Request::routeIs('career') ? 'active' : '' }}">Careers</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ Request::routeIs('contact') ? 'active' : '' }}">Contact Us</a></li>
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
                <li><a href="{{ route('about') }}" class="{{ Request::routeIs('about') ? 'active' : '' }}" onclick="closeMobileMenu()">About Us</a></li>
                <li><a href="{{ route('services') }}" class="{{ Request::routeIs('services') ? 'active' : '' }}" onclick="closeMobileMenu()">Services</a></li>
                <li><a href="{{ route('career') }}" class="{{ Request::routeIs('career') ? 'active' : '' }}" onclick="closeMobileMenu()">Careers</a></li>
                <li><a href="{{ route('contact') }}" class="{{ Request::routeIs('contact') ? 'active' : '' }}" onclick="closeMobileMenu()">Contact Us</a></li>
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