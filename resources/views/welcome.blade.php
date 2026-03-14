<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymDesk15 | Modern Gym Management Software</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #0b0c10;
            --primary: #D90429;
            --primary-glow: rgba(217, 4, 41, 0.4);
            --primary-transparent: rgba(217, 4, 41, 0.1);
            --card-bg: rgba(255, 255, 255, 0.03);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-primary: #f0f0f0;
            --text-secondary: #a0a0ab;
            --heading-font: 'Outfit', sans-serif;
            --body-font: 'Outfit', sans-serif;
            --spacing-lg: clamp(60px, 8vw, 100px);
            --spacing-md: clamp(40px, 5vw, 60px);
            --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--body-font);
            background-color: var(--bg-color);
            color: var(--text-secondary);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--heading-font);
            color: var(--text-primary);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.5rem);
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(180deg, #fff 0%, #aaa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Utility animations */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-family: var(--body-font);
        }

        .btn-primary {
            background-color: var(--primary);
            color: #fff;
            position: relative;
        }

        .btn-primary:hover {
            box-shadow: 0 0 20px rgba(233, 69, 96, 0.4);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            color: #fff;
            border: 1px solid var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary-transparent);
        }

        /* 1. NAVBAR */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: var(--transition);
            padding: 20px 0;
        }

        header.scrolled {
            background: rgba(10, 10, 15, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: var(--heading-font);
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .login-link {
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .login-link:hover {
            color: var(--primary);
        }

        .logo .dot {
            width: 8px;
            height: 8px;
            background-color: var(--primary);
            border-radius: 50%;
            display: inline-block;
            margin-left: 4px;
            align-self: flex-end;
            margin-bottom: 6px;
        }

        .nav-links {
            display: flex;
            gap: 32px;
        }

        .nav-links a {
            font-size: 0.95rem;
            font-weight: 500;
            color: #ccc;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        /* 2. HERO SECTION */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 100px;
            overflow: hidden;
            background: radial-gradient(circle at 20% 30%, #1a0a0f 0%, #0b0c10 100%);
        }

        #particles-js {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.4;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            width: 100%;
        }

        .hero-text {
            max-width: 600px;
        }

        .badge {
            display: inline-block;
            background: var(--primary-transparent);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid rgba(217, 4, 41, 0.3);
        }

        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3rem);
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -0.03em;
        }

        /* Typing effect class target */
        .typing-effect {
            border-right: 2px solid var(--primary);
            white-space: wrap;
        }

        .hero p {
            font-size: 1rem;
            margin-bottom: 24px;
            max-width: 500px;
            color: var(--text-secondary);
        }

        .hero-btns {
            display: flex;
            gap: 16px;
        }

        .hero-image {
            position: relative;
        }

        .dashboard-image-container {
            width: 100%;
            border-radius: 20px;
            padding: 8px;
            background: linear-gradient(145deg, rgba(255,255,255,0.05), rgba(255,255,255,0.01));
            border: 1px solid var(--glass-border);
            position: relative;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.8);
        }

        .dashboard-image {
            width: 100%;
            height: auto;
            max-height: 400px;
            display: block;
            border-radius: 14px;
            object-fit: contain;
        }

        /* Video Section Styling */
        .section-stars {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .video-section {
            padding: var(--spacing-lg) 0;
            background: radial-gradient(circle at 50% 50%, #1a0a0f 0%, #0b0c10 100%);
            border-top: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .video-wrapper {
            max-width: 800px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            box-shadow: 0 40px 80px rgba(0,0,0,0.8);
            position: relative;
            aspect-ratio: 16 / 9;
        }

        .video-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.4);
            cursor: pointer;
        }

        .play-button {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 0 20px var(--primary-glow);
            transition: var(--transition);
        }

        .play-button svg {
            width: 24px;
            height: 24px;
        }

        .video-wrapper:hover .play-button {
            transform: scale(1.1);
            box-shadow: 0 0 40px var(--primary-glow);
        }

        /* Abstract UI elements inside mockup */


        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* 3. PROBLEM SECTION */
        .problem-section {
            padding: var(--spacing-lg) 0;
            background: linear-gradient(180deg, var(--bg-color) 0%, #0d0d14 100%);
        }

        .cards-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .problem-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            padding: clamp(25px, 4vw, 35px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            text-align: left;
            transition: var(--transition);
        }

        .problem-card:hover {
            border-color: var(--primary);
            background: rgba(217, 4, 41, 0.05);
            transform: translateY(-5px);
        }

        .problem-icon {
            width: 42px;
            height: 42px;
            background: var(--primary-transparent);
            color: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .problem-card h3 {
            font-size: 1.15rem;
            line-height: 1.3;
        }

        /* 4. FEATURES SECTION */
        .features-section {
            padding: var(--spacing-lg) 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: var(--glass-bg);
            padding: clamp(25px, 4vw, 30px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            transition: var(--transition);
        }

        .feature-card:hover {
            border-color: var(--primary);
            box-shadow: 0 15px 30px rgba(0,0,0,0.4);
            transform: translateY(-6px);
        }

        .feature-icon-text {
            color: var(--primary);
            margin-bottom: 16px;
            display: block;
        }

        .feature-icon-text svg {
            width: 28px;
            height: 28px;
        }

        .feature-card h3 {
            font-size: 1.1rem;
            margin-bottom: 12px;
        }

        .feature-card p {
            line-height: 1.6;
            font-size: 0.9rem;
        }

        /* 5. HOW IT WORKS SECTION */
        .how-it-works {
            padding: var(--spacing-lg) 0;
            background: #0d0d14;
            position: relative;
            overflow: hidden;
        }

        .steps-container {
            display: flex;
            justify-content: space-between;
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }

        .steps-line {
            position: absolute;
            top: 40px;
            left: 50px;
            right: 50px;
            height: 2px;
            background: rgba(255,255,255,0.05);
            z-index: 1;
        }

        .steps-line-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%; /* changes via JS */
            background: var(--primary);
            box-shadow: 0 0 10px var(--primary);
            transition: width 1.5s ease-out;
        }

        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 250px;
        }

        .step-number {
            width: 48px;
            height: 48px;
            background: var(--primary-transparent);
            border: 1px solid var(--primary);
            color: var(--primary);
            font-size: 1.1rem;
            font-family: var(--body-font);
            font-weight: 700;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            transition: var(--transition);
        }

        .step.active .step-number {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 0 15px var(--primary-glow);
        }

        .step h3 {
            font-size: 1.1rem;
        }

        /* 6. STATS SECTION */
        .stats-section {
            padding: 100px 0;
            background: #0a0a0f;
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            text-align: center;
        }

        .stat-number {
            font-size: clamp(2.5rem, 6vw, 2.8rem);
            color: var(--text-primary);
            font-family: var(--heading-font);
            font-weight: 800;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
        
        .stat-number span {
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* 7. TESTIMONIALS SECTION */
        .testimonials {
            padding: var(--spacing-lg) 0;
        }

        .testimonial-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            padding: clamp(25px, 4vw, 30px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            transition: var(--transition);
        }

        .testimonial-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
        }

        .stars {
            color: #FFB800;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .quote-text {
            font-size: 1rem;
            color: #ddd;
            font-style: italic;
            margin-bottom: 24px;
        }

        .author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--primary-transparent);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-family: var(--heading-font);
            font-size: 0.9rem;
        }

        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 2px;
        }

        .author-info p {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* 8. PRICING SECTION */
        .pricing-section {
            padding: var(--spacing-lg) 0;
            background: #0d0d14;
        }

        .pricing-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: clamp(30px, 5vw, 40px);
            display: flex;
            flex-direction: column;
            position: relative;
            transition: var(--transition);
        }

        .pricing-card:hover {
            border-color: rgba(217, 4, 41, 0.3);
            transform: scale(1.02);
        }

        .pricing-card.popular {
            border-color: var(--primary);
            background: rgba(217, 4, 41, 0.03);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .popular-badge {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary);
            color: #fff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .plan-name {
            font-size: 1.25rem;
            margin-bottom: 8px;
        }

        .plan-price {
            font-size: clamp(2.5rem, 6vw, 3rem);
            letter-spacing: -0.04em;
            color: var(--text-primary);
            font-weight: 800;
            margin-bottom: 24px;
        }

        .plan-price span {
            font-size: 1.1rem;
            color: var(--text-secondary);
            font-weight: 500;
            letter-spacing: 0;
        }

        .plan-features {
            margin-bottom: 40px;
            flex-grow: 1;
        }

        .plan-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            color: #ddd;
        }

        .plan-features li i {
            color: var(--primary);
        }

        .pricing-card .btn {
            width: 100%;
            text-align: center;
        }

        /* 9. FOOTER */
        footer {
            background: #0a0a0f;
            border-top: 1px solid var(--primary);
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-logo {
            margin-bottom: 20px;
        }

        .footer-tagline {
            max-width: 250px;
            margin-bottom: 20px;
        }

        .footer-col h4 {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .social-icons a:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.05);
            font-size: 0.9rem;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .hero h1 { font-size: 2.4rem; }
            .section-title { font-size: 2rem; }
            .cards-grid-3, .features-grid, .pricing-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            .video-wrapper { max-width: 900px; }
        }

        @media (max-width: 991px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 50px;
            }
            .hero-text { margin: 0 auto; }
            .hero-btns { justify-content: center; }
            .dashboard-image-container { max-width: 600px; margin: 0 auto; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 30px; }
        }

        @media (max-width: 768px) {
            header { padding: 15px 0; }
            .nav-links, .nav-btn { display: none; }
            .hero { padding-top: 80px; min-height: auto; padding-bottom: 60px; }
            .hero h1 { font-size: 2rem; }
            .cards-grid-3, .features-grid, .pricing-grid { grid-template-columns: 1fr; }
            .steps-container { flex-direction: column; align-items: center; gap: 30px; }
            .steps-line { display: none; }
            .step { width: 100%; max-width: 300px; }
            .footer-grid { grid-template-columns: 1fr; gap: 40px; }
            .stat-number { font-size: 2.2rem; }
        }

        @media (max-width: 480px) {
            .hero h1 { font-size: 1.8rem; }
            .hero-btns { flex-direction: column; }
            .btn { width: 100%; text-align: center; }
            .pricing-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <!-- 1. NAVBAR -->
    <header id="navbar">
        <div class="container nav-container">
            <a href="#" class="logo">
                <img src="{{ asset('logo.png') }}" alt="Gymdesk15 Logo" style="height: 48px; width: auto;">
            </a>
            <nav class="nav-links">
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#pricing">Pricing</a>
                <a href="#contact">Contact</a>
            </nav>
            <div style="display:flex; align-items:center; gap:25px;">
                @if (Route::has('login'))
                    @auth
                        <div style="display:flex; align-items:center; gap:20px;">
                            <a href="{{ url('/dashboard') }}" class="login-link">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="login-link" style="background:none; border:none; cursor:pointer; font-family:inherit; padding:0;">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="login-link">Login</a>
                    @endauth
                @endif
                <a href="#pricing" class="btn btn-primary nav-btn" style="box-shadow: 0 0 15px rgba(233,69,96,0.3); padding: 8px 16px; font-size: 0.85rem;">Get Started Free</a>
            </div>
        </div>
    </header>

    <!-- 2. HERO SECTION -->
    <section class="hero" id="home">
        <canvas id="particles-js"></canvas>
        <div class="container hero-content">
            <div class="hero-text fade-up">
                <div class="badge">
                    <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:14px; margin-right:6px;"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    Trusted by Gym Owners
                </div>
                <h1>Stop Managing Your Gym on Excel or paper. <br><span style="color:var(--primary)" id="typing-text"></span><span class="cursor">|</span></h1>
                <p>Gymdesk15 gives you complete control over members, staff, payments and revenue — from one powerful dashboard.</p>
                <div class="hero-btns">
                    <a href="#pricing" class="btn btn-primary">See Live Demo</a>
                    <a href="#video-section" class="btn btn-outline" style="display:inline-flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Watch Video
                    </a>
                </div>
            </div>
            
            <div class="hero-image fade-up" style="transition-delay: 0.2s">
                <div class="dashboard-image-container">
                    <img src="{{ asset('dashboard.png') }}" alt="Gymdesk15 Dashboard" class="dashboard-image">
                </div>
            </div>
        </div>
    </section>

    <!-- 3. PROBLEM SECTION -->
    <section class="problem-section" id="problem">
        <div class="container">
            <h2 class="section-title fade-up">Sound Familiar?</h2>
            <div class="cards-grid-3">
                <div class="problem-card fade-up">
                    <div class="problem-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V12c0-1.1-.9-2-2-2H8.5V8.5H11v-1h-2.5V6h3.5c1.1 0 2 .9 2 2v6.09l1.41 1.41-1.41 1.41-1.41-1.41zM11 15h2v2h-2v-2zM12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8z"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 12h-4v4h-2v-4H7v-2h4V8h2v4h4v2z"/></svg>
                    </div>
                    <h3>Chasing late payments on WhatsApp</h3>
                    <p style="margin-top: 15px; font-size: 0.9rem; color: var(--text-secondary);">Manual follow-ups waste hours and feel unprofessional to your clients.</p>
                </div>
                <div class="problem-card fade-up" style="transition-delay: 0.1s">
                    <div class="problem-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14H7v-2h5v2zm5-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <h3>Tracking staff salaries in Excel sheets</h3>
                    <p style="margin-top: 15px; font-size: 0.9rem; color: var(--text-secondary);">Spreadsheets break. One wrong formula and your payroll is a disaster.</p>
                </div>
                <div class="problem-card fade-up" style="transition-delay: 0.2s">
                    <div class="problem-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-1.48.41-2.86 1.12-4.06l10.94 10.94C14.86 19.59 13.48 20 12 20zm6.88-5.94L7.94 3.12C9.14 2.41 10.52 2 12 2c4.41 0 8 3.59 8 8 0 1.48-.41 2.86-1.12 4.06zM11 7h2v2h-2V7z"/></svg>
                    </div>
                    <h3>No idea which members expired today</h3>
                    <p style="margin-top: 15px; font-size: 0.9rem; color: var(--text-secondary);">Losing track of renewals means losing revenue you've already earned.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. FEATURES SECTION -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title fade-up">Everything You Need to Run Your Gym</h2>
            <div class="features-grid cards-grid-3">
                
                <div class="feature-card fade-up">
                    <span class="feature-icon-text">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </span>
                    <h3>Member Management</h3>
                    <p>Add, track, renew memberships instantly. Keep all your client data in one secure place.</p>
                </div>
                
                <div class="feature-card fade-up" style="transition-delay: 0.1s">
                    <span class="feature-icon-text">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M11.8 2.1c-3.1 0-5.6 2.5-5.6 5.6s2.5 5.6 5.6 5.6 5.6-2.5 5.6-5.6-2.5-5.6-5.6-5.6zm1.1 8.2h-2.2v-1.1h2.2v1.1zm0-2.2h-2.2v-3.3H8.5V3.7h4.4v4.4zM21 13H3c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2v-2c0-1.1-.9-2-2-2zm-1 4H4v-1h16v1z"/></svg>
                    </span>
                    <h3>Payment Tracking</h3>
                    <p>Know who paid and who owes you, in real time. Automate payment reminders.</p>
                </div>
                
                <div class="feature-card fade-up" style="transition-delay: 0.2s">
                    <span class="feature-icon-text">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/></svg>
                    </span>
                    <h3>Staff & Salaries</h3>
                    <p>Manage your team and payroll in one place. Track attendance and performance.</p>
                </div>
                
                <div class="feature-card fade-up">
                    <span class="feature-icon-text">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                    </span>
                    <h3>Revenue Dashboard</h3>
                    <p>See your gym's financial health at a glance. Visual charts and exportable reports.</p>
                </div>
                
                <div class="feature-card fade-up" style="transition-delay: 0.1s">
                    <span class="feature-icon-text">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>
                    </span>
                    <h3>Mobile Access</h3>
                    <p>Run your gym directly from your phone. Full responsive access anywhere.</p>
                </div>
                
                <div class="feature-card fade-up" style="transition-delay: 0.2s">
                    <span class="feature-icon-text">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                    </span>
                    <h3>Automated Alerts</h3>
                    <p>Get notified when memberships expire or stock runs low automatically.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. HOW IT WORKS SECTION -->
    <section class="how-it-works" id="how-it-works">
        <canvas class="section-stars" id="how-it-works-stars"></canvas>
        <div class="container" style="position:relative; z-index:1;">
            <h2 class="section-title fade-up">Up and Running in 3 Simple Steps</h2>
            <div class="steps-container">
                <div class="steps-line">
                    <div class="steps-line-progress" id="steps-progress"></div>
                </div>
                
                <div class="step fade-up" id="step-1">
                    <div class="step-number">01</div>
                    <h3>Create Your Gym Profile</h3>
                    <p>Set up your branch, branding, and billing details in minutes.</p>
                </div>
                
                <div class="step fade-up" style="transition-delay: 0.2s" id="step-2">
                    <div class="step-number">02</div>
                    <h3>Add Members & Staff</h3>
                    <p>Import existing data easily or start fresh with quick entry forms.</p>
                </div>
                
                <div class="step fade-up" style="transition-delay: 0.4s" id="step-3">
                    <div class="step-number">03</div>
                    <h3>Track Everything</h3>
                    <p>Watch your business grow with real-time analytics and alerts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. STATS SECTION -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item fade-up">
                    <div class="stat-number"><span class="counter" data-target="60">0</span>%</div>
                    <div class="stat-label">Reduction in Payment Loss</div>
                </div>
                <div class="stat-item fade-up" style="transition-delay: 0.1s">
                    <div class="stat-number"><span class="counter" data-target="100">0</span>%</div>
                    <div class="stat-label">Members Tracked</div>
                </div>
                <div class="stat-item fade-up" style="transition-delay: 0.2s">
                    <div class="stat-number"><span class="counter" data-target="3">0</span>x</div>
                    <div class="stat-label">Faster Admin Work</div>
                </div>
                <div class="stat-item fade-up" style="transition-delay: 0.3s">
                    <div class="stat-number"><span class="counter" data-target="1">0</span></div>
                    <div class="stat-label">Dashboard for Everything</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TESTIMONIALS SECTION -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <h2 class="section-title fade-up">What Gym Owners Are Saying</h2>
            <div class="cards-grid-3">
                
                <div class="testimonial-card fade-up">
                    <div class="stars">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                    </div>
                    <p class="quote-text">"Finally I know exactly who paid and who didn't. No more WhatsApp chasing. This software completely changed how I run things."</p>
                    <div class="author">
                        <div class="avatar" style="background: linear-gradient(135deg, #D90429 0%, #7d0218 100%); color:white;">AR</div>
                        <div class="author-info">
                            <h4>Ahmed R.</h4>
                            <p>Gym Owner, Lahore</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-up" style="transition-delay: 0.1s">
                    <div class="stars">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                    </div>
                    <p class="quote-text">"Managing 3 branches used to be a nightmare. Now it takes 10 minutes a day. The financial clarity is incredible."</p>
                    <div class="author">
                        <div class="avatar" style="background: linear-gradient(135deg, #1a1aff 0%, #0000a0 100%); color:white;">SK</div>
                        <div class="author-info">
                            <h4>Sara K.</h4>
                            <p>Fitness Studio Owner</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-up" style="transition-delay: 0.2s">
                    <div class="stars">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:20px; color:#FFB800;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                    </div>
                    <p class="quote-text">"The staff salary module alone saved me hours every month. It’s so simple yet powerful. Worth every penny."</p>
                    <div class="author">
                        <div class="avatar" style="background: linear-gradient(135deg, #27c93f 0%, #157324 100%); color:white;">BM</div>
                        <div class="author-info">
                            <h4>Bilal M.</h4>
                            <p>Personal Trainer</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 8. PRICING SECTION -->
    <section class="pricing-section cards-grid-3" id="pricing" style="display:block;">
        <div class="container">
            <h2 class="section-title fade-up">Simple, Transparent Pricing</h2>
            <div class="cards-grid-3 pricing-grid">
                
                <!-- Starter -->
                <div class="pricing-card fade-up">
                    <h3 class="plan-name">Starter</h3>
                    <div class="plan-price">$29<span>/mo</span></div>
                    <ul class="plan-features">
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Up to 200 active members</li>

                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Advanced revenue analytics</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Staff & Salary management</li>                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> 1 Admin user</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="border-radius: 12px;">Start For Free</a>
                </div>

                <!-- Pro -->
                <div class="pricing-card popular fade-up" style="transition-delay: 0.1s">
                    <div class="popular-badge">Most Popular</div>
                    <h3 class="plan-name">Pro</h3>
                    <div class="plan-price">$49<span>/mo</span></div>
                    <ul class="plan-features">
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Up to 400 members</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Advanced revenue analytics</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Staff & Salary management</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Priority support</li>
                    </ul>
                    <a href="#" class="btn btn-primary" style="border-radius: 12px; box-shadow: 0 10px 20px var(--primary-glow);">Get Pro Now</a>
                </div>

                <!-- Enterprise -->
                <div class="pricing-card fade-up" style="transition-delay: 0.2s">
                    <h3 class="plan-name">Enterprise</h3>
                    <div class="plan-price">Custom</div>
                    <ul class="plan-features">
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Multiple branch support</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Full API access</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Dedicated support</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="border-radius: 12px;">Contact Sales</a>
                </div>

            </div>
        </div>
    </section>

    <!-- 8.5 VIDEO SECTION -->
    <section class="video-section" id="video-section">
        <canvas class="section-stars" id="video-section-stars"></canvas>
        <div class="container" style="position:relative; z-index:1;">
            <h2 class="section-title fade-up">See Gymdesk15 in Action</h2>
            <div class="video-wrapper fade-up" id="video-wrapper">
                <div class="video-overlay" id="video-overlay" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:2; background:rgba(0,0,0,0.4); display:flex; align-items:center; justify-content:center; cursor:pointer;">
                    <div class="play-button">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"></path></svg>
                    </div>
                </div>
                <video id="main-video" style="width:100%; height:100%; display:block; border-radius: 20px;" poster="{{ asset('dashboard.png') }}">
                    <source src="{{ asset('Demo-Gymdesk15.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </section>

    <!-- 9. FOOTER -->
    <footer id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-logo-col">
                    <a href="#" class="logo footer-logo">
                        <img src="{{ asset('logo.png') }}" alt="GymDesk15 Logo" style="height: 48px; width: auto; margin-bottom: 10px;">
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
                        <li><a href="#">Updates</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
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

    <!-- SCRIPTS -->
    <script>
        // 1. Navbar Scroll Effect
        const header = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // 2. Typing Effect for Hero
        const typingText = document.getElementById('typing-text');
        const textToType = "Start Running It Like a Business.";
        let charIndex = 0;
        
        function type() {
            if(charIndex < textToType.length) {
                typingText.innerHTML += textToType.charAt(charIndex);
                charIndex++;
                setTimeout(type, 100);
            } else {
                // blinking cursor is handled by css animation if we wanted, or just leave text
                document.querySelector('.cursor').style.animation = "blink 1s infinite step-end";
            }
        }
        
        // Add cursor blinking style dynamically
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes blink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0; }
            }
            .cursor { font-weight: 300; margin-left: 2px; }
        `;
        document.head.appendChild(style);
        
        // Start typing after short delay
        setTimeout(type, 500);

        // 3. Intersection Observer for Fade-Up animations
        const fadeElements = document.querySelectorAll('.fade-up');
        
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    
                    // Specific logic for counters
                    if(entry.target.classList.contains('stat-item')) {
                        const counter = entry.target.querySelector('.counter');
                        if(counter && !counter.classList.contains('counted')) {
                            startCounter(counter);
                            counter.classList.add('counted');
                        }
                    }
                    
                    // Specific logic for steps pipeline
                    if(entry.target.id === 'step-1') updateStepsPath(33);
                    if(entry.target.id === 'step-2') { updateStepsPath(66); document.getElementById('step-1').classList.add('active'); }
                    if(entry.target.id === 'step-3') { updateStepsPath(100); document.getElementById('step-2').classList.add('active'); document.getElementById('step-3').classList.add('active'); }
                    
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        fadeElements.forEach(el => {
            observer.observe(el);
        });

        // 4. Counter Animation logic
        function startCounter(counterEl) {
            const target = +counterEl.getAttribute('data-target');
            const duration = 2000; // ms
            const stepTime = Math.abs(Math.floor(duration / target)) || 20;
            let current = 0;
            
            const timer = setInterval(() => {
                current += Math.ceil(target / 50) || 1;
                if(current >= target) {
                    counterEl.innerText = target;
                    clearInterval(timer);
                } else {
                    counterEl.innerText = current;
                }
            }, stepTime);
        }

        // 5. Steps progress line logic
        function updateStepsPath(percentage) {
            const progressLine = document.getElementById('steps-progress');
            if(progressLine) {
                progressLine.style.width = percentage + '%';
            }
        }

        // 6. Refactored StarField logic
        class StarField {
            constructor(canvasId, parentSelector, colors = null) {
                this.canvas = document.getElementById(canvasId);
                if (!this.canvas) return;
                this.ctx = this.canvas.getContext('2d');
                this.parent = document.querySelector(parentSelector);
                this.particles = [];
                this.width = 0;
                this.height = 0;
                this.colors = colors;
                
                this.init();
            }

            init() {
                this.resize();
                this.createParticles();
                this.animate();
                window.addEventListener('resize', () => this.resize());
            }

            resize() {
                this.width = this.canvas.width = window.innerWidth;
                this.height = this.canvas.height = this.parent.offsetHeight;
                this.createParticles(); // Recreate on resize for density
            }

            createParticles() {
                this.particles = [];
                const density = 5000;
                const count = Math.floor((this.width * this.height) / density);
                for (let i = 0; i < count; i++) {
                    this.particles.push(new Particle(this.width, this.height, this.colors));
                }
            }

            animate() {
                this.ctx.clearRect(0, 0, this.width, this.height);
                this.particles.forEach(p => {
                    p.update(this.width, this.height);
                    p.draw(this.ctx);
                });
                requestAnimationFrame(() => this.animate());
            }
        }

        class Particle {
            constructor(width, height, colors = null) {
                this.reset(width, height, colors);
            }

            reset(width, height, colors = null) {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.size = Math.random() * 2.5;
                this.opacity = Math.random() * 0.5 + 0.2;
                this.twinkleSpeed = 0.008 + Math.random() * 0.012;
                this.driftX = (Math.random() - 0.5) * 0.08;
                this.driftY = (Math.random() - 0.5) * 0.08;
                
                if (colors && colors.length > 0) {
                    this.color = colors[Math.floor(Math.random() * colors.length)];
                } else {
                    this.color = Math.random() > 0.7 ? '#D90429' : (Math.random() > 0.4 ? '#ffffff' : '#ffd700');
                }
                
                this.glow = Math.random() > 0.6;
            }

            update(width, height) {
                this.x += this.driftX;
                this.y += this.driftY;
                this.opacity += this.twinkleSpeed * (this.glow ? 1.5 : 1);
                
                if (this.opacity > 1 || this.opacity < 0.2) {
                    this.twinkleSpeed *= -1;
                }

                if(this.x > width) this.x = 0;
                if(this.x < 0) this.x = width;
                if(this.y > height) this.y = 0;
                if(this.y < 0) this.y = height;
            }

            draw(ctx) {
                ctx.globalAlpha = this.opacity;
                ctx.fillStyle = this.color;
                if (this.glow) {
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = this.color;
                }
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
                ctx.shadowBlur = 0; // Reset for next particle
                ctx.globalAlpha = 1;
            }
        }

        // Initialize starfields for different sections
        document.addEventListener('DOMContentLoaded', () => {
            new StarField('particles-js', '.hero');
            new StarField('how-it-works-stars', '.how-it-works');
            new StarField('video-section-stars', '.video-section', ['#ffffff']);
        });

        // 7. Video Playback Logic
        const videoWrapper = document.getElementById('video-wrapper');
        const videoOverlay = document.getElementById('video-overlay');
        const mainVideo = document.getElementById('main-video');

        if (videoOverlay && mainVideo) {
            videoOverlay.addEventListener('click', () => {
                videoOverlay.style.display = 'none';
                mainVideo.setAttribute('controls', 'true');
                mainVideo.play();
            });

            mainVideo.addEventListener('pause', () => {
                // Optional: show overlay back if video pauses
                // videoOverlay.style.display = 'flex';
            });
        }

    </script>
</body>
</html>
