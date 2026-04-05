<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/about.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <section class="about-hero">
        <h1>SkyGuardian</h1>
        <h2 data-translate="about_hero_title">Pioneering Passive Airspace Security</h2>
        <p class="subtitle" data-translate="about_hero_subtitle">Developing SkyGuardian: The low-cost, AI-powered real-time protection system for critical infrastructure.</p>
    </section>

    <section class="story-section">
        <div class="story-content">
            <h2 data-translate="about_story_title">Our Mission & Vision</h2>
            <p data-translate="about_story_p1">Our mission is to close the critical vulnerability gap in lower airspace security. Traditional radar systems are prohibitively expensive and frequently fail to detect small, low-altitude drones near sensitive infrastructure due to ground clutter.</p>
            <p data-translate="about_story_p2">To solve this, we developed SkyGuardian: a passive RF-based, edge-AI system. It requires no active radar emissions, making it undetectable by drone operators, and works reliably even in challenging weather environments.</p>
            <p data-translate="about_story_p3" style="margin-top: 15px; padding-left: 15px; border-left: 3px solid var(--primary-color);">Current Status: Our Minimum Viable Product (MVP) is fully operational. We are currently in active pilot discussions with Estonian critical infrastructure operators and defense entities to deploy our decentralized mesh networks in real-world scenarios.</p>
        </div>
        <div class="story-image-container">
            <img src="{{ asset('assets/images/rsz_2about.jpg') }}" alt="SkyGuardian Monitoring">
        </div>
    </section>
        <section class="milestones" style="background-color: var(--gray-50); padding: 60px 0;">
            <div class="section-title text-center" style="margin-bottom: 40px;">
                <h2 data-translate="principles_title">Our Engineering Principles</h2>
            </div>
            <div class="milestone-grid">
                <div class="milestone-card">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🧠</div>
                    <h3 data-translate="principle_1_title">Edge-First AI</h3>
                    <p data-translate="principle_1_desc" style="font-size: 0.9rem; color: var(--gray-600);">Threat classification happens directly on the hardware node, ensuring zero latency and no dependency on cloud connectivity.</p>
                </div>
                <div class="milestone-card">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🥷</div>
                    <h3 data-translate="principle_2_title">Zero Emission</h3>
                    <p data-translate="principle_2_desc" style="font-size: 0.9rem; color: var(--gray-600);">100% passive RF listening. The system cannot be jammed or detected by the targets it is monitoring.</p>
                </div>
                <div class="milestone-card">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🌐</div>
                    <h3 data-translate="principle_3_title">Mesh Scalability</h3>
                    <p data-translate="principle_3_desc" style="font-size: 0.9rem; color: var(--gray-600);">Built to scale from a single airport perimeter to hundreds of kilometers of national borders using low-cost sensor nodes.</p>
                </div>
            </div>
        </section>
        @livewire('partials.contact')
        <section class="team-section">
            <div class="team-container">
                <div class="team-header">
                    <h2 data-translate="team_title">Our Team</h2>
                    <p class="team-subtitle" data-translate="team_subtitle">The engineering and operational force behind SkyGuardian</p>
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
