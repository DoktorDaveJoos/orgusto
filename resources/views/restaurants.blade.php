@extends('layouts.app')

@section('content')

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

    @if (auth()->user()->restaurants->count() >= 1)
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

                    <td class="text-xs">
                        @if ($restaurant->owner->id === auth()->user()->id)
                            <a class="bg-gray-200 hover:bg-gray-100 rounded-full p-2.5 transition-colors duration-75 ease-in-out"
                               href="{{ '/billing/restaurant/'. $restaurant->id }}">
                                <i class="fas fa-receipt mr-0.5"></i>
                                {{ __('restaurants.billing') }}
                            </a>
                        @else
                            <span class="text-gray-400 cursor-not-allowed">Rechnungsportal</span>
                        @endif
                    </td>

                    <td class="text-xs">
                        @if ($restaurant->pivot->role == 'admin')
                            <a class="bg-indigo-200 hover:bg-indigo-100 text-indigo-600 rounded-full p-2.5 transition-colors duration-75 ease-in-out"
                               href="{{ route('restaurant.show', ['restaurant' => $restaurant]) }}">
                                <i class="fas fa-edit mr-0.5"></i>
                                {{ __('restaurants.edit') }}
                            </a>
                        @else
                            <span class="text-gray-400 cursor-not-allowed">{{ __('restaurants.edit') }}</span>
                        @endif
                    </td>

                    <td x-data class="text-xs">
                        @if($restaurant->pivot->role === 'admin')
                            <button
                                class="bg-red-200 hover:bg-red-100 text-red-600 rounded-full p-2.5 transition-colors duration-75 ease-in-out"
                                x-on:click="$dispatch('open-delete{{ strtolower(str_replace(' ', '', $restaurant->name)) }}')"
                            >
                                <i class="fas fa-trash-alt mr-0.5"></i>
                                {{ __('restaurants.remove') }}
                            </button>
                        @else
                            <span class="text-gray-400 cursor-not-allowed">{{ __('restaurants.remove') }}</span>
                        @endif

                        @modal(['event' => 'open-delete'. strtolower(str_replace(" ", "", $restaurant->name)) ])
                        @slot('icon')
                            <i class="fas fa-utensils"></i>
                        @endslot
                        <h3 class="text-lg leading-6 font-medium text-gray-900 flex flex-row justify-center sm:justify-start"
                            id="modal-headline">
                            {{ __('restaurants.Delete') }} {{ $restaurant->name }}
                        </h3>

                        <form method="POST" action="/restaurants/{{ $restaurant->id }}" class="w-full -ml-2">
                            @csrf
                            @method('DELETE')
                            <div class="p-2">
                                <p class="font-semibold my-3 text-gray-700 text-sm">
                                    {{ __('restaurants.note_delete_restaurant_subscription') }}
                                </p>
                                <p class="my-2 text-gray-600">
                                    {{ __('restaurants.note_enter_restaurant_name') }}
                                </p>
                            </div>
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
                    </td>
                </tr>


            @endforeach
        @endslot
        @endtable
        @endinfocard
    @else

        <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">

                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Wilkommen bei Orgusto :-)
                        </h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p class="py-2">
                                Du hast bisher noch <strong>kein</strong> Restaurant angelegt.
                            </p>
                            <p class="py-2">
                                Um Orgusto nutzen zu können brauchst Du mindestens <strong>1</strong> Restaurant.
                            </p>
                            <p class="py-2">
                                Falls Du bereits in einem Restaurant arbeitest, das Orgusto nutzt, kann der
                                Administrator
                                des Restaurants deinen Account zur Bearbeitung des Restaurants freischalten.
                            </p>
                        </div>
                        <div class="mt-3 text-sm">
                            <button x-data x-on:click="$dispatch('open-add')"
                                    class="font-medium text-indigo-600 hover:text-indigo-500"> Restaurant anlegen <span
                                    aria-hidden="true">→</span></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endif

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
