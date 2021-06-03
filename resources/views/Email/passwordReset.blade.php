@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'http://localhost:4200/response-password-reset?token='.$token])
Reset Link
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

