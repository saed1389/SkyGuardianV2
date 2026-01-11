<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkyguardianAiAlerts extends Model
{
    protected $table = 'skyguardian_ai_alerts';

    protected $fillable = [
        'analysis_id',
        'ai_timestamp',
        'situation',
        'primary_concern',
        'secondary_concerns',
        'likely_scenario',
        'forecast',
        'recommendations',
        'threat_level',
        'trigger_level',
        'confidence',
        'ai_confidence_score',
        'ai_response_length',
        'ai_analysis_raw',
    ];

    protected $casts = [
        'ai_timestamp' => 'datetime',
        'ai_confidence_score' => 'float',
        'ai_response_length' => 'integer',
    ];

    protected $appends = [
        'formatted_timestamp',
        'confidence_percentage',
        'threat_level_color',
        'time_ago',
    ];

    public function getFormattedTimestampAttribute()
    {
        return $this->ai_timestamp?->format('M d, Y H:i:s');
    }

    public function getTimeAgoAttribute()
    {
        return $this->ai_timestamp?->diffForHumans();
    }

    public function getConfidencePercentageAttribute(): float
    {
        return round($this->ai_confidence_score * 100);
    }

    public function getThreatLevelColorAttribute(): string
    {
        $level = strtolower($this->threat_level);

        return match($level) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'success',
            'critical' => 'dark',
            default => 'secondary'
        };
    }

    // Scope for filtering
    public function scopeHighThreat($query)
    {
        return $query->where(function($q) {
            $q->where('threat_level', 'HIGH')
                ->orWhere('trigger_level', 'HIGH');
        });
    }

    public function scopeToday($query)
    {
        return $query->whereDate('ai_timestamp', now()->today());
    }

    public function scopeLastDays($query, $days)
    {
        return $query->where('ai_timestamp', '>=', now()->subDays($days));
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('situation', 'like', '%' . $term . '%')
                ->orWhere('primary_concern', 'like', '%' . $term . '%')
                ->orWhere('likely_scenario', 'like', '%' . $term . '%')
                ->orWhere('analysis_id', 'like', '%' . $term . '%');
        });
    }
}
