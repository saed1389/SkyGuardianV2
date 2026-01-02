<div class="report-section mb-4">
    <h6 class="text-muted mb-3 border-bottom pb-2 text-white">DAILY SUMMARY STATISTICS</h6>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Date</th>
                <th>Analyses</th>
                <th>Avg Aircraft</th>
                <th>Avg Military</th>
                <th>Avg Anomaly</th>
                <th>Max Aircraft</th>
                <th>High Risk</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['daily_summaries'] ?? [] as $summary)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($summary->date)->format('M d, Y') }}</td>
                    <td>{{ $summary->analysis_count }}</td>
                    <td>{{ round($summary->avg_aircraft, 1) }}</td>
                    <td>{{ round($summary->avg_military, 1) }}</td>
                    <td>{{ round($summary->avg_anomaly, 1) }}</td>
                    <td>{{ $summary->max_aircraft }}</td>
                    <td>{{ $summary->high_risk_days ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="report-section mb-4">
    <h6 class="text-muted mb-3 border-bottom pb-2">TOP AIRCRAFT BY ACTIVITY</h6>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Hex</th>
                <th>Callsign</th>
                <th>Type</th>
                <th>Country</th>
                <th>Military</th>
                <th>Threat Level</th>
                <th>Positions</th>
                <th>Last Seen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['top_aircraft'] ?? [] as $aircraft)
                <tr>
                    <td class="font-monospace">{{ $aircraft->hex }}</td>
                    <td>{{ $aircraft->callsign ?? 'N/A' }}</td>
                    <td>{{ $aircraft->type ?? 'Unknown' }}</td>
                    <td>{{ $aircraft->country ?? 'Unknown' }}</td>
                    <td>{{ $aircraft->is_military ? 'Yes' : 'No' }}</td>
                    <td>{{ $aircraft->threat_level }}</td>
                    <td>{{ $aircraft->position_count }}</td>
                    <td>{{ \Carbon\Carbon::parse($aircraft->last_seen)->format('M d, H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
