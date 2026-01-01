<?php

namespace App\Livewire\User\Partials;

use App\Models\SkyguardianWeather;
use Livewire\Component;

class TopBar extends Component
{
    public $weather;
    public $loading = false;

    public function mount()
    {
        $this->loadWeather();
    }

    public function loadWeather()
    {
        $this->weather = SkyguardianWeather::latest('data_timestamp')->first();
    }

    public function refreshWeather()
    {
        $this->loading = true;
        $this->loadWeather();
        $this->loading = false;
    }

    // Helper methods for the view
    public function getWeatherIcon()
    {
        if (!$this->weather) return 'bx-cloud';

        switch ($this->weather->weather_main) {
            case 'Clear': return 'bx-sun';
            case 'Clouds': return 'bx-cloud';
            case 'Rain': return 'bx-cloud-rain';
            case 'Snow': return 'bx-cloud-snow';
            default: return 'bx-cloud';
        }
    }

    public function getWeatherIconClass()
    {
        if (!$this->weather) return 'text-secondary';

        switch ($this->weather->weather_main) {
            case 'Clear': return 'text-warning';
            case 'Clouds': return 'text-secondary';
            case 'Rain': return 'text-primary';
            case 'Snow': return 'text-info';
            default: return 'text-secondary';
        }
    }

    public function getFormattedSunrise()
    {
        if (!$this->weather || !$this->weather->sunrise) return 'N/A';
        return \Carbon\Carbon::createFromTimestamp($this->weather->sunrise)->format('H:i');
    }

    public function getFormattedSunset()
    {
        if (!$this->weather || !$this->weather->sunset) return 'N/A';
        return \Carbon\Carbon::createFromTimestamp($this->weather->sunset)->format('H:i');
    }

    public function getFormattedVisibility()
    {
        if (!$this->weather || !$this->weather->visibility) return 'N/A';
        return round($this->weather->visibility / 1000, 1) . ' km';
    }

    public function getLastUpdated()
    {
        if (!$this->weather) return 'No data';

        if ($this->weather->data_timestamp) {
            return \Carbon\Carbon::createFromTimestamp($this->weather->data_timestamp)->diffForHumans();
        }

        return $this->weather->created_at->diffForHumans();
    }

    public function render()
    {
        return view('livewire.user.partials.top-bar');
    }
}
