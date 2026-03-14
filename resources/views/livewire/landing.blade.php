<div>
    <!-- 1. NAVBAR -->
    <header id="navbar" class="{{ $mobileMenuOpen ? 'mobile-menu-active' : '' }}">
        <div class="container nav-container">
            <a href="#" wire:click.prevent="setPage('home')" class="logo">
                <img src="{{ asset('logo.png') }}" alt="Gymdesk15 Logo" style="height: 48px; width: auto;">
            </a>
            <nav class="nav-links">
                <a href="#" wire:click.prevent="scrollToSection('home')">Home</a>
                <a href="#" wire:click.prevent="scrollToSection('features')">Features</a>
                <a href="#" wire:click.prevent="scrollToSection('how-it-works')">How It Works</a>
                <a href="#" wire:click.prevent="scrollToSection('pricing')">Pricing</a>
                <a href="#" wire:click.prevent="setPage('about')">About Us</a>
                <a href="#" wire:click.prevent="setPage('contact')">Contact</a>
            </nav>
            <div class="nav-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="login-link">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.85rem; border-radius: 8px;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="login-link">Login</a>
                    <a href="#" wire:click.prevent="setPage('contact')" class="btn btn-primary" style="padding: 8px 18px; font-size: 0.85rem; border-radius: 8px;">Get Started</a>
                @endauth
            </div>

            <!-- Hamburger Menu Button -->
            <button wire:click="toggleMobileMenu" class="hamburger {{ $mobileMenuOpen ? 'is-active' : '' }}" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <div class="mobile-overlay {{ $mobileMenuOpen ? 'is-open' : '' }}">
            <nav class="mobile-nav">
                <div class="mobile-nav-header">
                    <img src="{{ asset('logo.png') }}" alt="Gymdesk15 Logo" style="height: 40px; width: auto;">
                </div>
                
                <div class="mobile-links-container">
                    <a href="#" wire:click.prevent="scrollToSection('home')" class="mobile-link" style="--i:1">Home</a>
                    <a href="#" wire:click.prevent="scrollToSection('features')" class="mobile-link" style="--i:2">Features</a>
                    <a href="#" wire:click.prevent="scrollToSection('pricing')" class="mobile-link" style="--i:3">Pricing</a>
                    <a href="#" wire:click.prevent="setPage('about')" class="mobile-link" style="--i:4">About Us</a>
                    <a href="#" wire:click.prevent="setPage('contact')" class="mobile-link" style="--i:5">Contact Us</a>
                </div>
                
                <div class="mobile-auth" style="--i:6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="mobile-link login-link">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-full">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="mobile-link login-link">Login</a>
                        <a href="#" wire:click.prevent="setPage('contact')" class="btn btn-primary w-full">Get Started</a>
                    @endauth
                </div>

                <div class="mobile-socials" style="--i:7">
                    <a href="https://www.linkedin.com/in/faizanbutt15" target="_blank">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="https://github.com/Faizanbutt15" target="_blank">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="https://wa.me/923027959570" target="_blank">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path></svg>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        @if($page == 'home')
            <livewire:home />
        @elseif($page == 'about')
            <livewire:about-us />
        @elseif($page == 'contact')
            <livewire:contact />
        @endif
    </main>

    <!-- 9. FOOTER -->
    <footer id="contact" wire:ignore>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-logo-col">
                    <a href="#" wire:click.prevent="setPage('home')" class="logo footer-logo">
                        <img src="{{ asset('logo.png') }}" alt="Gymdesk15 Logo" style="height: 48px; width: auto; margin-bottom: 10px;">
                    </a>
                    <p class="footer-tagline">Stop managing on Excel. Start running it like a business.</p>
                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/faizanbutt15" target="_blank" class="social-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <a href="https://github.com/Faizanbutt15" target="_blank" class="social-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/faizanbutt_15/" target="_blank" class="social-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="mailto:faizanbutt15@yahoo.com" class="social-icon" title="Email Us">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </a>
                        <a href="https://wa.me/923027959570" target="_blank" class="social-icon" title="Chat on WhatsApp">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path></svg>
                        </a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#" wire:click.prevent="setPage('about')">About Us</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#" wire:click.prevent="setPage('contact')">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>Built with ❤️ for Gym Owners. © 2026 Gymdesk15. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <style>
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Hamburger Menu Button */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 1001;
            transition: var(--transition);
        }

        .hamburger span {
            width: 100%;
            height: 3px;
            background-color: #fff;
            border-radius: 10px;
            transition: var(--transition);
            transform-origin: left center;
        }

        .hamburger.is-active span:nth-child(1) {
            transform: rotate(45deg);
            background-color: var(--primary);
        }

        .hamburger.is-active span:nth-child(2) {
            width: 0%;
            opacity: 0;
        }

        .hamburger.is-active span:nth-child(3) {
            transform: rotate(-45deg);
            background-color: var(--primary);
        }

        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100vh;
            background: rgba(11, 12, 16, 0.98);
            backdrop-filter: blur(20px);
            z-index: 1000;
            transition: all 0.6s cubic-bezier(0.85, 0, 0.15, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
        }

        .mobile-overlay.is-open {
            right: 0;
            visibility: visible;
            opacity: 1;
        }

        .mobile-nav {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
            width: 100%;
            padding: 60px 20px;
            height: 100%;
            justify-content: center;
        }

        .mobile-nav-header {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .mobile-links-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }

        .mobile-link {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 4px;
            transition: var(--transition);
            opacity: 0;
            transform: translateY(20px);
        }

        .is-open .mobile-link,
        .is-open .mobile-auth,
        .is-open .mobile-socials {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition-delay: calc(0.1s * var(--i));
        }

        .mobile-link:hover {
            color: var(--primary);
            letter-spacing: 6px;
        }

        .mobile-auth {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 320px;
            margin-top: 20px;
            opacity: 0;
            transform: translateY(20px);
        }

        .mobile-socials {
            display: flex;
            gap: 25px;
            margin-top: 40px;
            opacity: 0;
            transform: translateY(20px);
        }

        .mobile-socials a {
            color: #fff;
            transition: var(--transition);
            opacity: 0.7;
        }

        .mobile-socials a:hover {
            color: var(--primary);
            opacity: 1;
            transform: translateY(-5px);
        }

        .w-full {
            width: 100%;
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {
            .nav-links, .nav-actions {
                display: none;
            }
            .hamburger {
                display: flex;
            }
        }
    </style>
</div>
