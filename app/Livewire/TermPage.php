<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class TermPage extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $term = Setting::select('term_ee', 'term_en', 'term_tr')->first();
        return view('livewire.term-page', [
            'term' => $term,
        ])->layout('components.layouts.appFront');
    }
}
