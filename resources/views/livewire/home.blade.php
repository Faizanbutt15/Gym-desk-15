<div>
    <!-- 2. HERO SECTION -->
    <section class="hero" id="home">
        <div id="particles-js"></div>
        <div class="container hero-content">
            <div class="hero-text fade-up">
                <div class="badge">
                    <svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:14px; margin-right:6px;"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    Trusted by Gym Owners
                </div>
                <h1><span class="scramble-static">Stop Managing Your Gym on Excel or paper.</span> <br><span style="color:var(--primary)" id="typing-text"></span><span class="cursor">|</span></h1>
                <p>Gymdesk15 gives you complete control over members, staff, payments and revenue — from one powerful dashboard.</p>
                <div class="hero-btns">
                    <a href="#" wire:click.prevent="setPage('contact')" class="btn btn-primary">Request Demo</a>
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
                <div class="pricing-card fade-up">
                    <h3 class="plan-name">Starter</h3>
                    <div class="plan-price">$29<span>/mo</span></div>
                    <ul class="plan-features">
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Up to 200 active members</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Advanced revenue analytics</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Staff & Salary management</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> 1 Admin user</li>
                    </ul>
                    <a href="#" wire:click.prevent="setPage('contact')" class="btn btn-outline" style="border-radius: 12px;">Contact Us</a>
                </div>
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
                    <a href="#" wire:click.prevent="setPage('contact')" class="btn btn-primary" style="border-radius: 12px; box-shadow: 0 10px 20px var(--primary-glow);">Get Pro Now</a>
                </div>
                <div class="pricing-card fade-up" style="transition-delay: 0.2s">
                    <h3 class="plan-name">Enterprise</h3>
                    <div class="plan-price">Custom</div>
                    <ul class="plan-features">
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Multiple branch support</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Full API access</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor" stroke="none" style="width:16px; color:var(--primary);"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> Dedicated support</li>
                    </ul>
                    <a href="#" wire:click.prevent="setPage('contact')" class="btn btn-outline" style="border-radius: 12px;">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 8.5 VIDEO SECTION -->
    <section class="video-section" id="video-section">
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
</div>
