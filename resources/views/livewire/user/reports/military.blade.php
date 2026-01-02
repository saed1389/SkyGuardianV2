<div class="report-section mb-4">
    <h6 class="text-muted mb-3 border-bottom pb-2 text-white">MILITARY AIRCRAFT BY COUNTRY</h6>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Country</th>
                <th>Total Aircraft</th>
                <th>Drones</th>
                <th>NATO</th>
                <th>Avg Threat Level</th>
                <th>Max Threat Level</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['countries'] ?? [] as $country)
                <tr>
                    <td>{{ $country->country }}</td>
                    <td>{{ $country->total_aircraft }}</td>
                    <td>{{ $country->drones }}</td>
                    <td>{{ $country->nato }}</td>
                    <td>{{ round($country->avg_threat_level, 1) }}</td>
                    <td>{{ $country->max_threat_level }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
