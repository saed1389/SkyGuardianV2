<?php

namespace App\Livewire\Back\Setting;

use Livewire\Component;
use App\Models\Setting; // Using your 'Setting' model based on migration
use Illuminate\Support\Facades\Log;

class DynamicPage extends Component
{
    public $activeTab = 'privacy';

    public $privacy_en, $privacy_tr, $privacy_ee;

    public $term_en, $term_tr, $term_ee;

    public $license_en, $license_tr, $license_ee;

    public $compliance_en, $compliance_tr, $compliance_ee;

    public function mount(): void
    {
        $data = Setting::first();

        if ($data) {

            $this->privacy_en = $data->privacy_en;
            $this->privacy_tr = $data->privacy_tr;
            $this->privacy_ee = $data->privacy_ee;

            $this->term_en = $data->term_en;
            $this->term_tr = $data->term_tr;
            $this->term_ee = $data->term_ee;

            $this->license_en = $data->license_en;
            $this->license_tr = $data->license_tr;
            $this->license_ee = $data->license_ee;

            $this->compliance_en = $data->compliance_en;
            $this->compliance_tr = $data->compliance_tr;
            $this->compliance_ee = $data->compliance_ee;
        }
    }

    public function setTab($tab): void
    {
        $this->activeTab = $tab;
    }

    public function updateContent()
    {
        $data = [
            'privacy_en' => $this->privacy_en,
            'privacy_tr' => $this->privacy_tr,
            'privacy_ee' => $this->privacy_ee,

            'term_en' => $this->term_en,
            'term_tr' => $this->term_tr,
            'term_ee' => $this->term_ee,

            'license_en' => $this->license_en,
            'license_tr' => $this->license_tr,
            'license_ee' => $this->license_ee,

            'compliance_en' => $this->compliance_en,
            'compliance_tr' => $this->compliance_tr,
            'compliance_ee' => $this->compliance_ee,
        ];

        $setting = Setting::first();

        if ($setting) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        $this->dispatch('message', 'Dynamic pages updated successfully!');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.back.setting.dynamic-page');
    }
}
