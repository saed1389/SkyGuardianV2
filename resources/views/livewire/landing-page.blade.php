<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <script type="application/ld+json">
            {
              "@@context": "https://schema.org",
          "@@type": "SoftwareApplication",
          "name": "SkyGuardian System",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "Cloud",
          "description": "Passive RF-based drone detection and classification system for critical infrastructure security.",
          "author": {
            "@@type": "Organization",
            "name": "SkyGuardian"
          }
        }
        </script>
    @endpush
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <h1>SkyGuardian</h1>
                <h2 data-translate="hero_subtitle_h2">Passive RF Drone Detection for Critical Infrastructure</h2>
                <p data-translate="hero_subtitle">Real-time detection and classification of unauthorized low-altitude drones at airports, borders, and energy facilities—without active radar emissions.</p>
                <div class="hero-buttons">
                    <button onclick="openModal('demoModal')" class="btn-primary" data-translate="hero_btn_primary">Request Technical Overview</button>
                    <a href="#how-it-works" class="btn-secondary" data-translate="hero_btn_secondary">How It Works</a>
                </div>
            </div>
        </div>
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

    <section class="how-it-works" id="how-it-works">
        <div class="section-title">
            <h2 data-translate="how_title">How Detection Works</h2>
            <p data-translate="how_subtitle">RF Signals → Edge AI Classification → Real-Time Threat Alerts</p>
        </div>
        <div class="detection-flow">
            <div class="detection-flow-row">
                <div class="detection-flow-row-div">
                    <div class="detection-icon">📡</div>
                </div>
                <div class="detection-flow-flex1">
                    <h3 data-translate="how_work_t_1">Step 1: RF Signal Capture</h3>
                    <p data-translate="how_work_d_1">Distributed sensor nodes passively monitor the 433–900 MHz RF spectrum. No active emissions. No radar signature. System remains invisible to drone operators.</p>
                </div>
            </div>

            <div class="detection-arrow-down">↓</div>

            <!-- STEP 2 -->
            <div class="detection-flow-row">
                <div class="detection-flow-flex1">
                    <h3 data-translate="how_work_t_2">Step 2: Edge AI Classification</h3>
                    <p data-translate="how_work_d_2">Machine learning models run directly on edge nodes. Real-time analysis of RF fingerprints. <strong>No cloud dependency.</strong> Latency < 2 seconds. System continues operating even during network outages.</p>
                </div>
                <div class="detection-flow-row-div">
                    <div class="detection-icon">🧠</div>
                </div>
            </div>

            <div class="detection-arrow-down">↓</div>

            <!-- STEP 3 -->
            <div class="detection-flow-row">
                <div class="detection-flow-row-div">
                    <div class="detection-icon">⚡</div>
                </div>
                <div class="detection-flow-flex1">
                    <h3 data-translate="how_work_t_3">Step 3: Real-Time Threat Alert</h3>
                    <p data-translate="how_work_d_3">Actionable intelligence delivered instantly to control systems. NATO-compliant SALUTE reports. Location data with confidence scoring. Enables immediate response.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-title">
            <h2 data-translate="features_title">Four Core Differentiators</h2>
            <p data-translate="features_subtitle">What makes SkyGuardian fundamentally different from traditional radar and detection systems.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🥷</div>
                <h3 data-translate="feature_t_1">Passive Detection</h3>
                <p><strong data-translate="feature_t_s_1">Zero RF emissions.</strong> <span data-translate="feature_d_1">Completely invisible to drone operators. Unlike active radar, our system cannot be detected or jammed.</span></p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3 data-translate="feature_t_2">Low-Cost Deployment</h3>
                <p><strong data-translate="feature_t_s_2">Fraction of traditional radar cost.</strong> <span data-translate="feature_d_2">Hardware nodes cost €250–€300. Deploy distributed networks for wide-area coverage without million-euro price tags.</span></p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔗</div>
                <h3 data-translate="feature_t_3">Distributed Mesh Network</h3>
                <p><strong data-translate="feature_t_s_3">Scalable from 3 nodes to 300+.</strong> <span data-translate="feature_d_3">to expand coverage. Decentralized architecture ensures no single point of failure. Works in dense urban and remote environments.</span> </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3 data-translate="feature_t_4">Edge AI Processing</h3>
                <p><strong data-translate="feature_t_s_4">On-device machine learning.</strong><span data-translate="feature_d_4">No cloud dependency. Sub-2-second latency. Operates during network outages. Performance improves over time with localized data refinement.</span> </p>
            </div>
        </div>
    </section>

    <section class="use-cases" id="services">
        <div class="section-title">
            <h2 data-translate="use_cases_title">Primary Application: Critical Infrastructure & Border Security</h2>
            <p data-translate="use_cases_description">Designed specifically for high-value assets vulnerable to low-altitude drone threats.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">✈️</div>
                <h3 data-translate="use_cases_opt_t_1">Airports</h3>
                <p data-translate="use_cases_opt_d_1">Real-time detection of unauthorized drones in approach corridors and runway perimeters.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛂</div>
                <h3 data-translate="use_cases_opt_t_2">Border Control</h3>
                <p data-translate="use_cases_opt_d_2">Wide-area coverage of international borders. Detects smuggling and reconnaissance drones.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3 data-translate="use_cases_opt_t_3">Energy Infrastructure</h3>
                <p data-translate="use_cases_opt_d_3">Power plants, substations, and transmission lines protected from aerial surveillance and attacks.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚢</div>
                <h3 data-translate="use_cases_opt_t_4">Ports & Maritime</h3>
                <p data-translate="use_cases_opt_d_4">Detection of drones over port facilities and coastal critical infrastructure.</p>
            </div>
        </div>
    </section>

    <section class="about" id="about">
        <div class="about-content">
            <div class="about-text">
                <h2 data-translate="about_title">Why Traditional Radar Fails</h2>
                <p><strong data-translate="about_problem">The Problem:</strong> <span data-translate="about_problem_d">90% of critical infrastructure lacks effective low-altitude drone detection. Traditional radar systems are expensive (€5–10M+), emit detectable signals, struggle with slow/small targets, and take months to deploy.</span></p>
                <p><strong data-translate="about_reality">The Reality:</strong> <span data-translate="about_reality_d">As commercial drone adoption accelerates, unauthorized drones represent a growing security threat. Infrastructure operators and border authorities need scalable, cost-efficient, real-time detection solutions—not expensive, static radar systems.</span></p>
            </div>
            <div class="about-box">
                <h3 data-translate="about_box_title">SkyGuardian vs. Traditional Systems</h3>
                <div class="comparison-table-responsive">
                    <div class="table-row table-header">
                        <div class="table-cell" data-translate="about_box_title_1">Feature</div>
                        <div class="table-cell" data-translate="about_box_title_2">Radar</div>
                        <div class="table-cell highlight" data-translate="about_box_title_3">SkyGuardian</div>
                    </div>
                    <div class="table-row">
                        <div class="table-cell"><strong data-translate="about_box_title_4">Signal Emission</strong></div>
                        <div class="table-cell" data-translate="about_box_title_5">Active (Detectable)</div>
                        <div class="table-cell highlight" data-translate="about_box_title_6">Passive (Invisible)</div>
                    </div>

                    <div class="table-row alt">
                        <div class="table-cell"><strong data-translate="about_box_title_7">Deployment Cost</strong></div>
                        <div class="table-cell">€5–10M+</div>
                        <div class="table-cell highlight">€10K–50K</div>
                    </div>

                    <div class="table-row">
                        <div class="table-cell"><strong data-translate="about_box_title_8">Low-Altitude Detection</strong></div>
                        <div class="table-cell" data-translate="about_box_title_9">Poor/Blind Spots</div>
                        <div class="table-cell highlight" data-translate="about_box_title_10">Effective</div>
                    </div>

                    <div class="table-row alt">
                        <div class="table-cell"><strong data-translate="about_box_title_11">Deployment Time</strong></div>
                        <div class="table-cell" data-translate="about_box_title_12">3–6 months</div>
                        <div class="table-cell highlight" data-translate="about_box_title_13">1–2 weeks</div>
                    </div>

                    <div class="table-row">
                        <div class="table-cell"><strong data-translate="about_box_title_14">Scalability</strong></div>
                        <div class="table-cell" data-translate="about_box_title_15">Fixed/Expensive</div>
                        <div class="table-cell highlight" data-translate="about_box_title_16">Distributed/Easy</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="latest-news">
        <div class="section-title">
            <h2 data-translate="blog_title">Security & RF Technology Insights</h2>
            <p data-translate="blog_subtitle">Latest updates on drone threats and critical infrastructure protection.</p>
        </div>
        <div class="news-grid">
            @foreach($recentPosts as $post)
                <a href="{{ route('blog.show', $post->slug_en) }}" class="news-card">
                    <img src="{{ $post->image }}" alt="Blog Image" class="news-img">
                    <div class="news-content">
                        <span class="news-cat lang-dynamic lang-en">{{ $post->category_en }}</span>
                        <span class="news-cat lang-dynamic lang-tr">
                        {{ !empty($post->category_tr) ? $post->category_tr : $post->category_en }}
                    </span>
                        <span class="news-cat lang-dynamic lang-ee">
                        {{ !empty($post->category_ee) ? $post->category_ee : $post->category_en }}
                    </span>
                        <h3 class="news-title lang-dynamic lang-en">{{ $post->title_en }}</h3>
                        <h3 class="news-title lang-dynamic lang-tr">
                            {{ !empty($post->title_tr) ? $post->title_tr : $post->title_en }}
                        </h3>
                        <h3 class="news-title lang-dynamic lang-ee">
                            {{ !empty($post->title_ee) ? $post->title_ee : $post->title_en }}
                        </h3>
                        <p class="news-excerpt lang-dynamic lang-en">
                            {{ Str::limit($post->excerpt_en, 100) }}
                        </p>
                        <p class="news-excerpt lang-dynamic lang-tr">
                            {{ Str::limit(!empty($post->excerpt_tr) ? $post->excerpt_tr : $post->excerpt_en, 100) }}
                        </p>
                        <p class="news-excerpt lang-dynamic lang-ee">
                            {{ Str::limit(!empty($post->excerpt_ee) ? $post->excerpt_ee : $post->excerpt_en, 100) }}
                        </p>
                        <div class="news-date">{{ $post->formatted_date }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    @livewire('partials.contact')
    @livewire('partials.footer')

    @push('landScripts')
        <script src="{{ asset('assets/main.js') }}"></script>
    @endpush
</div>
