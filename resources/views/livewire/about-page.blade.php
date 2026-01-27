<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/about.css') }}" rel="stylesheet" type="text/css" />
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
        <div class="story-image-container">
            <img src="{{ asset('assets/images/rsz_2about.jpg') }}" alt="SkyGuardian Monitoring">
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
                    <img src="{{ asset($partner->image) }}" alt="{{ $partner->name }}">
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
