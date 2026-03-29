<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/about.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <section class="about-hero">
        <h1 data-translate="about_hero_title">Securing the Global Sky</h1>
        <p class="subtitle" data-translate="about_hero_subtitle">Engineering meets aerospace innovation.</p>
    </section>

    <section class="story-section">
        <div class="story-content">
            <h2 data-translate="about_story_title">Our Story</h2>
            <p data-translate="about_story_p1">SkyGuardian was born from a simple observation: the world's radar systems weren't ready for the drone revolution.</p>
            <p data-translate="about_story_p2">We combined RF Signal Intelligence with Machine Learning to create a monitoring system that doesn't just see drones—it understands them.</p>
        </div>
        <div class="story-image-container">
            <img src="{{ asset('assets/images/rsz_2about.jpg') }}" alt="SkyGuardian Monitoring">
        </div>
    </section>

   {{-- <section class="milestones">
        <div class="milestone-grid">
            <div class="milestone-card">
                <h3>2026</h3>
                <p data-translate="milestone_1">SkyGuardian Founded in Tartu</p>
            </div>
            <div class="milestone-card">
                <h3>500k</h3>
                <p data-translate="milestone_2">Successful Threat Detections</p>
            </div>
            <div class="milestone-card">
                <h3>1</h3>
                <p data-translate="milestone_3">Countries Protected</p>
            </div>
            <div class="milestone-card">
                <h3>99.9%</h3>
                <p data-translate="milestone_4">Detection Accuracy</p>
            </div>
        </div>
    </section>--}}
        @livewire('partials.contact')
        <section class="team-section">
            <div class="team-container">
                <div class="team-header">
                    <h2 data-translate="team_title">Our Team</h2>
                    <p class="team-subtitle" data-translate="team_subtitle">Visionaries driving innovation in aerial defense</p>
                </div>

                <div class="team-grid">
                    <div class="team-card">
                        <div class="team-card-wrapper">
                            <div class="team-card-image">
                                <img src="{{ asset('assets/images/team/sait-ekmekcibasi.jpg') }}" alt="Sait Ekmekçibaşı">
                                <div class="team-card-overlay"></div>
                            </div>
                            <div class="team-card-content">
                                <h3 data-translate="team_member_1_name">Sait Ekmekçibaşı</h3>
                                <p class="team-role" data-translate="team_member_1_role">Co-Founder & CEO</p>
                            </div>
                        </div>
                    </div>

                    <div class="team-card">
                        <div class="team-card-wrapper">
                            <div class="team-card-image">
                                <img src="{{ asset('assets/images/team/serai-mubarek.jpg') }}" alt="Seray Mübarek">
                                <div class="team-card-overlay"></div>
                            </div>
                            <div class="team-card-content">
                                <h3 data-translate="team_member_2_name">Seray Mübarek</h3>
                                <p class="team-role" data-translate="team_member_2_role">CLO</p>
                            </div>
                        </div>
                    </div>

                    <div class="team-card">
                        <div class="team-card-wrapper">
                            <div class="team-card-image">
                                <img src="{{ asset('assets/images/team/baris-sirim.jpg') }}" alt="Barış Sırım">
                                <div class="team-card-overlay"></div>
                            </div>
                            <div class="team-card-content">
                                <h3 data-translate="team_member_3_name">Barış Sırım</h3>
                                <p class="team-role" data-translate="team_member_3_role">Co-Founder & Head of Marketing</p>
                            </div>
                        </div>
                    </div>

                    <div class="team-card">
                        <div class="team-card-wrapper">
                            <div class="team-card-image">
                                <img src="{{ asset('assets/images/team/elif-ekmekcibasi.jpg') }}" alt="Elif Ekmekçibaşı">
                                <div class="team-card-overlay"></div>
                            </div>
                            <div class="team-card-content">
                                <h3 data-translate="team_member_4_name">Elif Ekmekçibaşı</h3>
                                <p class="team-role" data-translate="team_member_4_role">Co-Founder & Head of QA And Operation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @if($partners->count() > 0)
        <section class="tech-visual">
            <h2 data-translate="tech_title">Our Partners & Standards</h2>
            <div class="tech-icons">
                @foreach($partners as $partner)
                    <img src="{{ asset($partner->image) }}" alt="{{ $partner->name }}">
                @endforeach
            </div>
        </section>
    @endif

    @livewire('partials.footer')

    @push('landScripts')
        <script src="{{ asset('assets/main.js') }}"></script>
    @endpush
</div>
