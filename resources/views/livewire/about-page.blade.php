<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/about.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <section class="about-hero">
        <h1>SkyGuardian</h1>
        <h2 data-translate="about_page_title">Passive RF Drone Detection for Critical Infrastructure</h2>
        <p class="subtitle" data-translate="about_page_subtitle">An AI-powered, edge-based detection system protecting airports, borders, and energy facilities from low-altitude drone threats in real-time.</p>
    </section>

    <section class="credibility">
        <div class="section-title">
            <h2 data-translate="credibility_title">Proven Capability</h2>
            <p data-translate="credibility_subtitle">MVP complete. Tested in real RF environments. Pilot discussions active with Estonian critical infrastructure operators.</p>
        </div>
        <div class="credibility-grid">
            <div class="credibility-item">
                <div class="check-mark">✓</div>
                <h4 data-translate="credibility_t_1">MVP Operational</h4>
                <p data-translate="credibility_d_1">Functional hardware and software complete. Ready for deployment.</p>
            </div>
            <div class="credibility-item">
                <div class="check-mark">✓</div>
                <h4 data-translate="credibility_t_2">Real-World Validation</h4>
                <p data-translate="credibility_d_2">Tested in RF environments with controlled drone scenarios.</p>
            </div>
            <div class="credibility-item">
                <div class="check-mark">✓</div>
                <h4 data-translate="credibility_t_3">Active Pilot Discussions</h4>
                <p data-translate="credibility_d_3">In discussion with Tallinn Airport and Estonian Border Guard for pilot deployments.</p>
            </div>
        </div>
    </section>

    <section class="story-section">
        <div class="story-content">
            <h2 data-translate="about_story_title">The Problem We Solve</h2>
            <p><strong data-translate="the_gap">The Gap:</strong> <span data-translate="the_gap_description">90% of critical infrastructure lacks effective low-altitude drone detection. Traditional radar systems fail this mission: they're prohibitively expensive (€5–10M+), emit detectable signals, struggle with small slow targets, and require months to deploy.</span></p>
            <p><strong data-translate="the_solution">The Solution:</strong> <span data-translate="the_solution_description">SkyGuardian detects unauthorized drones using passive RF monitoring combined with edge-based AI. The system operates without active emissions, making it invisible to drone operators. It detects, classifies, and localizes threats in under 2 seconds with zero cloud dependency.</span></p>
            <p class="story-content-line"><strong data-translate="our_approach">Our Approach:</strong> <span data-translate="our_approach_description">We replace expensive, monolithic radar with a distributed, scalable mesh network of low-cost sensors (€250–300/node). Deploy in 1–2 weeks instead of 3–6 months. Cost: €10K–50K vs. €5–10M.</span></p>
        </div>
        <div class="story-image-container">
            <img src="{{ asset('assets/images/rsz_2about.jpg') }}" alt="SkyGuardian Technology">
        </div>
    </section>

    <section class="milestones">
        <div class="section-title text-center">
            <h2 data-translate="principles_title">Core Technical Advantages</h2>
            <p data-translate="principles_description">How SkyGuardian outperforms traditional detection methods</p>
        </div>
        <div class="milestone-grid">
            <div class="milestone-card">
                <div class="milestone-icon">🧠</div>
                <h3 data-translate="principle_1_title">Edge-First AI</h3>
                <p data-translate="principle_1_desc">RF signal classification runs directly on sensor hardware. Sub-2-second latency. Zero cloud dependency. Works during network outages.</p>
            </div>
            <div class="milestone-card">
                <div class="milestone-icon">🥷</div>
                <h3 data-translate="principle_2_title">Passive Detection</h3>
                <p data-translate="principle_2_desc">Zero active RF emissions. Completely invisible to drone operators. Cannot be jammed or counter-detected. Undetectable advantage.</p>
            </div>
            <div class="milestone-card">
                <div class="milestone-icon">🌐</div>
                <h3 data-translate="principle_3_title">Distributed Mesh</h3>
                <p data-translate="principle_3_desc">Scales from 3 nodes to 300+. Deploy at any site. Border perimeters, airport approaches, energy infrastructure. Decentralized, fault-tolerant.</p>
            </div>
            <div class="milestone-card">
                <div class="milestone-icon">💰</div>
                <h3 data-translate="principle_4_title">Low-Cost Deployment</h3>
                <p data-translate="principle_4_desc">€250–300 per node. €10K–50K per site. Traditional radar: €5–10M+. 100–1000x cost advantage.</p>
            </div>
            <div class="milestone-card">
                <div class="milestone-icon">⚡</div>
                <h3 data-translate="principle_5_title">Fast Deployment</h3>
                <p data-translate="principle_5_desc">Operational in 1–2 weeks. Radar systems require 3–6 months. Critical for time-sensitive security needs.</p>
            </div>
            <div class="milestone-card">
                <div class="milestone-icon">📊</div>
                <h3 data-translate="principle_6_title">Continuous Learning</h3>
                <p data-translate="principle_6_desc">ML models improve with localized data. 500+ RF signatures in training set. Performance enhances over time.</p>
            </div>
        </div>
    </section>

    <section class="deep-tech">
        <div class="deep-tech-row">
            <div class="section-title text-center">
                <h2 data-translate="deep_tech_title">Deep Technical Specifications</h2>
                <p data-translate="deep_tech_description">Concrete performance metrics and capabilities</p>
            </div>
            <div class="deep-tech-grid">
                <div class="deep-tech-card">
                    <h3 data-translate="deep_tech_opt_t_1">RF Signature Database</h3>
                    <p>500+</p>
                    <h6 data-translate="deep_tech_h6_1">Drone RF profiles trained and validated</h6>
                </div>
                <div class="deep-tech-card">
                    <h3 data-translate="deep_tech_opt_t_2">Detection Latency</h3>
                    <p data-translate="deep_tech_opt_p_2">< 2 sec</p>
                    <h6 data-translate="deep_tech_opt_h6_2">Signal capture to threat alert</h6>
                </div>
                <div class="deep-tech-card">
                    <h3 data-translate="deep_tech_opt_t_3">Edge AI Inference</h3>
                    <p>< 50ms</p>
                    <h6 data-translate="deep_tech_opt_h6_3">Per-frame classification time</h6>
                </div>
                <div class="deep-tech-card">
                    <h3 data-translate="deep_tech_opt_t_4">RF Coverage</h3>
                    <p>433–900 MHz</p>
                    <h6 data-translate="deep_tech_opt_h6_4">Continuous passive scanning</h6>
                </div>
                <div class="deep-tech-card">
                    <h3 data-translate="deep_tech_opt_t_5">Mesh Architecture</h3>
                    <p data-translate="deep_tech_opt_p_5">3 to 300+</p>
                    <h6 data-translate="deep_tech_opt_h6_5">Scalable node deployment</h6>
                </div>
                <div class="deep-tech-card">
                    <h3 data-translate="deep_tech_opt_t_6">Hardware Cost</h3>
                    <p>€250–300</p>
                    <h6 data-translate="deep_tech_opt_h6_6">Per sensor node</h6>
                </div>
            </div>
        </div>
    </section>

    <section class="business-model">
        <div class="deep-tech-row">
            <div class="section-title text-center">
                <h2 data-translate="business_model_title">Business Model</h2>
                <p data-translate="business_model_description">Hardware deployment + recurring software subscription</p>
            </div>
            <div class="business-model-grid">
                <div class="business-model-card">
                    <h3 data-translate="business_model_opt_t_1">Node Hardware</h3>
                    <div>€250–€300</div>
                    <p data-translate="business_model_opt_p_1">Per sensor unit. Includes RTL-SDR hardware, processing unit, and installation.</p>
                </div>
                <div class="business-model-card">
                    <h3 data-translate="business_model_opt_t_2">Annual License</h3>
                    <div>€3,000–€8,000</div>
                    <p data-translate="business_model_opt_p_2">Per deployment site. Includes software updates, AI model improvements, and support.</p>
                </div>
                <div class="business-model-card">
                    <h3 data-translate="business_model_opt_t_3">Payback Period</h3>
                    <div data-translate="business_model_opt_d_3">6–12 months</div>
                    <p data-translate="business_model_opt_p_3">Typical installation. Gross margins on software reach 60%+ after Year 1.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM SECTION -->
    @livewire('partials.contact')
    <section class="team-section">
        <div class="team-container">
            <div class="team-header">
                <h2 data-translate="team_title">Our Team</h2>
                <p class="team-subtitle" data-translate="team_subtitle">Deep-tech founders with signal processing, software, operations, and legal expertise</p>
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
                            <p class="team-role" data-translate="team_member_1_role">Co-Founder & CTO</p>
                            <p class="team-description" data-translate="team_member_2_description">Signal processing, machine learning, hardware architecture</p>
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
                            <p class="team-role" data-translate="team_member_2_role">Chief Legal Officer</p>
                            <p class="team-description" data-translate="team_member_2_description">Regulatory compliance, EU cybersecurity framework, partnerships</p>
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
                            <p class="team-description" data-translate="team_member_3_description">Strategic partnerships, go-to-market, customer relations</p>
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
                            <p class="team-role" data-translate="team_member_4_role">Co-Founder & Head of Operations</p>
                            <p class="team-description" data-translate="team_member_4_description">Hardware integration, QA, deployment, pilot management</p>
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
