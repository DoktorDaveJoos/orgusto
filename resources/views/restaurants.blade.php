@extends('layouts.app')

@section('content')

<div class="flex flex-col">
  <div class="mx-auto my-2 bg-gray-200 rounded-t">
    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-gray-200">
      <table class="min-w-full">
        <thead>
          <tr>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
              Name
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
              Address
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
              Owner
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
              Role
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
          </tr>
        </thead>

        @foreach($restaurants as $restaurant)
        <tbody class="bg-white">
          <tr>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <div class="items-center">
                <div class="leading-5 font-medium text-gray-900">{{ $restaurant->name }}</div>
                <div class="text-xs leading-5 text-gray-500">{{ $restaurant->contact_email }}</div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <div class="text-xs leading-5 text-gray-600">{{ $restaurant->street }} {{ $restaurant->street_number }}</div>
              <div class="text-xs leading-5 text-gray-600">{{ $restaurant->zip_code }} {{ $restaurant->city }}</div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <span class="text-xs leading-5 font-semibold text-gray-800">
                {{ $restaurant->owner }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-600">
              {{ $restaurant->pivot->role }}
            </td>
            <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
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
</div>

@endsection
