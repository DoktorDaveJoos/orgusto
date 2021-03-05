@component('mail::message')
# Du wurdest eingeladen!

Du wurdest zu Orugsto eingeladen.

Melde dich **kostenlos** and und starte die Arbeit an **{{ $restaurant->name }}**.

@component('mail::button', ['url' => $url])
Kostenlos registrieren
@endcomponent

Danke,<br>
{{ config('app.name') }} Team
@endcomponent
