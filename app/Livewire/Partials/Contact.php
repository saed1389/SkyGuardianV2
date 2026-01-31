<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class Contact extends Component
{
    public $name = '';
    public $email = '';
    public $company = '';
    public $message = '';
    public $captcha = '';

    protected function getMetadata(): array
    {
        $ip = request()->ip();

        $testIp = ($ip === '127.0.0.1' || $ip === '::1') ? '195.50.209.250' : $ip;
        $position = Location::get($testIp);

        return [
            'ip_address' => $ip,
            'user_agent' => request()->userAgent(),
            'referrer'   => request()->header('referer') ?? 'Direct Traffic',
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
                'captcha' => ['Google thinks you are a robot. Please refresh and try again.']
            ]);
        }
    }

    public function submitDemo(): void
    {
        $this->validate([
            'name'    => 'required|min:3',
            'email'   => 'required|email',
            'company' => 'nullable|string',
            'captcha' => 'required'
        ]);

        $this->validateCaptcha();

        ContactMessage::create(array_merge(
            ['name' => $this->name, 'email' => $this->email, 'company' => $this->company],
            $this->getMetadata(),
            ['type' => 'demo']
        ));

        $this->reset(['name', 'email', 'company', 'captcha']);
        $this->dispatch('close-modal');
        $this->dispatch('reset-captcha');
        session()->flash('success', "<span data-translate='form_demo_send'>Demo request received! We will be in touch shortly.</span>");
    }

    public function submitContact(): void
    {
        $this->validate([
            'name'    => 'required|min:3',
            'email'   => 'required|email',
            'message' => 'required|min:10',
            'captcha' => 'required'
        ]);

        $this->validateCaptcha();

        ContactMessage::create(array_merge(
            ['name' => $this->name, 'email' => $this->email, 'message' => $this->message],
            $this->getMetadata(),
            ['type' => 'sales']
        ));

        $this->reset(['name', 'email', 'message', 'captcha']);
        $this->dispatch('close-modal');
        $this->dispatch('reset-captcha');
        session()->flash('success', "<span data-translate='form_message_send'>Message sent successfully!</span>");
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.partials.contact');
    }
}
