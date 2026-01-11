<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alert Details - {{ $alert->analysis_id ?? $alert->id }}</title>
    <style>
        @page { margin: 20px; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #dc3545;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #dc3545;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .metadata {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .meta-item {
            margin-bottom: 8px;
        }
        .meta-label {
            font-weight: 600;
            color: #495057;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-value {
            color: #333;
            font-size: 13px;
        }
        .threat-banner {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }
        .threat-level {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .confidence {
            font-size: 16px;
            opacity: 0.9;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #495057;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #dee2e6;
        }
        .content-box {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 10px;
        }
        .highlight-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 10px 0;
        }
        .recommendations {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 6px;
            padding: 15px;
            white-space: pre-line;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: 600;
            border-radius: 4px;
            margin-right: 5px;
        }
        .badge-primary { background-color: #0d6efd; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-success { background-color: #28a745; color: white; }
    </style>
</head>
<body>
<div class="header">
    <h1>AI THREAT ANALYSIS ALERT</h1>
    <div style="color: #666; font-size: 14px;">
        Analysis ID: {{ $alert->analysis_id ?? 'N/A' }} |
        Generated: {{ now()->format('F d, Y H:i:s') }}
    </div>
</div>

<div class="metadata">
    <div class="meta-item">
        <div class="meta-label">Analysis Time</div>
        <div class="meta-value">{{ $alert->formatted_timestamp }}</div>
    </div>
    <div class="meta-item">
        <div class="meta-label">Trigger Level</div>
        <div class="meta-value">
            <span class="badge badge-primary">{{ $alert->trigger_level }}</span>
        </div>
    </div>
    <div class="meta-item">
        <div class="meta-label">AI Confidence</div>
        <div class="meta-value">{{ $alert->confidence_percentage }}%</div>
    </div>
    <div class="meta-item">
        <div class="meta-label">Response Length</div>
        <div class="meta-value">{{ number_format($alert->ai_response_length) }} characters</div>
    </div>
    <div class="meta-item">
        <div class="meta-label">AI Confidence Level</div>
        <div class="meta-value">
                <span class="badge badge-{{ $alert->confidence === 'HIGH' ? 'danger' : 'warning' }}">
                    {{ $alert->confidence }}
                </span>
        </div>
    </div>
    <div class="meta-item">
        <div class="meta-label">Alert Status</div>
        <div class="meta-value">ACTIVE</div>
    </div>
</div>

<div class="threat-banner">
    <div class="threat-level">{{ $alert->threat_level }} THREAT LEVEL</div>
    <div class="confidence">Confidence: {{ $alert->confidence }} ({{ $alert->confidence_percentage }}%)</div>
</div>

<div class="section">
    <div class="section-title">SITUATION ANALYSIS</div>
    <div class="content-box">
        {{ $alert->situation }}
    </div>
</div>

<div class="section">
    <div class="section-title">THREAT ASSESSMENT</div>
    <div class="grid-2">
        <div>
            <div style="font-weight: 600; margin-bottom: 5px; color: #dc3545;">PRIMARY CONCERN</div>
            <div class="content-box">{{ $alert->primary_concern }}</div>
        </div>
        <div>
            <div style="font-weight: 600; margin-bottom: 5px; color: #6c757d;">SECONDARY CONCERNS</div>
            <div class="content-box">{{ $alert->secondary_concerns ?? 'No secondary concerns identified' }}</div>
        </div>
    </div>
</div>

<div class="section">
    <div class="section-title">SCENARIO ANALYSIS</div>
    <div class="grid-2">
        <div>
            <div style="font-weight: 600; margin-bottom: 5px; color: #fd7e14;">LIKELY SCENARIO</div>
            <div class="highlight-box">
                <strong>{{ $alert->likely_scenario }}</strong>
            </div>
        </div>
        <div>
            <div style="font-weight: 600; margin-bottom: 5px; color: #0dcaf0;">FORECAST</div>
            <div class="content-box">{{ $alert->forecast }}</div>
        </div>
    </div>
</div>

<div class="section">
    <div class="section-title">AI RECOMMENDATIONS</div>
    <div class="recommendations">
        {!! nl2br(e($alert->recommendations)) !!}
    </div>
</div>

@if($alert->ai_analysis_raw)
    <div class="section">
        <div class="section-title">RAW AI ANALYSIS DATA</div>
        <div class="content-box" style="background-color: #f8f9fa; font-family: monospace; font-size: 10px; max-height: 300px; overflow: auto;">
            <pre>{{ $alert->ai_analysis_raw }}</pre>
        </div>
    </div>
@endif

<div class="footer">
    <div style="font-weight: 600; margin-bottom: 5px;">SkyGuardian AI Threat Analysis System</div>
    <div>This document contains sensitive threat intelligence information</div>
    <div>Classification: CONFIDENTIAL | Distribution: AUTHORIZED PERSONNEL ONLY</div>
    <div style="margin-top: 10px;">Document generated on: {{ now()->format('Y-m-d H:i:s') }}</div>
    <div>Alert ID: {{ $alert->id }} | Analysis ID: {{ $alert->analysis_id ?? 'N/A' }}</div>
</div>
</body>
</html>
