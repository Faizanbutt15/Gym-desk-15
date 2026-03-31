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
            opacity: 0.8;
            background-image: 
                radial-gradient(1px 1px at 10% 10%, #fff, transparent),
                radial-gradient(1px 1px at 20% 50%, #fff, transparent),
                radial-gradient(2px 2px at 30% 90%, #fff, transparent),
                radial-gradient(1px 1px at 40% 40%, #fff, transparent),
                radial-gradient(2px 2px at 50% 10%, #fff, transparent),
                radial-gradient(1px 1px at 60% 70%, #fff, transparent),
                radial-gradient(1px 1px at 70% 30%, #fff, transparent),
                radial-gradient(2px 2px at 80% 80%, #fff, transparent),
                radial-gradient(1px 1px at 90% 20%, #fff, transparent),
                radial-gradient(1px 1px at 15% 75%, #fff, transparent),
                radial-gradient(2px 2px at 45% 65%, #fff, transparent),
                radial-gradient(1px 1px at 85% 45%, #fff, transparent);
            background-size: 300px 300px;
            animation: stars-move 150s linear infinite;
        }

        @keyframes stars-move {
            from { background-position: 0 0; }
            to { background-position: 300px 600px; }
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
            min-width: 0;
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
            font-size: clamp(2rem, 4.5vw, 2.8rem);
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
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
            z-index: 10;
        }

        /* Glitch Animation for Image */
        .glitch-active {
            animation: glitch-anim 0.25s infinite !important;
            filter: hue-rotate(90deg) contrast(1.3) brightness(1.1);
            opacity: 0.9;
        }

        @keyframes glitch-anim {
            0% { transform: translate(0); }
            20% { transform: translate(-4px, 2px); }
            40% { transform: translate(-4px, -2px); }
            60% { transform: translate(4px, 2px); }
            80% { transform: translate(4px, -2px); }
            100% { transform: translate(0); }
        }

        .dashboard-image {
            width: 100%;
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
    @livewireStyles
</head>
<body>
    <livewire:landing />

    @livewireScripts
    <!-- SCRIPTS -->
    <script>
        // Store instances for re-init
        let starfields = [];
        let observer;
        let typingTimeout;
        let scrambleInterval;

        function scrambleText(element, targetText, syncElement = null) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
            let iteration = 0;
            if (scrambleInterval) clearInterval(scrambleInterval);
            
            // Start glitch on sync element
            if (syncElement) syncElement.classList.add('glitch-active');
            
            scrambleInterval = setInterval(() => {
                element.innerText = targetText
                    .split("")
                    .map((char, index) => {
                        if (index < iteration) {
                            return targetText[index];
                        }
                        if (targetText[index] === ' ') return ' ';
                        return chars[Math.floor(Math.random() * chars.length)];
                    })
                    .join("");
                
                if (iteration >= targetText.length) {
                    clearInterval(scrambleInterval);
                    // Stop glitch on sync element
                    if (syncElement) syncElement.classList.remove('glitch-active');
                }
                
                iteration += targetText.length / 40; // Smoother gradual transition
            }, 25);
        }

        function initAll() {
            console.log('initAll triggered');
            // 0. Scramble Hero Title + Glitch Image
            const heroTitle = document.querySelector('.hero h1 .scramble-static');
            const dashContainer = document.querySelector('.dashboard-image-container');
            if (heroTitle) {
                scrambleText(heroTitle, "Stop Managing Your Gym on Excel or paper.", dashContainer);
            }

            // 1. Navbar Scroll Effect
            const header = document.getElementById('navbar');
            console.log('Navbar found:', !!header);
            if (header) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                });
            }

            // 2. Typing Effect for Hero (only on home)
            const typingText = document.getElementById('typing-text');
            if (typingText) {
                if (typingTimeout) clearTimeout(typingTimeout);
                typingText.innerHTML = ''; // Reset
                const textToType = "Start Running It Like a Business.";
                let charIndex = 0;
                
                function type() {
                    if(charIndex < textToType.length) {
                        typingText.innerHTML += textToType.charAt(charIndex);
                        charIndex++;
                        typingTimeout = setTimeout(type, 100);
                    } else {
                        const cursor = document.querySelector('.cursor');
                        if (cursor) cursor.style.animation = "blink 1s infinite step-end";
                    }
                }
                typingTimeout = setTimeout(type, 500);
            }
            
            // 3. Intersection Observer for Fade-Up animations
            const fadeElements = document.querySelectorAll('.fade-up');
            console.log('Fade-up elements found:', fadeElements.length);
            
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            if (observer) observer.disconnect();
            observer = new IntersectionObserver((entries, observer) => {
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
                        if(entry.target.id === 'step-2') { updateStepsPath(66); document.getElementById('step-1')?.classList.add('active'); }
                        if(entry.target.id === 'step-3') { updateStepsPath(100); document.getElementById('step-2')?.classList.add('active'); document.getElementById('step-3')?.classList.add('active'); }
                        
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

            // 7. Video Playback Logic
            const videoOverlay = document.getElementById('video-overlay');
            const mainVideo = document.getElementById('main-video');
            
            if (videoOverlay && mainVideo) {
                videoOverlay.addEventListener('click', () => {
                    videoOverlay.style.display = 'none';
                    mainVideo.play();
                    mainVideo.setAttribute('controls', 'true');
                });
            }
        }

        // Initialize on load
        document.addEventListener('livewire:initialized', () => {
             console.log('livewire:initialized fired');
            setTimeout(initAll, 100);
        });

        // Fallback for initial load if livewire:initialized is missed
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOMContentLoaded fired');
            setTimeout(initAll, 500); 
        });

        // Re-initialize on Livewire page change
        document.addEventListener('page-changed', () => {
            console.log('page-changed event received');
            setTimeout(initAll, 100);
            window.scrollTo({ top: 0, behavior: 'instant' });
        });

        // Handle cross-page scrolling
        document.addEventListener('scroll-to-section', (event) => {
            const section = event.detail.section;
            console.log('Scrolling to section:', section);
            
            // Small delay to allow home component to render if we just switched pages
            setTimeout(() => {
                const element = document.getElementById(section);
                if (element) {
                    const headerOffset = 80;
                    const elementPosition = element.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                } else {
                    console.warn('Section element not found:', section);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }, 150);
        });

        // Final safety fallback: Show all after 3 seconds if still hidden
        setTimeout(() => {
            const hiddenElements = document.querySelectorAll('.fade-up:not(.visible)');
            if (hiddenElements.length > 0) {
                console.warn('Safety fallback: Showing ' + hiddenElements.length + ' hidden elements');
                hiddenElements.forEach(el => el.classList.add('visible'));
            }
        }, 3000);

    </script>
</body>
</html>
