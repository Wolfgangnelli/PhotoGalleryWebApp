@component('mail::message')
# Welcome {{$user->name}}

This is a gallery album app! 

@component('mail::button', ['url' => route('login')])
Please login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
