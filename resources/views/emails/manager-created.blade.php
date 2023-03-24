@component('mail::message')
{{ __('You have been invited to manage an Evoke campaign.') }}

@component('mail::button', ['url' => $resetLink])
{{ __('Click here to reset your password') }}
@endcomponent

{{ __('You will be able to access the system after reset your password.') }}

{{ __('Welcome to the Evoke team!') }}
@endcomponent
