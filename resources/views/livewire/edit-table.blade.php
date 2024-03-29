<div>
    @infocard
    @slot('title')
    <a class="hover:text-blue-400 transition-colors ease-in-out duration-200" href="{{ route('restaurant.show', ['restaurant' => $restaurant ])}}">{{ $restaurant->name }}</a> /
    {{  __('restaurants.Table') }} # {{ $table_number }}
    @endslot
    @slot('optional_button')
    <button type="button" @if (!$is_dirty) disabled @endif wire:click="submit" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
        <i class="fas fa-save mr-2"></i>
         {{ __('restaurants.save_restaurant') }}
    </button>
    @endslot

    <div class="w-full px-6 py-4 bg-gray-200">
        <p class="text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
            {{ __('restaurants.last_updated') }} {{ $this->getTableUpdatedAtForHumans() }}
        </p>
    </div>

    <div class="pt-4 px-6 tracking-wider text-gray-800 uppercase">{{ __('restaurants.information') }}</div>

    <div class="flex flex-col sm:flex-row flex-wrap p-6 border-b border-gray-200">
        @forminput(['label' => __('restaurants.table_number')])
        <input id="table_number" wire:model.debounce.500ms="table_number" class="orgusto-input w-full sm:w-64 flex-1 transition-all duration-150 ease-in-out" placeholder="Table number" />
        @error('table_number') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => __('restaurants.table_seats')])
        <input id="seats" wire:model.debounce.500ms="seats" class="orgusto-input w-full sm:w-64 transition-all duration-150 ease-in-out" placeholder="Seats" />
        @error('contact_email') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
        @forminput(['label' => __('restaurants.belongs_to')])
        <div class="py-1">
            <a href="{{ route('restaurant.show', ['restaurant' => $restaurant ])}}" class="leading-tight text-blue-400 hover:text-blue-500">
                <i class="fas fa-link mr-1"></i>{{ $restaurant->name }}</a>
        </div>
        @endforminput
    </div>

    <div class="w-full flex-wrap p-6">
        @forminput(['label' => __('restaurants.table_description')])
        <textarea id="default seat count" wire:model.debounce.500ms="description" class="orgusto-input w-full transition-all duration-150 ease-in-out" rows="10" placeholder="Some description ..."></textarea>
        @error('description') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
    </div>

    @endinfocard

    @if (session()->has('message'))
    @notification
    {{ session('message') }}
    @endnotification
    @endif

</div>
