<div>

    @infocard(['title' => $name])
    @slot('optional_button')
    <button type="button" @if (!$is_dirty) disabled @endif wire:click="submit" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
        <i class="fas fa-save mr-2"></i>
        {{ __('restaurants.save_restaurant') }}
    </button>
    @endslot

    <div class="w-full px-6 py-4 bg-gray-200">
        <p class="text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
            {{ __('restaurants.last_updated') }} {{ $this->getRestaurantUpdatedAtForHumans() }}
        </p>
    </div>

    <div class="pt-4 px-6 tracking-wider text-gray-800 uppercase">{{ __('restaurants.information') }}</div>

    <div class="flex flex-col sm:flex-row flex-wrap p-6 border-b border-gray-200">
        @forminput(['label' => __('restaurants.name')])
        <input id="name" wire:model.debounce.500ms="name" class="orgusto-input w-full sm:w-64 flex-1 transition-all duration-150 ease-in-out" placeholder="Restaurant name" />
        @error('name') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => __('restaurants.email')])
        <input id="email" wire:model.debounce.500ms="contact_email" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="{{ __('restaurants.email') }}" />
        @error('contact_email') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
    </div>

    @endinfocard

    @infocard(['title' => __('restaurants.accounts') ])
    @slot('optional_button')
    <button onclick="window.dispatchEvent(new CustomEvent('open-modal'))" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
        <i class="fas fa-plus mr-2"></i>
        {{ __('restaurants.add_account') }}
    </button>
    @endslot
    @table
    @slot('table_head')
    @foreach([__('restaurants.name'), __('restaurants.email'), __('restaurants.type'), __('restaurants.role'), '', ''] as $th)
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
            <a class="orgusto-button text-indigo-600 bg-indigo-100 hover:text-white hover:bg-indigo-600 transition-colors duration-150 ease-in-out" href="{{ route('user.show', ['user' => $user]) }}">{{ __('restaurants.edit') }}</a>
            @endif
        </td>
        <td class="px-6 py-4 flex justify-end">
            @if($user->pivot->role != 'admin')
            <button wire:click="removeAccount({{ $user->id }})" class="orgusto-button my-auto mr-0 bg-red-100 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-150 ease-in-out">{{ __('restaurants.remove') }}</button>
            @endif
        </td>
    </tr>
    @endforeach
    @endslot
    @endtable
    @endinfocard

    @infocard(['title' => __('restaurants.tables') ])
    @slot('optional_button')
    <button wire:click="addTable" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
        <i class="fas fa-plus mr-2"></i>
        {{ __('restaurants.add_table') }}
    </button>
    @endslot
    @table
    @slot('table_head')
    @foreach([__('restaurants.table_number'), __('restaurants.table_seats'), __('restaurants.table_description'), __('restaurants.last_updated'), '', ''] as $th)
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
            <a class="orgusto-button text-indigo-600 bg-indigo-100 hover:text-white hover:bg-indigo-600 transition-colors duration-150 ease-in-out" href="{{ route('restaurant.table.show', ['restaurant' => $restaurant, 'table' => $table]) }}">{{ __('restaurants.edit') }}</a>
        </td>
        <td class="px-6 py-4">
            <button wire:click="deleteTable({{ $table->id }})" class="orgusto-button my-auto mr-0 bg-red-100 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-150 ease-in-out">{{ __('restaurants.delete') }}</button>
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
