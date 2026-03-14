<div>
    <!-- 1. NAVBAR -->
    <header id="navbar" wire:ignore>
        <div class="container nav-container">
            <a href="#" wire:click.prevent="setPage('home')" class="logo">
                <img src="{{ asset('logo.png') }}" alt="Gymdesk15 Logo" style="height: 48px; width: auto;">
            </a>
            <nav class="nav-links">
                @if($page == 'home')
                    <a href="#features">Features</a>
                    <a href="#how-it-works">How It Works</a>
                    <a href="#pricing">Pricing</a>
                @else
                    <a href="#" wire:click.prevent="setPage('home')">Home</a>
                @endif
                <a href="#" wire:click.prevent="setPage('about')">About Us</a>
                <a href="#" wire:click.prevent="setPage('contact')">Contact</a>
            </nav>
            <div style="display: flex; align-items: center; gap: 20px;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="login-link">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="login-link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 0.9rem;">Get Started Free</a>
                @endauth
            </div>
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
                        <a href="https://www.facebook.com/faizan.butt.172856/" target="_blank" class="social-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" width="20" height="20"><path d="M22.675 0h-21.35C.597 0 0 .597 0 1.325v21.351C0 23.403.597 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.325-.597 1.325-1.325V1.325C24 .597 23.403 0 22.675 0z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/faizanbutt_15/" target="_blank" class="social-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
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
</div>
