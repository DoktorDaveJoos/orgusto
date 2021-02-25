@extends('layouts.app')

@section('content')

    <div class="flex justify-center -mb-16 -mt-8 sm:-my-24">
        <img class="w-full lg:max-w-7xl" src="{{ asset('img/hero.svg')}}"/>
    </div>

    <div class="flex justify-center">

    <div class="flex lg:flex-row max-w-7xl flex-col justify-around">
        <div class="flex flex-col lg:w-1/2 w-full p-6">

            <div class="text-gray-800 font-bold orgusto-lead" style="font-size: xx-large">
                Reservations. Simple.</br>Everytime. Everywhere.
            </div>

            <div class="text-gray-600 text-l mt-4">
                Organize your reservations from anywhere and all your devices. Why complicate when it can be simple!
            </div>

            <a href="{{ route('register') }}" class="flex items-center justify-center px-8 py-3 mt-4 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                Try it for free
            </a>

        </div>
        <div class="flex xs:flex-col flex-1 p-3">

            <div class="flex p-3 flex-col">
                <div class="orgusto-lead text-gray-800" style="font-size: large">Simple user handling</div>
                <div class="text-gray-600 text-l mt-2">Organize your employees and assign rights to edit your restaurant the way you like.</div>
            </div>
            <div class="flex p-3 flex-col">
                <div class="orgusto-lead text-gray-800" style="font-size: large">Cost-effective</div>
                <div class="text-gray-600 text-l mt-2">Good news, currently Orgusto won't cost you anything. However, it is planned that Orgusto will cost $9.99/m in the future.</div>
            </div>
            <div class="flex p-3 flex-col">
                <div class="orgusto-lead text-gray-800" style="font-size: large">Cloud-based</div>
                <div class="text-gray-600 text-l mt-2">It couldn't be easier. Sign up and go. All you need is a computer with an internet connection.</div>
            </div>




        </div>
    </div>

    </div>











@endsection
