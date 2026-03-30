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
              "description": "Advanced Sky Monitoring System for drone tracking and airspace security.",
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
                {{--<div class="badge">
                    🇪🇪 <span data-translate="hero_badge">Made in Estonia</span>
                </div>--}}
                <h1>SkyGuardian</h1>
                <h2 data-translate="hero_subtitle_h2">Passive RF Drone Detection for Critical Infrastructure</h2>
                <p data-translate="hero_subtitle">Low-cost, AI-powered real-time detection system protecting airports, borders, ports, and energy facilities from unauthorized drones.</p>
                <div class="hero-buttons">
                    <button onclick="openModal('demoModal')" class="btn-primary" data-translate="hero_btn_primary">Start Monitoring</button>
                    <a href="#about" class="btn-secondary" data-translate="hero_btn_secondary">Learn More</a>
                </div>

            </div>
            {{--<div class="hero-card">
                <div class="service-item">
                    <div class="service-icon">✨</div>
                    <div>
                        <h4 data-translate="hero_service1_title">Drone Monitoring</h4>
                        <p data-translate="hero_service1_desc">Real-time tracking</p>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-icon">☁️</div>
                    <div>
                        <h4 data-translate="hero_service2_title">Weather Services</h4>
                        <p data-translate="hero_service2_desc">Live updates</p>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-icon">🛡️</div>
                    <div>
                        <h4 data-translate="hero_service3_title">Security</h4>
                        <p data-translate="hero_service3_desc">Advanced protection</p>
                    </div>
                </div>
            </div>--}}
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-title">
            <h2 data-translate="features_title">Core Capabilities</h2>
            <p data-translate="features_subtitle">Passive RF-based drone detection built for real-world security needs</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📡</div>
                <h3 data-translate="feature1_title">Passive RF Spectrum Sensing</h3>
                <p data-translate="feature1_desc">433–900 MHz frequency scanning using low-cost RTL-SDR sensors.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧠</div>
                <h3 data-translate="feature3_title">Edge AI Classification & Fingerprinting</h3>
                <p data-translate="feature3_desc">Real-time anomaly detection and threat scoring on the edge.</p>
            </div>
       {{--     <div class="feature-card">
                <div class="feature-icon">✈️</div>
                <h3 data-translate="feature4_title">Aircraft Monitor</h3>
                <p data-translate="feature4_desc">Comprehensive tracking of all aircraft movements and flight patterns.</p>
            </div>--}}
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3 data-translate="feature5_title">Low-Altitude Threat Detection</h3>
                <p data-translate="feature5_desc">Instant alerts for unauthorized low-flying drones.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📨</div>
                <h3 data-translate="feature6_title">Real-time Alerting & NATO SALUTE Reports</h3>
                <p data-translate="feature6_desc">Immediate notifications with location and confidence score.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔗</div>
                <h3 data-translate="feature7_title">Mesh Sensor Network Architecture</h3>
                <p data-translate="feature7_desc">Scalable multi-node deployment for large areas.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⏪</div>
                <h3 data-translate="feature8_title">Offline / Comms-Degraded Operation</h3>
                <p data-translate="feature8_desc">Continues to function locally even when internet or power is unavailable.</p>
            </div>
        </div>
    </section>

 {{--   <section class="services" id="services">
        <div class="section-title">
            <h2 data-translate="services_title">Our Services</h2>
            <p data-translate="services_subtitle">Comprehensive solutions for all your aviation monitoring needs</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-card-icon">🗺️</div>
                <h3 data-translate="service1_title">Airspace Management</h3>
                <p data-translate="service1_desc">Complete control and monitoring of your designated airspace with real-time data.</p>
                <ul>
                    <li data-translate="service1_feature1">Real-time tracking</li>
                    <li data-translate="service1_feature2">Automated alerts</li>
                    <li data-translate="service1_feature3">Compliance reporting</li>
                </ul>
            </div>
            <div class="service-card">
                <div class="service-card-icon">⚡</div>
                <h3 data-translate="service2_title">Emergency Response</h3>
                <p data-translate="service2_desc">Instant notification and response system for critical situations and threats.</p>
                <ul>
                    <li data-translate="service2_feature1">24/7 monitoring</li>
                    <li data-translate="service2_feature2">Rapid deployment</li>
                    <li data-translate="service2_feature3">Incident logs</li>
                </ul>
            </div>
            <div class="service-card">
                <div class="service-card-icon">📊</div>
                <h3 data-translate="service3_title">Analytics & Insights</h3>
                <p data-translate="service3_desc">Detailed analytics and reporting for data-driven decision making.</p>
                <ul>
                    <li data-translate="service3_feature1">Traffic patterns</li>
                    <li data-translate="service3_feature2">Custom reports</li>
                    <li data-translate="service3_feature3">Predictive analysis</li>
                </ul>
            </div>
        </div>
    </section>--}}

    <section class="about" id="about">
        <div class="about-content">
            <div class="about-text">
                <h2 data-translate="about_title">SkyGuardian was founded to solve a critical gap</h2>
                <p data-translate="about_desc1">Traditional radar systems cannot effectively detect small, low-altitude drones near sensitive infrastructure.</p>
                <p data-translate="about_desc2">We developed a passive RF-based, edge-AI system that requires no active emissions and works reliably even in challenging environments.</p>
                {{--<div class="about-stats">
                    <div class="about-stat">
                        <h3>500+</h3>
                        <p data-translate="about_stat1">Active Clients</p>
                    </div>
                    <div class="about-stat">
                        <h3>50K+</h3>
                        <p data-translate="about_stat2">Flights Tracked</p>
                    </div>
                    <div class="about-stat">
                        <h3>15+</h3>
                        <p data-translate="about_stat3">Countries</p>
                    </div>
                    <div class="about-stat">
                        <h3>100%</h3>
                        <p data-translate="about_stat4">Secure</p>
                    </div>
                </div>--}}
            </div>
            <div class="about-box">
                <h3 data-translate="about_why_title">Why SkyGuardian?</h3>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit1_title">Low-Cost & Scalable</h4>
                        <p data-translate="about_benefit1_desc">Affordable wide-area coverage using distributed low-cost sensors.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit2_title">Passive & Stealth</h4>
                        <p data-translate="about_benefit2_desc">No active emissions — undetectable by the drone operator.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit3_title">Edge AI Processing</h4>
                        <p data-translate="about_benefit3_desc">Real-time detection without constant cloud dependency.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

            <section class="latest-news">
                <div class="section-title">
                    <h2 data-translate="blog_title">Aviation Insights</h2>
                    <p data-translate="blog_subtitle">Latest news, technology updates, and security protocols.</p>
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
