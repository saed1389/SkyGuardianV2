<div class="report-section mb-4">
    <h6 class="text-muted mb-3 border-bottom pb-2 text-white">AI THREAT ALERTS</h6>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Time</th>
                <th>Trigger Level</th>
                <th>Threat Level</th>
                <th>Confidence</th>
                <th>AI Confidence</th>
                <th>Primary Concern</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['ai_alerts'] ?? [] as $alert)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($alert->ai_timestamp)->format('M d, H:i') }}</td>
                    <td><span class="badge bg-{{ $alert->trigger_level === 'HIGH' ? 'danger' : 'warning' }}">{{ $alert->trigger_level }}</span></td>
                    <td><span class="badge bg-{{ $alert->threat_level === 'HIGH' ? 'danger' : 'warning' }}">{{ $alert->threat_level }}</span></td>
                    <td>{{ $alert->confidence }}</td>
                    <td>{{ round($alert->ai_confidence_score * 100) }}%</td>
                    <td>{{ Str::limit($alert->primary_concern, 50) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
