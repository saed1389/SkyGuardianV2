<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Career;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class CareersPage extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $position = '';
    public $cv;
    public $captcha = '';

    /**
     * Gather User Analytics (Same logic as Contact form)
     */
    protected function getMetadata(): array
    {
        $ip = request()->ip();

        $testIp = ($ip === '127.0.0.1' || $ip === '::1') ? '195.50.209.250' : $ip;
        $position = Location::get($testIp);

        return [
            'ip_address' => $ip,
            'user_agent' => request()->userAgent(),
            'referrer'   => request()->header('referer') ?? 'Direct',
            'country'    => $position ? $position->countryName : 'Unknown',
            'city'       => $position ? $position->cityName : 'Unknown',
            'region'     => $position ? $position->regionName : 'Unknown',
            'zip_code'   => $position ? $position->zipCode : 'Unknown',
            'latitude'   => $position ? (string)$position->latitude : null,
            'longitude'  => $position ? (string)$position->longitude : null,
        ];
    }

    protected function validateCaptcha(): void
    {
        $response = Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
            'response' => $this->captcha,
            'remoteip' => request()->ip(),
        ]);

        if (!$response->json()['success']) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'captcha' => ['Google verification failed. Please try again.']
            ]);
        }
    }

    public function submitApplication(): void
    {
        $this->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email',
            'position' => 'required',
            'cv'       => 'required|mimes:pdf|max:10240',
            'captcha'  => 'required'
        ]);

        $this->validateCaptcha();

        $filename = Str::slug($this->name) . '-CV-' . time() . '.' . $this->cv->getClientOriginalExtension();
        $storedPath = $this->cv->storeAs('uploads/resume', $filename, 'public');

        Career::create(array_merge(
            [
                'name'     => $this->name,
                'email'    => $this->email,
                'position' => $this->position,
                'cv'       => $storedPath,
            ],
            $this->getMetadata()
        ));

        $this->reset(['name', 'email', 'position', 'cv', 'captcha']);
        $this->dispatch('reset-career-captcha');
        session()->flash('message', "<span data-translate='career_message'>Application sent successfully!</span>");
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.careers-page')
            ->layout('components.layouts.appFront');
    }
}
