<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/contact.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <header class="contact-header">
        <h1 data-translate="contact_title">Get in Touch</h1>
        <p data-translate="contact_subtitle">Global support for local airspace security.</p>
    </header>

    <div class="contact-grid">
        <div class="contact-details">
            <h3 data-translate="contact_info_h3">Contact Information</h3>

            <div class="detail-item">
                <label data-translate="contact_office_label">Tartu HQ</label>
                <p>Rotermanni 8, 10111 Tartu, Estonia</p>
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
                    <input type="text" wire:model.defer="name" class="form-input" placeholder="Your full name">
                </div>

                <div class="form-group">
                    <label data-translate="form_email">Email</label>
                    <input type="email" wire:model.defer="email" class="form-input" placeholder="name@company.com">
                </div>

                <div class="form-group">
                    <label data-translate="form_message">Message</label>
                    <textarea wire:model.defer="message" class="form-input" rows="5" placeholder="How can we help you?"></textarea>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 16px; border-radius: 12px; font-weight: 700;">
                    <span data-translate="form_send">Send Message</span>
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
