<?php

namespace App\Livewire;

use App\Models\Partner;
use Livewire\Component;

class AboutPage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $partners = Partner::where('status', 1)->get();
        return view('livewire.about-page', [
            'partners' => $partners
        ])->layout('components.layouts.appFront');
    }
}
