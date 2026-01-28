<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class PrivacyPage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $privacy = Setting::select('privacy_ee', 'privacy_en', 'privacy_tr')->first();
        return view('livewire.privacy-page', [
            'privacy' => $privacy,
        ])->layout('components.layouts.appFront');
    }
}
