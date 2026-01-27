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
                "name": "SkyGuardian Estonia"
              }
            }
            </script>
        @endpush
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <div class="badge">
                    🇪🇪 <span data-translate="hero_badge">Made in Estonia</span>
                </div>
                <h1 data-translate="hero_title">Advanced Sky Monitoring System</h1>
                <p data-translate="hero_subtitle">Complete drone monitoring, weather services, security, and aircraft tracking solution for the modern era.</p>
                <div class="hero-buttons">
                    <button onclick="openModal('demoModal')" class="btn-primary" data-translate="hero_btn_primary">Start Monitoring</button>
                    <a href="#about" class="btn-secondary" data-translate="hero_btn_secondary">Learn More</a>
                </div>
                <div class="stats">
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p data-translate="stat_monitoring">Monitoring</p>
                    </div>
                    <div class="stat-item">
                        <h3>99.9%</h3>
                        <p data-translate="stat_uptime">Uptime</p>
                    </div>
                    <div class="stat-item">
                        <h3>1000+</h3>
                        <p data-translate="stat_assets">Tracked Assets</p>
                    </div>
                </div>
            </div>
            <div class="hero-card">
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
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-title">
            <h2 data-translate="features_title">Powerful Features</h2>
            <p data-translate="features_subtitle">Everything you need to monitor, track, and secure your airspace</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3 data-translate="feature1_title">Drone Tracking</h3>
                <p data-translate="feature1_desc">Real-time GPS tracking and monitoring of all drone activities in your airspace.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">☁️</div>
                <h3 data-translate="feature2_title">Weather Data</h3>
                <p data-translate="feature2_desc">Live weather conditions, forecasts, and alerts for safe flight operations.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3 data-translate="feature3_title">Security System</h3>
                <p data-translate="feature3_desc">Advanced threat detection and automated security protocols for airspace protection.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✈️</div>
                <h3 data-translate="feature4_title">Aircraft Monitor</h3>
                <p data-translate="feature4_desc">Comprehensive tracking of all aircraft movements and flight patterns.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔔</div>
                <h3 data-translate="feature5_title">Real-time Alerts</h3>
                <p data-translate="feature5_desc">Instant notifications for unauthorized airspace intrusions and critical events.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 data-translate="feature6_title">Data Analytics</h3>
                <p data-translate="feature6_desc">Advanced analytics dashboard with detailed reports and insights for better decision making.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧠</div>
                <h3 data-translate="feature7_title">AI Analysis</h3>
                <p data-translate="feature7_desc">Machine learning algorithms detect patterns and potential threats automatically.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⏪</div>
                <h3 data-translate="feature8_title">Historical Playback</h3>
                <p data-translate="feature8_desc">Review past flight paths and incidents with detailed timeline replay controls.</p>
            </div>
        </div>
    </section>

    <section class="services" id="services">
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
    </section>

    <section class="about" id="about">
        <div class="about-content">
            <div class="about-text">
                <h2 data-translate="about_title">Built for the Future of Aviation</h2>
                <p data-translate="about_desc1">SkyGuardian System is an Estonian startup revolutionizing airspace management with cutting-edge technology. We provide comprehensive solutions for drone monitoring, weather services, security, and aircraft tracking.</p>
                <p data-translate="about_desc2">Our platform combines real-time data processing, advanced analytics, and automated security protocols to ensure safe and efficient airspace operations.</p>
                <div class="about-stats">
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
                </div>
            </div>
            <div class="about-box">
                <h3 data-translate="about_why_title">Why Choose SkyGuardian?</h3>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit1_title">Advanced Technology</h4>
                        <p data-translate="about_benefit1_desc">State-of-the-art monitoring systems with AI-powered analytics</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit2_title">Real-Time Data</h4>
                        <p data-translate="about_benefit2_desc">Instant updates and live tracking for immediate decision making</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit3_title">Compliance Ready</h4>
                        <p data-translate="about_benefit3_desc">Meets all EU and international aviation regulations</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">✓</div>
                    <div>
                        <h4 data-translate="about_benefit4_title">Expert Support</h4>
                        <p data-translate="about_benefit4_desc">24/7 dedicated support team ready to assist you</p>
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
