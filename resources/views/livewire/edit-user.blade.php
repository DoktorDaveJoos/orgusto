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
            {{ __('restaurants.last_updated') }} {{ $this->getUserUpdatedAtForHumans() }}
        </p>
    </div>

    <div class="pt-4 px-6 tracking-wider text-gray-800 uppercase">{{ __('restaurants.information') }}</div>

    <div class="flex flex-col sm:flex-row flex-wrap p-6 border-b border-gray-200">
        @forminput(['label' => 'Name'])
        <input id="name" wire:model.debounce.500ms="name" class="orgusto-input w-full sm:w-64 flex-1 transition-all duration-150 ease-in-out" placeholder="Table number" />
        @error('name') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
        @endforminput
    </div>

    <div class="flex flex-col sm:flex-row flex-wrap p-6">
        @forminput(['label' => __('restaurants.email')])
        <span id="email" class="pt-2 text-gray-600 leading-tight text-sm"><i class="fas fa-envelope mr-2"></i>{{ $email }}</span>
        @endforminput
        @forminput(['label' => __('restaurants.type')])
        <div id="type" x-data="{handle:'{{ $user->type}}' }" class="text-xs leading-5 mt-1">
            <span class="font-semibold rounded-full -ml-2 px-2 py-1" x-bind:class="handle === 'registered' ? 'text-green-800 bg-green-200' : 'text-gray-800 bg-gray-200'">{{ $user->type }}</span>
        </div>

        @endforminput
    </div>
    @endinfocard

    @if (session()->has('message'))
    @notification
    {{ session('message') }}
    @endnotification
    @endif
</div>
