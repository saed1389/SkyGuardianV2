<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/careers.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('landScripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onCareerCaptcha(token) {
                @this.set('captcha', token);
            }

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('reset-career-captcha', () => {
                    try { grecaptcha.reset(); } catch(e) {}
                });
            });
        </script>
    @endpush

    @if (session()->has('message'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             wire:key="career-alert-{{ now()->timestamp }}"
             style="background: #d1fae5; color: #065f46; padding: 15px; padding-right: 40px; text-align: center; font-weight: 600; position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 3000; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 90%; max-width: 400px;">

            {{ session('message') }}

            <button @click="show = false"
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 20px; cursor: pointer; color: #065f46; line-height: 1;">
                &times;
            </button>
        </div>
    @endif

    <div class="careers-container">
        <div class="careers-visual">
            <h1 data-translate="career_h1">Join the Mission</h1>
            <p data-translate="career_p">We are always looking for RF engineers, AI specialists, and visionaries. Send us your CV, and let's build the future of airspace together.</p>

            <ul class="benefit-list">
                <li data-translate="benefit_1">Competitive salary + Equity options</li>
                <li data-translate="benefit_2">Relocation support to Tallinn</li>
                <li data-translate="benefit_3">Flexible remote work policy</li>
                <li data-translate="benefit_4">Modern tech stack & hardware</li>
            </ul>
        </div>

        <div class="careers-form">
            <form wire:submit.prevent="submitApplication">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label data-translate="form_name" style="display:block; margin-bottom:8px; font-weight:600;">Full Name</label>
                    <input type="text" wire:model="name" class="form-input" required placeholder="Jane Doe">
                    @error('name') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label data-translate="form_email" style="display:block; margin-bottom:8px; font-weight:600;">Email Address</label>
                    <input type="email" wire:model="email" class="form-input" required placeholder="jane@example.com">
                    @error('email') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label data-translate="form_position" style="display:block; margin-bottom:8px; font-weight:600;">Desired Position</label>
                    <input type="text" wire:model="position" class="form-input" placeholder="e.g. AI Engineer" required>
                    @error('position') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label data-translate="form_cv" style="display:block; margin-bottom:8px; font-weight:600;">Upload CV (PDF)</label>

                    <div class="file-upload" onclick="document.getElementById('cv_file').click()">
                        @if($cv)
                            <span style="color: var(--primary-blue); font-weight: 600;">✓ File Selected: {{ $cv->getClientOriginalName() }}</span>
                        @else
                            <span data-translate="upload_text">Tap to browse or drop your CV here</span>
                        @endif
                        <input type="file" id="cv_file" accept="application/pdf" wire:model="cv" style="display:none">
                    </div>

                    @error('cv') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="cv" style="font-size: 12px; color: var(--primary-blue); margin-top: 5px;">Uploading...</div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;" wire:ignore>
                    <div class="g-recaptcha"
                         data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"
                         data-callback="onCareerCaptcha"></div>
                </div>
                @error('captcha') <span style="color:red; font-size:12px; display:block; margin-bottom:10px;">{{ $message }}</span> @enderror

                <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; border-radius: 8px; font-weight: 700;">
                    <span wire:loading.remove wire:target="submitApplication" data-translate="form_apply">Send Application</span>
                    <span wire:loading wire:target="submitApplication" data-translate="uploading">Sending...</span>
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
