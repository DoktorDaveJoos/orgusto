@extends('layouts.app')

@section('content')

    <div class="flex justify-center -mb-24 -mt-8 sm:-mt-24 sm:-mb-24 relative">
        <img class="w-full lg:max-w-7xl" src="{{ asset('img/hero.svg')}}"/>
        <div class="absolute inset-x-0 bottom-24 flex justify-center">
            <a href="{{ route('login') }}"
               class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
               aria-describedby="tier-standard">
                Jetzt kostenlos testen!
            </a>
        </div>
    </div>

    <div _style="max-height: 800px;" class="overflow-y-auto">

        <div class="relative bg-gray-100 pb-10 pt-6">
            <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                <h2 class="text-base font-semibold tracking-wider text-indigo-600 uppercase">Dein Restaurant Manager</h2>
                <p class="mt-2 text-3xl text-gray-900 font-extrabold tracking-tight sm:text-4xl">
                    Dein Restaurant. Einfach. Immer. Überall.
                </p>
                <p class="mt-5 max-w-prose mx-auto text-xl text-gray-500">
                    Organisiere deine Reservierungen, deine Take Away Bestellungen und vieles mehr! Orgusto ist all das,
                    was du brauchst um dein Restaurant optimal auszulasten und immer den Überblick zu behalten.
                </p>
                <div class="mt-12">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span
                                            class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-md shadow-lg">
                                          <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                               viewBox="0 0 24 24"
                                               stroke="currentColor" aria-hidden="true">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Cloud-basiert</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Es könnte nicht einfacher sein. Registrieren und loslegen. Alles was du brauchst
                                        ist ein internetfähiges Gerät!
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span
                                            class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-md shadow-lg">
                                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" aria-hidden="true">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Verschlüsselte
                                        Verbindung</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Wir arbeiten mit dem neuesten Stand der Technik. Alles ausschließlich
                                        SSL-verschlüsselt.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span
                                            class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-md shadow-lg">
                                                  <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                       fill="none" viewBox="0 0 24 24"
                                                       stroke="currentColor" aria-hidden="true">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Updates</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Wir arbeiten laufend an Orgusto und sorgen dafür, dass es immer besser wird.
                                        Wir freuen Uns auf Deine Verbesserungsvorschläge!
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                    <span class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-md shadow-lg">
                      <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                                    </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Sicherheit</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Du musst dich nicht mehr um den Daten-Krims-Krams kümmern. All deine Daten und
                                        die Deiner
                                        Gäste liegen auf deutschen Servern.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                    <span class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-md shadow-lg">
                      <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
</svg>
                    </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Nutzerrechte</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Bestimme, wer von deinen Angestellten welche Rechte hat und was er tun darf.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                    <span class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-md shadow-lg">
                      <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
</svg>
                    </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Backups</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Wir sorgen dafür, dass deine Daten nicht verloren gehen. Du musst Dich nur noch
                                        um
                                        deine Gäste kümmern.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="bg-gray-800 mt-16">
        <div class="pt-12 sm:pt-16 lg:pt-24">
            <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto space-y-2 lg:max-w-none">
                    <h2 class="text-lg leading-6 font-semibold text-gray-300 uppercase tracking-wider">
                        Preise
                    </h2>
                    <p class="text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">
                        Das richtige Paket für jedes Restaurant!
                    </p>
                    <p class="text-xl text-gray-300">
                        Du kannst jedes Paket eine Woche lang kostenfrei testen. Wenn wir es nicht schaffen Dich zu überzeugen, kannst du jederzeit kündigen.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 pb-12 bg-gray-100 sm:mt-12 sm:pb-16 lg:mt-16 lg:pb-24">
            <div class="relative">
                <div class="absolute inset-0 h-3/4 bg-gray-800"></div>
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-md mx-auto space-y-4 lg:max-w-5xl lg:grid lg:grid-cols-2 lg:gap-5 lg:space-y-0">

                        <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-8 bg-white sm:p-10 sm:pb-6">
                                <div>
                                    <h3 class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-indigo-100 text-indigo-600"
                                        id="tier-standard">
                                        Standard
                                    </h3>
                                </div>
                                <div class="mt-4 flex items-baseline text-6xl font-extrabold">
                                    €29
                                    <span class="ml-1 text-2xl font-medium text-gray-500">
                                      /mo
                                    </span>
                                </div>
                                <p class="mt-2 pl-1 text-l text-gray-500">
                                    <strong>€313,20</strong> jährlich
                                </p>
                                <p class="mt-5 text-lg text-gray-500">
                                    Kündbar entsprechend monatlich oder jährlich.
                                </p>
                            </div>
                            <div
                                class="flex-1 flex flex-col justify-between px-6 pt-6 pb-8 bg-gray-50 space-y-6 sm:p-10 sm:pt-6">
                                <ul class="space-y-4">

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Unbegrenzte Reservierungen
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Nutzerrechte & Rollen
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Bis zu 100 Tische
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Support via Mail & Telefon
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Take Away Online Shop *
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <p class="text-xs text-gray-700">
                                            * Noch nicht verfügbar
                                        </p>
                                    </li>



                                </ul>
                                <div class="rounded-md shadow">
                                    <a href="{{ route('login') }}"
                                       class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                                       aria-describedby="tier-standard">
                                        Jetzt kostenlos testen!
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-8 bg-white sm:p-10 sm:pb-6">
                                <div>
                                    <h3 class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-gray-100 text-gray-600"
                                        id="tier-standard">
                                        Advanced
                                    </h3>
                                </div>
                                <div class="mt-4 flex items-baseline text-6xl font-extrabold">
                                    €59*
                                    <span class="ml-1 text-2xl font-medium text-gray-500">
                                      /mo
                                    </span>
                                </div>
                                <p class="mt-5 text-lg text-gray-500">
                                    Kündbar entsprechend monatlich oder jährlich.
                                </p>
                            </div>
                            <div
                                class="flex-1 flex flex-col justify-between px-6 pt-6 pb-8 bg-gray-50 space-y-6 sm:p-10 sm:pt-6">
                                <ul class="space-y-4">

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Ungerenzte Reservierungen
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Nutzerrechte & Rollen
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Unbegrenzt viele Tische
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Support via Mail & Telefon
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Metriken & Auslastungsanalyse
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Online Reservierungen via Whatsapp & Telegram
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Online Reservierungen über deine Webseite
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-base text-gray-700">
                                            Take Away Online Shop
                                        </p>
                                    </li>

                                    <li class="flex items-start">
                                        <p class="text-xs text-gray-700">
                                            * Preis des Pakets kann sich noch ändern
                                        </p>
                                    </li>

                                </ul>
                                <div class="rounded-md shadow">
                                    <div
                                        class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-500 cursor-not-allowed"
                                        aria-describedby="tier-standard">
                                        Noch nicht verfügbar!
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div _style="max-height: 800px;">

        <div class="bg-gray-100 py-10 sm:py-16">
            <div class="relative sm:py-16">
                <div aria-hidden="true" class="hidden sm:block">
                    <div class="absolute inset-y-0 left-0 w-1/2 bg-gray-50 rounded-r-3xl"></div>
                    <svg class="absolute top-8 left-1/2 -ml-3" width="404" height="392" fill="none"
                         viewBox="0 0 404 392">
                        <defs>
                            <pattern id="8228f071-bcee-4ec8-905a-2a059a2cc4fb" x="0" y="0" width="20" height="20"
                                     patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor"></rect>
                            </pattern>
                        </defs>
                        <rect width="404" height="392" fill="url(#8228f071-bcee-4ec8-905a-2a059a2cc4fb)"></rect>
                    </svg>
                </div>
                <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
                    <div
                        class="relative rounded-2xl px-6 py-10 bg-indigo-600 overflow-hidden shadow-xl sm:px-12 sm:py-20">
                        <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
                            <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="xMidYMid slice"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                                <path class="text-indigo-500 text-opacity-40" fill="currentColor"
                                      d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z"></path>
                                <path class="text-indigo-700 text-opacity-40" fill="currentColor"
                                      d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z"></path>
                            </svg>
                        </div>
                        <div class="relative">
                            <div class="sm:text-center">
                                <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                                    Bleib up-to-date! :-)
                                </h2>
                                <p class="mt-6 mx-auto max-w-2xl text-lg text-indigo-200">
                                    Wir geben Bescheid sobald ein neues Paket zur Verfügung steht oder wir neue coole
                                    Features freigeben!
                                </p>
                            </div>
                            <form method="POST" action="/newsletter" class="mt-12 sm:mx-auto sm:max-w-lg sm:flex">
                                @csrf
                                <div class="min-w-0 flex-1">
                                    <label for="cta_email" class="sr-only">Email Adresse</label>
                                    <input id="cta_email" type="email"
                                           name="email"
                                           class="block w-full border border-transparent rounded-md px-5 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600"
                                           placeholder="Deine Email-Adresse">
                                </div>
                                <div class="mt-4 sm:mt-0 sm:ml-3">
                                    <button type="submit"
                                            class="block w-full rounded-md border border-transparent px-5 py-3 bg-indigo-600 text-base font-medium text-white shadow hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 sm:px-10">
                                        Gebt bescheid!
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Session message regarding newsletter --}}
        @if (Session::has('newsletter'))
            <div
                class="fixed bottom-0 right-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
                <transition enter-active-class="transform ease-out duration-300 transition"
                            enter-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                            leave-active-class="transition ease-in duration-100" leave-class="opacity-100"
                            leave-to-class="opacity-0">
                    <div x-data="{ show: true }" x-show="show"
                         x-description="Notification panel, show/hide based on alert state."
                         class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div class="p-4 w-72">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-400"
                                         x-description="Heroicon name: outline/check-circle"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium text-gray-900">
                                        Newsletter
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ Session::get('newsletter') }}
                                    </p>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex">
                                    <button x-on:click="show = false;"
                                            class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Close</span>
                                        <svg class="h-5 w-5" x-description="Heroicon name: solid/x"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                             aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        @endif

    </div>













@endsection
