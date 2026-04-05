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
              "description": "Advanced RF-based Drone Detection and Classification System for critical airspace security.",
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
                <h2 data-translate="hero_subtitle_h2">Deep-Tech Drone Detection for Critical Infrastructure</h2>
                <p data-translate="hero_subtitle">A passive, AI-powered RF detection system protecting airports, borders, and energy facilities from unauthorized drones in real-time.</p>
                <div class="hero-buttons">
                    <button onclick="openModal('demoModal')" class="btn-primary" data-translate="hero_btn_primary">Request Demo</button>
                    <a href="#about" class="btn-secondary" data-translate="hero_btn_secondary">Explore the System</a>
                </div>

            </div>
            {{--<div class="hero-card">
                <div class="service-item">Learn More
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
    <section class="how-it-works" id="how-it-works" style="background-color: var(--gray-50); padding: 80px 0;">
        <div class="section-title">
            <h2 data-translate="how_title">How the System Operates</h2>
            <p data-translate="how_subtitle">AI is the core of our system. Here is how we detect threats from raw signals to real-time alerts.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📡</div>
                <h3 data-translate="step1_title">1. Passive Signal Collection</h3>
                <p data-translate="step1_desc">Distributed RTL-SDR sensors continuously and passively scan the 433–900 MHz RF spectrum without emitting any signals.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧠</div>
                <h3 data-translate="step2_title">2. Edge AI Classification</h3>
                <p data-translate="step2_desc">The core AI model runs directly on the edge nodes, instantly analyzing frequency patterns to classify drone signatures and filter out noise.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3 data-translate="step3_title">3. Real-Time Alert Generation</h3>
                <p data-translate="step3_desc">Once a threat is classified, the system immediately generates actionable data and NATO-compliant SALUTE reports for security teams.</p>
            </div>
        </div>
    </section>
    <section class="features" id="features">
        <div class="section-title">
            <h2 data-translate="features_title">System Architecture & Advantages</h2>
            <p data-translate="features_subtitle">Built for real-world deployment with decentralized processing and low-cost hardware.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🥷</div>
                <h3 data-translate="feature1_title">Passive & Undetectable</h3>
                <p data-translate="feature1_desc">Operates with zero RF emissions, making the defense system completely invisible to drone operators.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📉</div>
                <h3 data-translate="feature3_title">Cost-Effective Deployment</h3>
                <p data-translate="feature3_desc">Replaces multi-million euro traditional radars with highly affordable, distributed hardware nodes.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3 data-translate="feature5_title">Low-Altitude Threat Detection</h3>
                <p data-translate="feature5_desc">Effectively detects small drones flying under traditional radar coverage near borders and airports.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔗</div>
                <h3 data-translate="feature7_title">Distributed Mesh Network</h3>
                <p data-translate="feature7_desc">Easily scalable multi-node architecture for wide-area border and facility coverage.</p>
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
                <h2 data-translate="about_title">Bridging the Gap in Airspace Security</h2>
                <p data-translate="about_desc1">Traditional radar systems are costly and frequently fail to detect small, low-altitude drones near sensitive infrastructure.</p>
                <p data-translate="about_desc2">Current Status: Our MVP is fully developed and successfully tested. We are currently in active pilot discussions with Estonian critical infrastructure operators and public institutions to deploy our edge-AI RF systems in real-world scenarios.</p>
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
                <h3 data-translate="about_why_title">Key Differentiators</h3>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit1_title">AI at the Core, Not an Add-on</h4>
                        <p data-translate="about_benefit1_desc">Unlike basic monitoring tools, our system relies on advanced neural networks to classify raw RF data directly on the hardware.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit2_title">Decentralized & Resilient</h4>
                        <p data-translate="about_benefit2_desc">Edge computing ensures the system continues to detect and classify threats even during network outages.</p>
                    </div>
                </div>
               {{-- <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit3_title">Edge AI Processing</h4>
                        <p data-translate="about_benefit3_desc">Real-time detection without constant cloud dependency.</p>
                    </div>
                </div>--}}
            </div>
        </div>
    </section>
    <section class="latest-news">
        <div class="section-title">
            <h2 data-translate="blog_title">Security & Deep-Tech Insights</h2>
            <p data-translate="blog_subtitle">Latest updates on drone threats, RF technology, and infrastructure security protocols.</p>
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
