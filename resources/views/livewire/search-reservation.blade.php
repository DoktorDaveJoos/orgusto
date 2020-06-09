<div class="w-full max-w-5xl">
    <div class="group mt-1 relative rounded-full border-2 border-gray-200 focus-within:border-blue-200 shadow-lg bg-white p-3 pl-10">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-600 sm:text-sm sm:leading-5 mx-1">
                <i class="fas fa-search"></i>
            </span>
        </div>
        <input id="reservations.search" wire:model="searchTerm" class="bg-white form-input block w-full sm:text-sm sm:leading-5 focus:outline-none" placeholder="Search" />
        @if ($results)
        <div class="origin-top-right absolute right-0 mt-5 w-full border-2 border-gray-200 rounded-lg shadow-lg">
            <div class="bg-white rounded-lg" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                @foreach($results as $result)
                <div class="py-1">
                    <a href="{{ route('reservations.show').'?reservation='.$result->id }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">{{ $result->name }}
                    </a>
                </div>
                <div class="border-t border-gray-200"></div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
