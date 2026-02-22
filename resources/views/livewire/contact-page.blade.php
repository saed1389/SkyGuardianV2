<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/contact.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    @push('landScripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onPageContactCaptcha(token) {
                @this.set('captcha', token);
            }
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('reset-page-captcha', () => {
                    try { grecaptcha.reset(); } catch(e) {}
                });
            });
        </script>
    @endpush

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" wire:key="contact-alert-{{ now()->timestamp }}" style="background: #d1fae5; color: #065f46; padding: 15px; padding-right: 40px; text-align: center; font-weight: 600; position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 3000; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 90%; max-width: 400px;">
            {!! session('message') !!}
            <button @click="show = false"
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 20px; cursor: pointer; color: #065f46; line-height: 1;">
                &times;
            </button>
        </div>
    @endif
    <header class="contact-header">
        <h1 data-translate="contact_title">Get in Touch</h1>
        <p data-translate="contact_subtitle">Global support for local airspace security.</p>
    </header>
    <div class="contact-grid">
        <div class="contact-details">
            <h3 data-translate="contact_info_h3">Contact Information</h3>
            <div class="detail-item">
                <label data-translate="contact_office_label">Tallinn HQ</label>
                <p>Harju maakond, Tallinn, Põhja-Tallinna linnaosa, Telliskivi tn 57, 10412, Estonia</p>
            </div>
            <div class="detail-item">
                <label data-translate="contact_email_label">Email</label>
                <p>security@skyguardian.ee</p>
            </div>
            <div class="detail-item">
                <label data-translate="contact_phone_label">Phone</label>
                <p>+372 555 000 00</p>
            </div>
        </div>
        <div class="contact-box">
            <form wire:submit.prevent="sendMessage">
                <div class="form-group">
                    <label data-translate="form_name">Name</label>
                    <input type="text" wire:model="name" class="form-input" placeholder="Your full name">
                    @error('name') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label data-translate="form_email">Email</label>
                    <input type="email" wire:model="email" class="form-input" placeholder="name@company.com">
                    @error('email') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label data-translate="form_message">Message</label>
                    <textarea wire:model="message" class="form-input" rows="5" placeholder="How can we help you?"></textarea>
                    @error('message') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" wire:ignore style="margin-bottom: 20px;">
                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}" data-callback="onPageContactCaptcha"></div>
                </div>
                @error('captcha') <span style="color:red; font-size:12px; display:block; margin-bottom:10px;">{{ $message }}</span> @enderror
                <button type="submit" class="btn-primary" style="width: 100%; padding: 16px; border-radius: 12px; font-weight: 700;">
                    <span wire:loading.remove wire:target="sendMessage" data-translate="form_send">Send Message</span>
                    <span wire:loading wire:target="sendMessage" data-translate="form_sending">Sending...</span>
                </button>
            </form>
        </div>
    </div>
    @livewire('partials.contact')
    @livewire('partials.footer')
    @push('landScripts')
        <script src="{{ asset('assets/main.js') }}"></script>
    @endpush
</div>
