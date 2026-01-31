<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class ContactPage extends Component
{
    public $name = '';
    public $email = '';
    public $message = '';
    public $captcha = '';

    /**
     * Gather User Analytics
     */
    protected function getMetadata(): array
    {
        $ip = request()->ip();
        $testIp = ($ip === '127.0.0.1' || $ip === '::1') ? '195.50.209.250' : $ip; // Test IP
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

    public function sendMessage(): void
    {
        $this->validate([
            'name'    => 'required|min:3',
            'email'   => 'required|email',
            'message' => 'required|min:10',
            'captcha' => 'required'
        ]);

        $this->validateCaptcha();

        ContactMessage::create(array_merge(
            [
                'name'    => $this->name,
                'email'   => $this->email,
                'message' => $this->message,
                'type'    => 'message'
            ],
            $this->getMetadata()
        ));

        $this->reset(['name', 'email', 'message', 'captcha']);
        $this->dispatch('reset-page-captcha');
        session()->flash('message', "<span data-translate='form_message_send'>Message sent successfully!</span>");
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.contact-page')->layout('components.layouts.appFront');
    }
}
