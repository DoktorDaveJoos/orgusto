@extends('layouts.app')

@section('content')

    <div class="flex justify-center z-0">
        <img class="w-full lg:max-w-7xl absolute -mt-16" src="{{ asset('img/hero.svg')}}"/>
    </div>

    <div class="h-96 mb-8 w-full"></div>
    <div class="flex justify-center">

    <div class="flex flex-row max-w-7xl xs:flex-col">
        <div class="flex flex-col w-1/2 pl-32 mt-16">

            <div class="text-gray-800 font-bold ml-16 orgusto-lead" style="font-size: xx-large">
                Reservations. Simple.</br>Everytime. Everywhere.
            </div>

            <div class="text-gray-600 text-l ml-16 mt-4">
                Organize your reservations from anywhere and all your devices. Why complicate when it can be simple!
            </div>

            <a href="{{ route('register') }}" class="w-3/4 flex items-center justify-center ml-16 px-8 py-3 mt-4 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                Try it for free
            </a>

        </div>
        <div class="flex flex-1 m-16">

            <div class="flex flex-col mr-6 ">
                <div class="orgusto-lead text-gray-800" style="font-size: large">Simple user handling</div>
                <div class="text-gray-600 text-l mt-2">Organize your employees and assign rights to edit your restaurant the way you like.</div>
            </div>
            <div class="flex flex-col mr-6 ">
                <div class="orgusto-lead text-gray-800" style="font-size: large">Cost-effective</div>
                <div class="text-gray-600 text-l  mt-2">Good news, currently Orgusto won't cost you anything. However, it is planned that Orgusto will cost $9.99/m in the future.</div>
            </div>
            <div class="flex flex-col mr-6 ">
                <div class="orgusto-lead text-gray-800" style="font-size: large">Cloud-based</div>
                <div class="text-gray-600 text-l mt-2">It couldn't be easier. Sign up and go. All you need is a computer with an internet connection.</div>
            </div>




        </div>
    </div>

    </div>











@endsection
