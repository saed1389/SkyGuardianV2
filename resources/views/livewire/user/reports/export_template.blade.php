<div class="report-content">
    @if($activeReportType === 'daily' && isset($reportData['daily_summaries']))
        <h4>1. Daily Activity Summary</h4>
        <table class="table table-bordered table-sm">
            <thead>
            <tr style="background: #f8f9fa;">
                <th>Date</th>
                <th>Total Scans</th>
                <th>Avg Aircraft</th>
                <th>Max Risk</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reportData['daily_summaries'] as $day)
                <tr>
                    <td>{{ $day->date }}</td>
                    <td>{{ $day->count }}</td>
                    <td>{{ number_format($day->avg_ac, 1) }}</td>
                    <td>{{ $day->max_risk }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if(isset($reportData['top_aircraft']) && count($reportData['top_aircraft']) > 0)
            <h4 class="mt-4">2. Top High-Interest Aircraft</h4>
            <table class="table table-bordered table-sm">
                <thead>
                <tr style="background: #f8f9fa;">
                    <th>Hex</th>
                    <th>Callsign</th>
                    <th>Country</th>
                    <th>Threat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reportData['top_aircraft'] as $ac)
                    <tr>
                        <td>{{ $ac->hex }}</td>
                        <td>{{ $ac->callsign ?? 'N/A' }}</td>
                        <td>{{ $ac->country }}</td>
                        <td>{{ $ac->threat_level }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    @elseif($activeReportType === 'military' && isset($reportData['countries']))
        <h4>1. Military Assets by Country</h4>
        <table class="table table-striped">
            @foreach($reportData['countries'] as $c)
                <tr>
                    <td width="30%"><strong>{{ $c->country }}</strong></td>
                    <td>{{ $c->count }} Total Assets</td>
                    <td>{{ $c->drones }} Drones identified</td>
                </tr>
            @endforeach
        </table>

    @elseif($activeReportType === 'threat' && isset($reportData['ai_alerts']))
        <h4>1. AI Threat Detection Log</h4>
        @foreach($reportData['ai_alerts'] as $alert)
            <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <strong>{{ $alert->ai_timestamp }}</strong> <span style="color:red;">{{ $alert->situation }}</span>
            </div>
        @endforeach

    @elseif($activeReportType === 'aircraft' && isset($reportData['top_types']))
        <h4>1. Aircraft Type Distribution</h4>
        <table class="table table-bordered">
            @foreach($reportData['top_types'] as $type)
                <tr>
                    <td>{{ $type->type ?? 'Unknown' }}</td>
                    <td>{{ $type->count }} observed</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
