<div>
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <div class="logo" style="margin-bottom: 20px;">
                    <img src="{{ asset('user/assets/images/logo-light.png') }}" alt="" style="width: 200px">
                </div>
                <p style="color: var(--gray-300); font-size: 14px;" data-translate="footer_desc">Advanced airspace monitoring and management solutions.</p>
            </div>
            {{--<div class="footer-section">
                <h4 data-translate="footer_product">Product</h4>
                <ul>
                    <li><a href="#" data-translate="footer_features">Features</a></li>
                    <li><a href="#" data-translate="footer_pricing">Pricing</a></li>
                    <li><a href="#" data-translate="footer_security">Security</a></li>
                    <li><a href="#" data-translate="footer_updates">Updates</a></li>
                </ul>
            </div>--}}
            <div class="footer-section">
                <h4 data-translate="footer_company">Company</h4>
                <ul>
                    <li><a href="{{ route('about-page') }}" data-translate="footer_about">About</a></li>
                    <li><a href="{{ route('blog.index') }}" data-translate="footer_blog">Blog</a></li>
                    <li><a href="{{ route('careers-page') }}" data-translate="footer_careers">Careers</a></li>
                    <li><a href="{{ route('contact-page') }}" data-translate="footer_contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4 data-translate="footer_legal">Legal</h4>
                <ul>
                    <li><a href="{{ route('privacy-page') }}" data-translate="footer_privacy">Privacy Policy</a></li>
                    <li><a href="{{ route('term-page') }}" data-translate="footer_terms">Terms & Conditions</a></li>
                    <li><a href="{{ route('license-page') }}" data-translate="footer_license">License</a></li>
                    <li><a href="{{ route('compliance-page') }}" data-translate="footer_compliance">Compliance</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} SkyGuardian System. <span data-translate="footer_rights">All rights reserved.</span> <span data-translate="footer_made">Made with</span> ❤️ <span data-translate="footer_estonia">in Estonia</span> 🇪🇪</p>
        </div>
    </footer>

    <div id="modalBackdrop" class="modal-backdrop" onclick="closeAllModals()"></div>

    <div id="demoModal" class="modal">
        <button class="modal-close" onclick="closeAllModals()">×</button>
        <div class="modal-header">
            <h3 data-translate="modal_demo_title">Request a Demo</h3>
            <p data-translate="modal_demo_desc">See SkyGuardian in action. Fill out the form below.</p>
        </div>
        <form wire:submit.prevent="submitDemo">
            <div class="form-group">
                <label data-translate="form_name">Full Name</label>
                <input type="text" wire:model="name" class="form-input" required placeholder="John Doe">
            </div>
            <div class="form-group">
                <label data-translate="form_email">Email Address</label>
                <input type="email" wire:model="email" class="form-input" required placeholder="john@company.com">
            </div>
            <div class="form-group">
                <label data-translate="form_company">Company</label>
                <input type="text" wire:model="company" class="form-input" placeholder="Organization Name">
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;" data-translate="form_submit_demo">Schedule Demo</button>
        </form>
    </div>

    <div id="contactModal" class="modal">
        <button class="modal-close" onclick="closeAllModals()">×</button>
        <div class="modal-header">
            <h3 data-translate="modal_contact_title">Contact Sales</h3>
            <p data-translate="modal_contact_desc">Get a custom quote for your organization.</p>
        </div>
        <form wire:submit.prevent="submitContact">
            <div class="form-group">
                <label data-translate="form_name">Full Name</label>
                <input type="text" wire:model="name" class="form-input" required>
            </div>
            <div class="form-group">
                <label data-translate="form_email">Email Address</label>
                <input type="email" wire:model="email" class="form-input" required>
            </div>
            <div class="form-group">
                <label data-translate="form_message">Message</label>
                <textarea class="form-input" wire:model="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;" data-translate="form_submit_contact">Send Message</button>
        </form>
    </div>
</div>
