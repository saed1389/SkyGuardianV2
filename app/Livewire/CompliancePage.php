<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class CompliancePage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $compliance = Setting::select('compliance_ee', 'compliance_en', 'compliance_tr')->first();
        return view('livewire.compliance-page', [
            'compliance' => $compliance,
        ])->layout('components.layouts.appFront');
    }
}
