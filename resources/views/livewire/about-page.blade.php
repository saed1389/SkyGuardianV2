<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/index.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .about-hero { margin-top: 70px; padding: 120px 20px; background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center; color: white; text-align: center; }
            .about-hero h1 { font-size: 64px; font-weight: 800; margin-bottom: 20px; letter-spacing: -2px; }

            .story-section { padding: 100px 20px; max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
            .story-content h2 { font-size: 36px; margin-bottom: 20px; color: var(--black); }
            .story-content p { font-size: 18px; color: var(--gray-600); line-height: 1.8; margin-bottom: 20px; }

            .milestones { background: var(--gray-900); padding: 100px 20px; color: white; }
            .milestone-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; max-width: 1200px; margin: 0 auto; }
            .milestone-card { border-left: 2px solid var(--primary-blue); padding-left: 20px; }
            .milestone-card h3 { font-size: 40px; color: var(--primary-blue); margin-bottom: 10px; }
            .subtitle { font-size: 20px; opacity: 0.9; }
            .tech-visual { background: var(--gray-50); padding: 100px 20px; text-align: center; }
            .tech-icons { display: flex; justify-content: center; gap: 50px; flex-wrap: wrap; margin-top: 50px; opacity: 0.6; grayscale: 100%; }
        </style>
    @endpush

    <section class="about-hero">
        <h1 data-translate="about_hero_title">Securing the Global Sky</h1>
        <p class="subtitle" data-translate="about_hero_subtitle">Estonian engineering meets aerospace innovation.</p>
    </section>

    <section class="story-section">
        <div class="story-content">
            <h2 data-translate="about_story_title">Our Story</h2>
            <p data-translate="about_story_p1">Founded in Tartu in 2026, SkyGuardian was born from a simple observation: the world's radar systems weren't ready for the drone revolution.</p>
            <p data-translate="about_story_p2">We combined RF Signal Intelligence with Machine Learning to create a monitoring system that doesn't just see drones—it understands them.</p>
        </div>
        <div>
            <img src="{{ asset('assets/images/rsz_2about.jpg') }}" alt="">
        </div>
    </section>

    <section class="milestones">
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
    </section>
        @if($partners->count() > 0)
            <section class="tech-visual">
                <h2 data-translate="tech_title">Our Partners & Standards</h2>
                <div class="tech-icons">
                    @foreach($partners as $partner)
                        <img src="{{ asset($partner->image) }}" alt="{{ $partner->name }}" width="160">
                    @endforeach
                </div>
            </section>
        @endif

        @livewire('partials.contact')
        @livewire('partials.footer')
        @push('landScripts')
            <script src="{{ asset('assets/main.js') }}"></script>
        @endpush
</div>
