<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Theme init: prevent flash of wrong theme --}}
        <script>
            (function() {
                var theme = localStorage.getItem('theme');
                if (theme === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #D90429;
                --primary-glow: rgba(217, 4, 41, 0.4);
            }
            #guest-stars {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                pointer-events: none;
            }
            .auth-card {
                backdrop-filter: blur(12px);
                background: rgba(255, 255, 255, 0.03) !important;
                border: 1px solid rgba(255, 255, 255, 0.08) !important;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            }
        </style>
    </head>
    <body class="font-sans text-zinc-700 dark:text-zinc-300 antialiased overflow-hidden">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-100 dark:bg-zinc-950 relative" style="background: radial-gradient(circle at 50% 50%, #1a0a0f 0%, #0b0c10 100%);">
            <canvas id="guest-stars"></canvas>

            {{-- Theme toggle in top-right corner --}}
            <div class="absolute top-4 right-4">
                <button id="theme-toggle"
                        onclick="toggleTheme()"
                        class="w-9 h-9 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-all focus:outline-none shadow-sm"
                        title="Toggle theme">
                    <svg id="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    <svg id="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>
            </div>

            <div>
                <a href="/">
                    <x-application-logo class="w-48 h-30 border rounded-md    " />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-zinc-900 shadow-md dark:shadow-zinc-950 overflow-hidden sm:rounded-xl border border-zinc-200 dark:border-zinc-800 text-zinc-800 dark:text-zinc-200 auth-card relative z-10">
                {{ $slot }}
            </div>
        </div>

        <script>
            function toggleTheme() {
                var html = document.documentElement;
                var sun  = document.getElementById('theme-icon-sun');
                var moon = document.getElementById('theme-icon-moon');

                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    sun.classList.add('hidden');
                    moon.classList.remove('hidden');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    moon.classList.add('hidden');
                    sun.classList.remove('hidden');
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                var sun  = document.getElementById('theme-icon-sun');
                var moon = document.getElementById('theme-icon-moon');
                if (!document.documentElement.classList.contains('dark')) {
                    sun.classList.add('hidden');
                    moon.classList.remove('hidden');
                }
            });

            // --- StarField System ---
            class StarField {
                constructor(canvasId) {
                    this.canvas = document.getElementById(canvasId);
                    if (!this.canvas) return;
                    this.ctx = this.canvas.getContext('2d');
                    this.particles = [];
                    this.width = 0;
                    this.height = 0;
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
                    this.height = this.canvas.height = window.innerHeight;
                    this.createParticles();
                }
                createParticles() {
                    this.particles = [];
                    const density = 5000;
                    const count = Math.floor((this.width * this.height) / density);
                    for (let i = 0; i < count; i++) {
                        this.particles.push(new Particle(this.width, this.height));
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
                constructor(width, height) { this.reset(width, height); }
                reset(width, height) {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.size = Math.random() * 2;
                    this.opacity = Math.random();
                    this.twinkleSpeed = 0.005 + Math.random() * 0.01;
                    this.driftX = (Math.random() - 0.5) * 0.05;
                    this.driftY = (Math.random() - 0.5) * 0.05;
                    this.color = Math.random() > 0.9 ? '#D90429' : '#ffffff';
                }
                update(width, height) {
                    this.x += this.driftX; this.y += this.driftY;
                    this.opacity += this.twinkleSpeed;
                    if (this.opacity > 1 || this.opacity < 0.1) this.twinkleSpeed *= -1;
                    if(this.x > width) this.x = 0; if(this.x < 0) this.x = width;
                    if(this.y > height) this.y = 0; if(this.y < 0) this.y = height;
                }
                draw(ctx) {
                    ctx.globalAlpha = this.opacity;
                    ctx.fillStyle = this.color;
                    ctx.beginPath(); ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2); ctx.fill();
                    ctx.globalAlpha = 1;
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                new StarField('guest-stars');
            });
        </script>
    </body>
</html>
