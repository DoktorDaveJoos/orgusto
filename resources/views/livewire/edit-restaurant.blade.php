<div>

    @infocard(['title' => $name])
    @slot('optional_button')
    <button type="button" @if (!$is_dirty) disabled @endif wire:click="submit" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
        <i class="fas fa-save mr-2"></i>
        save restaurant
    </button>
    @endslot

    <div class="w-full px-6 py-4 bg-gray-200">
        <p class="text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
            Last updated {{ $this->getRestaurantUpdatedAtForHumans() }}
        </p>
    </div>

    <div class="pt-4 px-6 tracking-wider text-gray-800 uppercase">Information</div>

    <div class="flex flex-col sm:flex-row flex-wrap p-6 border-b border-gray-200">
        @forminput(['label' => 'name'])
        <input id="name" wire:model.debounce.500ms="name" class="orgusto-input w-full sm:w-64 flex-1 transition-all duration-150 ease-in-out" placeholder="Restaurant name" />
        @error('name') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => 'email'])
        <input id="email" wire:model.debounce.500ms="contact_email" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="Email" />
        @error('contact_email') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => 'owner'])
        <input id="owner" wire:model.debounce.500ms="owner" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="Owner" />
        @error('owner') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
    </div>

    <div class="pt-4 px-6 tracking-wider text-gray-800 uppercase">Address</div>

    <div class="flex flex-col sm:flex-row flex-wrap p-6 border-b border-gray-200">
        @forminput(['label' => 'street'])
        <input id="street" wire:model.debounce.500ms="street" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="Street" />
        @error('street') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => 'street number'])
        <input id="street number" wire:model.debounce.500ms="street_number" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="Street number" />
        @error('street_number') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => 'zip code'])
        <input id="zip code" wire:model.debounce.500ms="zip_code" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="Zip code" />
        @error('zip_code') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => 'city'])
        <input id="city" wire:model.debounce.500ms="city" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="City" />
        @error('city') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
    </div>

    <div class="pt-4 px-6 tracking-wider text-gray-800 uppercase">Settings</div>

    <div class="flex flex-col sm:flex-row w-2/3 flex-wrap p-6 ">
        @forminput(['label' => 'Default seat count'])
        <input id="default seat count" wire:model.debounce.500ms="default_table_seats" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="Number of seats by default" />
        @error('default_table_seats') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => 'Bind seat count'])
        <label for="x123" class="inline-flex items-center cursor-pointer">
            <span x-data="{ isChecked : @if($this->seat_reservation_bound) true @else false @endif }" class="relative">
                <span class="block h-8 rounded-full shadow-inner bg-gray-200" style="width: 3.5rem"></span>
                <span class="pl-1 w-6 h-6" x-bind:class="isChecked ? 'unchecked' : 'checked'">
                    <input wire:model="seat_reservation_bound" id="x123" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                    <i class="fas fa-check text-gray-200 transition-opacity duration-300 ease-in-out" style="height: 0.125rem;" x-bind:class="isChecked ? 'opacity-0' : 'opacity-100'"></i>
                </span>
            </span>
        </label>
        @error('seat_reservation_bound') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
    </div>

    @endinfocard

    @infocard(['title' => 'Accounts'])
    @slot('optional_button')
    <button onclick="window.dispatchEvent(new CustomEvent('open-modal'))" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
        <i class="fas fa-plus mr-2"></i>
        add account
    </button>
    @endslot
    @table
    @slot('table_head')
    @foreach(['Name', 'Email', 'Type', 'Role', '', ''] as $th)
    @tablehead {{ $th }} @endtablehead
    @endforeach
    @endslot
    @slot('table_body')
    @foreach($this->getUsersWithPivot() as $user)
    <tr class="hover:bg-gray-100">
        @tablecell {{ $user->name }} @endtablecell
        @tablecell {{ $user->email }} @endtablecell
        <td class="px-6">
            <div x-data="{handle:'{{ $user->type}}' }" class="text-xs leading-5">
                <span class="font-semibold rounded-full -ml-2 px-2 py-1" x-bind:class="handle === 'registered' ? 'text-green-800 bg-green-200' : 'text-gray-800 bg-gray-200'">{{ $user->type }}</span>
            </div>
        </td>
        @tablecell {{ $user->pivot->role }} @endtablecell
        <td class="px-6 py-4 text-right text-sm leading-5 font-medium">
            @if ($user->type == 'anonymous' || $user->type == 'invited' || $user->id == auth()->user()->id)
            <a class="orgusto-button text-indigo-600 bg-indigo-100 hover:text-white hover:bg-indigo-600 transition-colors duration-150 ease-in-out" href="{{ route('user.show', ['user' => $user]) }}">Edit</a>
            @endif
        </td>
        <td class="px-6 py-4 flex justify-end">
            @if($user->pivot->role != 'admin')
            <button wire:click="removeAccount({{ $user->id }})" class="orgusto-button my-auto mr-0 bg-red-100 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-150 ease-in-out">Remove</button>
            @endif
        </td>
    </tr>
    @endforeach
    @endslot
    @endtable
    @endinfocard

    @infocard(['title' => 'Tables'])
    @slot('optional_button')
    <button wire:click="addTable" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
        <i class="fas fa-plus mr-2"></i>
        add table
    </button>
    @endslot
    @table
    @slot('table_head')
    @foreach(['Table Number', 'Seats', 'Description', 'Updated at', '', ''] as $th)
    @tablehead {{ $th }} @endtablehead
    @endforeach
    @endslot
    @slot('table_body')
    @foreach($tables as $table)
    <tr class="hover:bg-gray-100">
        @tablecell {{ $table->table_number }} @endtablecell
        @tablecell {{ $table->seats }} @endtablecell
        @tablecell {{ $table->description }} @endtablecell
        @tablecell {{ $table->updated_at }} @endtablecell
        <td class="px-6 py-4 text-right text-sm leading-5 font-medium">
            <a class="orgusto-button text-indigo-600 bg-indigo-100 hover:text-white hover:bg-indigo-600 transition-colors duration-150 ease-in-out" href="{{ route('restaurant.table.show', ['restaurant' => $restaurant, 'table' => $table]) }}">Edit</a>
        </td>
        <td class="px-6 py-4">
            <button wire:click="deleteTable({{ $table->id }})" class="orgusto-button my-auto mr-0 bg-red-100 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-150 ease-in-out">Delete</button>
        </td>
    </tr>
    @endforeach
    @endslot
    @endtable
    @endinfocard

    @livewire('add-account', ['restaurant' => $restaurant])

    @if (session()->has('message'))
    @notification
    {{ session('message') }}
    @endnotification
    @endif
</div>
