@component('mail::message')

<p style="text-align:center;margin-bottom:16px;">
    <img src="{{ asset('images/sioms-logo-horizontal.svg') }}" alt="{{ config('app.name') }}"
         style="max-width:220px;height:auto;">
</p>

# Welcome to {{ config('app.name') }}

Hello {{ $user->name }},

An account has been created for you as a staff member on **{{ config('app.name') }}**.

You can log in using the following temporary credentials:

- **Email**: {{ $user->email }}
- **Temporary Password**: {{ $temporaryPassword }}

> For your security, please log in as soon as possible and change this password from your profile/settings page.

@component('mail::button', ['url' => route('login')])
Login Now
@endcomponent

If you did not expect this account, please contact the administrator of {{ config('app.name') }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent



