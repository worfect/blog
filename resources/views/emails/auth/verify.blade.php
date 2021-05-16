@component('mail::message')
# Email Confirmation

Please enter this code on the verification page for getting access to the full functionality of the site:
@component('mail::panel')
    {{ $code }}
@endcomponent
@component('mail::button', ['url' => route('verification.verify')])
    Verify Page
@endcomponent

Thanks you.
@endcomponent


