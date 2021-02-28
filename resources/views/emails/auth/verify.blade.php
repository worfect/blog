@component('mail::message')
# Email Confirmation

Hi, {{ $login }}!

Please  confirm your email for getting access to the full functionality of the site:
@component('mail::button', ['url' => route('verification.verify', ['token' => $token])])
    Verify Email
@endcomponent

Thanks you.
@endcomponent


