<div>
    @push('landScripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onDemoCaptcha(token) {
                @this.set('captcha', token);
            }
            function onContactCaptcha(token) {
                @this.set('captcha', token);
            }
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('reset-captcha', () => {
                    try {
                        grecaptcha.reset();
                    } catch(e) { console.log('Captcha reset pending...'); }
                });
            });
        </script>
    @endpush
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" wire:key="alert-{{ now()->timestamp }}" style="background: #d1fae5; color: #065f46; padding: 15px; padding-right: 40px; text-align: center; font-weight: 600; position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 3000; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 90%; max-width: 400px;">
            {!! session('success') !!}
            <button @click="show = false" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 20px; cursor: pointer; color: #065f46; line-height: 1;">
                &times;
            </button>
        </div>
    @endif
    <section class="cta" id="contact">
        <div class="container">
            <h2 data-translate="cta_title">Ready to Secure Your Airspace?</h2>
            <p data-translate="cta_subtitle">Join hundreds of organizations trusting SkyGuardian for their aviation monitoring needs.</p>
            <div class="cta-buttons">
                <button onclick="openModal('demoModal')" class="btn-primary" aria-label="Request Demo" data-translate="cta_btn1">Request Demo</button>
                <button onclick="openModal('contactModal')" class="btn-secondary" aria-label="Contact Sales" data-translate="cta_btn2">Contact Sales</button>
            </div>
            <div class="cta-footer">
                🇪🇪 <span data-translate="cta_footer">Proudly developed in Estonia</span>
            </div>
        </div>
    </section>
    <div id="demoModal" class="modal" wire:ignore.self>
        <button class="modal-close" onclick="closeAllModals()">×</button>
        <div class="modal-header">
            <h3 data-translate="modal_demo_title">Request a Demo</h3>
            <p data-translate="modal_demo_desc">See SkyGuardian in action. Fill out the form below.</p>
        </div>
        <form wire:submit.prevent="submitDemo">
            <div class="form-group">
                <label data-translate="form_name">Full Name</label>
                <input type="text" wire:model="name" class="form-input" placeholder="John Doe" required>
                @error('name') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label data-translate="form_email">Email Address</label>
                <input type="email" wire:model="email" class="form-input" placeholder="john@company.com" required>
                @error('email') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label data-translate="form_company">Company (Optional)</label>
                <input type="text" wire:model="company" class="form-input" placeholder="Organization Name">
            </div>
            <div class="form-group" wire:ignore>
                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}" data-callback="onDemoCaptcha"></div>
            </div>
            @error('captcha') <span style="color:red; font-size:12px; display:block; margin-bottom:10px;">{{ $message }}</span> @enderror
            <button type="submit" class="btn-primary" style="width: 100%;">
                <span wire:loading.remove wire:target="submitDemo" data-translate="form_submit_demo">Schedule Demo</span>
                <span wire:loading wire:target="submitDemo">Verifying...</span>
            </button>
        </form>
    </div>
    <div id="contactModal" class="modal" wire:ignore.self>
        <button class="modal-close" onclick="closeAllModals()">×</button>
        <div class="modal-header">
            <h3 data-translate="modal_contact_title">Contact Sales</h3>
            <p data-translate="modal_contact_desc">Get a custom quote for your organization.</p>
        </div>
        <form wire:submit.prevent="submitContact">
            <div class="form-group">
                <label data-translate="form_name">Full Name</label>
                <input type="text" wire:model="name" class="form-input" required>
                @error('name') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label data-translate="form_email">Email Address</label>
                <input type="email" wire:model="email" class="form-input" required>
                @error('email') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label data-translate="form_message">Message</label>
                <textarea class="form-input" wire:model="message" rows="4" required></textarea>
                @error('message') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" wire:ignore>
                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}" data-callback="onContactCaptcha"></div>
            </div>
            @error('captcha') <span style="color:red; font-size:12px; display:block; margin-bottom:10px;">{{ $message }}</span> @enderror
            <button type="submit" class="btn-primary" style="width: 100%;">
                <span wire:loading.remove wire:target="submitContact" data-translate="form_submit_contact">Send Message</span>
                <span wire:loading wire:target="submitContact" data-translate="form_verifying">Verifying...</span>
            </button>
        </form>
    </div>
</div>
