<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SkyGuardian AI Threat Analysis Report</title>
    <style>
        @page { margin: 20px; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0d6efd;
            margin: 0 0 5px 0;
            font-size: 22px;
        }
        .header .subtitle {
            color: #666;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .metadata {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 10px;
            color: #666;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 25px;
        }
        .stat-card {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
        }
        .stat-card .label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9px;
        }
        .table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            color: #495057;
        }
        .table td {
            border: 1px solid #dee2e6;
            padding: 6px;
            vertical-align: top;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 3px;
        }
        .badge-high { background-color: #dc3545; color: white; }
        .badge-medium { background-color: #ffc107; color: black; }
        .badge-low { background-color: #28a745; color: white; }
        .badge-info { background-color: #0dcaf0; color: black; }
        .progress {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin: 3px 0;
        }
        .progress-bar {
            height: 100%;
            background-color: #0d6efd;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        .page-break { page-break-after: always; }
        .chart-container {
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #495057;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>SkyGuardian AI Threat Analysis Report</h1>
    <div class="subtitle">Generated: {{ now()->format('F d, Y H:i:s') }}</div>
    <div class="metadata">
        <div>Report ID: THREAT-{{ now()->format('Ymd-His') }}</div>
        <div>Total Records: {{ $alerts->count() }}</div>
        <div>Page 1 of 1</div>
    </div>
</div>

@if(isset($stats))
    <div class="section-title">Summary Statistics</div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Total Alerts</div>
            <div class="value">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Today's Alerts</div>
            <div class="value">{{ $stats['today'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="label">High Threats</div>
            <div class="value">{{ $stats['high_threat'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Avg Confidence</div>
            <div class="value">{{ $stats['avg_confidence'] ?? 0 }}%</div>
        </div>
    </div>
@endif

<div class="section-title">Detailed Threat Analysis</div>
<table class="table">
    <thead>
    <tr>
        <th width="40">ID</th>
        <th width="80">Time</th>
        <th width="60">Threat</th>
        <th width="60">Trigger</th>
        <th width="50">Confidence</th>
        <th>Situation Summary</th>
        <th width="100">Primary Concern</th>
        <th width="80">Scenario</th>
    </tr>
    </thead>
    <tbody>
    @foreach($alerts as $alert)
        <tr>
            <td>{{ $alert->id }}</td>
            <td>{{ $alert->ai_timestamp->format('M d H:i') }}</td>
            <td>
                        <span class="badge badge-{{ strtolower($alert->threat_level) }}">
                            {{ $alert->threat_level }}
                        </span>
            </td>
            <td>{{ $alert->trigger_level }}</td>
            <td>
                <div class="progress">
                    <div class="progress-bar" style="width: {{ $alert->confidence_percentage }}%"></div>
                </div>
                <div style="text-align: center; font-size: 8px;">{{ $alert->confidence_percentage }}%</div>
            </td>
            <td>{{ Str::limit($alert->situation, 80) }}</td>
            <td>{{ Str::limit($alert->primary_concern, 50) }}</td>
            <td>{{ Str::limit($alert->likely_scenario, 40) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@if(isset($stats['level_distribution']))
    <div class="section-title">Threat Level Distribution</div>
    <table class="table" style="width: 50%;">
        <thead>
        <tr>
            <th>Threat Level</th>
            <th>Count</th>
            <th>Percentage</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stats['level_distribution'] as $level => $count)
            <tr>
                <td>{{ $level }}</td>
                <td>{{ $count }}</td>
                <td>{{ $stats['total'] > 0 ? round($count / $stats['total'] * 100, 1) : 0 }}%</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<div class="footer">
    <div>SkyGuardian AI Threat Analysis System</div>
    <div>Confidential - For Authorized Personnel Only</div>
    <div>Generated on: {{ now()->format('Y-m-d H:i:s') }}</div>
</div>
</body>
</html>
