<div class="report-section mb-4">
    <h6 class="text-muted mb-3 border-bottom pb-2 text-white">REPORT SECTIONS OVERVIEW</h6>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Daily Activity</h6>
                    <ul class="mb-0">
                        <li>Total Days: {{ $data['sections']['daily_activity']['stats']['total_days'] ?? 0 }}</li>
                        <li>Total Analyses: {{ $data['sections']['daily_activity']['stats']['total_analyses'] ?? 0 }}</li>
                        <li>Avg Daily Aircraft: {{ $data['sections']['daily_activity']['stats']['avg_daily_aircraft'] ?? 0 }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Military Activity</h6>
                    <ul class="mb-0">
                        <li>Total Military Aircraft: {{ $data['sections']['military_activity']['stats']['total_military_aircraft'] ?? 0 }}</li>
                        <li>Total Countries: {{ $data['sections']['military_activity']['stats']['total_countries'] ?? 0 }}</li>
                        <li>Avg Threat Level: {{ $data['sections']['military_activity']['stats']['avg_threat_level'] ?? 0 }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
