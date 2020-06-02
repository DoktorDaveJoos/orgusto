@component('mail::message')
# You have been invited!

You are invited to join Orugsto.

Just register **for free** and start working on **{{ $restaurant->name }}**.

@component('mail::button', ['url' => $url])
Register for free
@endcomponent

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
