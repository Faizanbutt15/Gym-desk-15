<div class="contact-container" style="padding: 120px 0 80px; min-height: 80vh; background: radial-gradient(circle at 80% 30%, #1a0a0f 0%, #0b0c10 100%);">
    <div class="container">
        <h1 class="section-title fade-up visible">Get In Touch</h1>
        <p style="text-align: center; max-width: 600px; margin: 0 auto 60px; font-size: 1.1rem;" class="fade-up visible">
            Have questions about how Gymdesk15 can transform your business? Our team is here to help you scale.
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 60px; margin-top: 40px;">
            <div class="fade-up visible">
                <h2 style="margin-bottom: 30px; color: var(--primary);">Contact Information</h2>
                
                <div style="display: flex; flex-direction: column; gap: 30px;">
                    <div style="display: flex; gap: 20px; align-items: flex-start;">
                        <div style="width: 44px; height: 44px; background: var(--primary-transparent); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px;">Email Us</h4>
                            <p style="color: var(--text-secondary);">faizanbutt15@yahoo.com</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; align-items: flex-start;">
                        <div style="width: 44px; height: 44px; background: var(--primary-transparent); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px;">Call Us</h4>
                            <p style="color: var(--text-secondary);">+92 302 795970</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; align-items: flex-start;">
                        <div style="width: 44px; height: 44px; background: var(--primary-transparent); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px;">Support Hours</h4>
                            <p style="color: var(--text-secondary);">Mon - Sat: 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fade-up visible" style="transition-delay: 0.2s;">
                <div style="background: var(--glass-bg); border: 1px solid var(--glass-border); padding: 40px; border-radius: 24px;">
                    @if ($successMessage)
                        <div style="background: rgba(39, 201, 63, 0.1); border: 1px solid #27c93f; color: #27c93f; padding: 20px; border-radius: 12px; margin-bottom: 20px; text-align: center;">
                            {{ $successMessage }}
                        </div>
                    @endif

                    <form wire:submit.prevent="sendMessage" style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <label style="font-size: 0.9rem; font-weight: 500;">Name</label>
                                <input type="text" wire:model="name" placeholder="John Doe" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); padding: 12px; border-radius: 10px; color: white;">
                                @error('name') <span style="color: var(--primary); font-size: 0.8rem;">{{ $message }}</span> @enderror
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <label style="font-size: 0.9rem; font-weight: 500;">Email</label>
                                <input type="email" wire:model="email" placeholder="john@example.com" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); padding: 12px; border-radius: 10px; color: white;">
                                @error('email') <span style="color: var(--primary); font-size: 0.8rem;">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 0.9rem; font-weight: 500;">Message</label>
                            <textarea wire:model="message" placeholder="How can we help?" rows="4" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); padding: 12px; border-radius: 10px; color: white; resize: none;"></textarea>
                            @error('message') <span style="color: var(--primary); font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                            <span wire:loading.remove>Send Message</span>
                            <span wire:loading>Sending...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
