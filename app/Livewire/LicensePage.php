<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class LicensePage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $license = Setting::select('license_ee', 'license_en', 'license_tr')->first();
        return view('livewire.license-page', [
            'license' => $license
        ])->layout('components.layouts.appFront');
    }
}
