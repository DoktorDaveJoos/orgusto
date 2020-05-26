@extends('layouts.app')

@section('content')

<div class="flex w-full justify-center">
  <div class="max-w-5xl px-10 w-full">

    @if (sizeof($restaurants->toArray()) == 0)
    <div x-data="{ open: true }" x-show="open" class="flex flex-row items-center justify-between bg-purple-600 p-4 my-4 rounded-md font-semibold text-sm leading-tight text-white w-full shadow-md">
      <div class="flex flex-row items-center">
        <div class="p-2 px-3 mr-2 bg-purple-700 rounded-md">
          <i class="fas fa-bell text-white"></i>
        </div>
        Please note: You need to have at least one restaurant. Create your first restaurant or request access to an existing one.
      </div>
      <button @click="open = false">
        <i class="fas fa-times text-white"></i>
      </button>
    </div>
    @endif

    <div class="flex flex-col bg-gray-200 rounded-t-lg">

      <div class="px-4 py-5 sm:px-6">
        <div class="flex flex-row justify-between">
          <h3 class="text-lg leading-6 font-medium text-gray-900 self-center">
            Restaurants
          </h3>
          <button id="submitButton" class="orgusto-button my-auto text-blue-600 hover:bg-blue-600 hover:text-white transition-color duration-200 ease-in-out">
            <i class="fas fa-plus mr-2"></i>
            add restaurant
          </button>
        </div>
      </div>
      @if (sizeof($restaurants->toArray()) == 0)
      <div class="p-4 text-gray-700 text-sm font-light">
        No restaurants so far.
      </div>
      @else
      <div class="bg-gray-200 w-full">
        <div class="align-middle overflow-hidden">
          <table class="min-w-full">
            <thead>
              <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                  Name
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                  Address
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                  Owner
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                  Role
                </th>
                <th class="px-6 py-3 bg-gray-50"></th>
              </tr>
            </thead>

            @foreach($restaurants as $restaurant)
            <tbody class="bg-white">
              <tr>
                <td class="px-6 py-4 whitespace-no-wrap">
                  <div class="items-center">
                    <div class="leading-5 font-medium text-gray-900">{{ $restaurant->name }}</div>
                    <div class="text-xs leading-5 text-gray-500">{{ $restaurant->contact_email }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap">
                  <div class="text-xs leading-5 text-gray-600">{{ $restaurant->street }} {{ $restaurant->street_number }}</div>
                  <div class="text-xs leading-5 text-gray-600">{{ $restaurant->zip_code }} {{ $restaurant->city }}</div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap">
                  <span class="text-xs leading-5 font-semibold text-gray-800">
                    {{ $restaurant->owner }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600">
                  {{ $restaurant->pivot->role }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-center">
                  @if ($restaurant->pivot->role == 'admin')
                  <a class="orgusto-button text-indigo-600 bg-indigo-100 hover:text-white hover:bg-indigo-600 transition-colors duration-150 ease-in-out" href="{{ route('restaurant.show', ['restaurant' => $restaurant->id] ) }}">Edit</a>
                  @else
                  <span class="px-2 text-xs leading-5 text-gray-500">
                    requires admin rights.
                  </span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

@endsection
