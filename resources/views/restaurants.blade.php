@extends('layouts.app')

@section('content')

    @if (sizeof($restaurants->toArray()) == 0)
        <div x-data="{ open: true }" x-show="open" class="flex w-full justify-center">
            <div
                class="flex flex-row items-center w-full max-w-5xl justify-between bg-purple-600 p-4 my-4 rounded-md font-semibold text-sm leading-tight text-white shadow-md">
                <div class="flex flex-row items-center">
                    <div class="p-2 px-3 mr-2 bg-purple-700 rounded-md">
                        <i class="fas fa-bell text-white"></i>
                    </div>
                    <span>
                        {{ __('restaurants.note_no_restaurant') }}
                    </span>
                </div>
                <button x-on:click="open = false">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ open: true }" x-show="open"
             class="flex flex-row items-center justify-between bg-red-600 p-4 my-4rounded-md font-semibold text-sm leading-tight text-white w-full shadow-md">
            <div class="flex flex-row items-center">
                <div class="p-2 px-3 mr-2 bg-red-700 rounded-md">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                {{ $errors->first() }}
            </div>
            <button x-on:click="open = false">
                <i class="fas fa-times text-white"></i>
            </button>
        </div>
    @endif

    @infocard(['title' => __('restaurants.restaurants')])
    @slot('optional_button')
        <button x-data x-on:click="$dispatch('open-add')"
                class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i>
            {{ __('restaurants.add_restaurant') }}
        </button>
    @endslot
    @table
    @slot('table_head')
        @foreach([__('restaurants.name'), __('restaurants.address'), __('restaurants.owner'), __('restaurants.role'), '', '', ''] as $th)
            @tablehead {{ $th }} @endtablehead
        @endforeach
    @endslot
    @slot('table_body')
        @foreach($restaurants as $restaurant)
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap">
                    <div class="items-center">
                        <div class="leading-5 font-medium text-gray-900">{{ $restaurant->name }}</div>
                        <div class="text-xs leading-5 text-gray-500">{{ $restaurant->contact_email }}</div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap">
                    <div
                        class="text-xs leading-5 text-gray-600">{{ $restaurant->street }} {{ $restaurant->street_number }}</div>
                    <div
                        class="text-xs leading-5 text-gray-600">{{ $restaurant->zip_code }} {{ $restaurant->city }}</div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap">
                    <span class="text-xs leading-5 font-semibold text-gray-800">
                      {{ $restaurant->owner->name }}
                    </span>
                    <div class="text-xs leading-5 text-gray-500">{{ $restaurant->owner->email }}</div>
                </td>
                @tablecell {{ $restaurant->pivot->role }} @endtablecell
                <td>
                    <a href="{{ '/billing/restaurant/'. $restaurant->id }}"
                       class="orgusto-button px-6 bg-gray-100 text-gray-600 hover:text-white hover:bg-gray-600 transition-colors duration-150 ease-in-out">{{ __('restaurants.billing') }}</a>
                </td>
                <td class="text-right pl-6 py-4 text-sm leading-5 font-medium">
                    @if ($restaurant->pivot->role == 'admin')
                        <a class="orgusto-button text-indigo-600 bg-indigo-100 hover:text-white hover:bg-indigo-600 transition-colors duration-150 ease-in-out"
                           href="{{ route('restaurant.show', ['restaurant' => $restaurant]) }}">{{ __('restaurants.edit') }}</a>
                    @else
                        <span class="w-full text-sm px-3 py-2 mx-auto text-gray-400">{{ __('restaurants.edit') }}</span>
                    @endif
                </td>

                <td x-data class="flex justify-end py-4 pr-4">
                    @if($restaurant->pivot->role === 'admin')
                        <button
                            x-on:click="$dispatch('open-delete{{ strtolower(str_replace(' ', '', $restaurant->name)) }}')"
                            class="orgusto-button px-6 bg-red-100 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-150 ease-in-out"
                        >{{ __('restaurants.remove') }}
                        </button>
                    @else
                        <span class="w-full text-sm px-3 py-2 text-gray-400">{{ __('restaurants.remove') }}</span>
                    @endif
                </td>
            </tr>
            @modal(['event' => 'open-delete'. strtolower(str_replace(" ", "", $restaurant->name)) ])
            @slot('icon')
                <i class="fas fa-utensils"></i>
            @endslot
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex flex-row justify-center sm:justify-start"
                id="modal-headline">
                {{ __('restaurants.Delete') }} {{ $restaurant->name }}
            </h3>

            <form method="POST" action="/restaurants/{{ $restaurant->id }}/delete" class="w-full -ml-2">
                @csrf
                <p class="my-2 text-gray-600 text-sm">
                    {{ __('restaurants.note_enter_restaurant_name') }}
                </p>
                @forminput(['label' => 'Restaurant name'])
                <input required pattern="{{ $restaurant->name }}" class="orgusto-input w-full" type="text"
                       name="name"
                       placeholder="{{ $restaurant->name }}"/>
                @error('name') <span
                    class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
                @endforminput
                <div class="px-4 flex flex-row-reverse">
                    <button type="submit"
                            class="orgusto-button bg-red-200 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-200 ease-in-out">
                        {{ __('restaurants.delete') }}!
                    </button>
                    <button x-on:click="openModal = false" type="button"
                            class="orgusto-button hover:bg-gray-600 hover:text-white transition-colors duration-200 ease-in-out mr-4">
                        {{ __('restaurants.cancel') }}
                    </button>
                </div>
            </form>

            @endmodal
        @endforeach
    @endslot
    @endtable
    @endinfocard

    @modal(['event' => 'open-add'])
    @slot('icon')
        <i class="fas fa-utensils"></i>
    @endslot

    <h3 class="text-lg leading-6 font-medium text-gray-900 flex flex-row justify-center sm:justify-start"
        id="modal-headline">
        {{ __('restaurants.add_restaurant') }}
    </h3>

    <form method="POST" action="/restaurants" class="w-full -ml-2">
        @csrf
        @forminput(['label' => 'Restaurant name'])
        <input class="orgusto-input w-full" type="text" name="name"
               placeholder="{{ __('restaurants.new_restaurant_placeholder') }}"/>
        @error('name') <span
            class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        <div class="px-4 flex flex-row-reverse">
            <button type="submit"
                    class="orgusto-button bg-indigo-200 text-indigo-600 hover:text-white hover:bg-indigo-600 transition-colors duration-200 ease-in-out">
                {{ __('restaurants.add') }}
            </button>
            <button x-on:click="openModal = false" type="button"
                    class="orgusto-button hover:bg-gray-600 hover:text-white transition-colors duration-200 ease-in-out mr-4">
                {{ __('restaurants.cancel') }}
            </button>
        </div>
    </form>

    @endmodal

    @if (session()->has('message'))
        @notification
        {{ session('message') }}
        @endnotification
    @endif

@endsection
