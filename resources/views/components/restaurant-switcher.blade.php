
<div class="mx-auto my-auto text-right py-4">

    <div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false"
         class="relative inline-block text-left">

        <div>
            <label for="options-menu" class="block text-xs font-medium text-gray-600">Restaurant</label>
            <button x-on:click="open = !open" type="button"
                    class="inline-flex justify-center w-full bg-gray-100 hover:bg-gray-50 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 focus:outline-none"
                    id="options-menu" aria-haspopup="true" aria-expanded="true" x-bind:aria-expanded="open">
                {{ $selected ? $selected->name : 'Bitte wählen' }}
                <svg class="-mr-1 ml-2 h-5 w-5" x-description="Heroicon name: solid/chevron-down"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <transition enter-active-class="transition ease-out duration-100" enter-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
                    leave-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div x-show="open" x-description="Dropdown panel, show/hide based on dropdown state."
                 class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    @foreach($restaurants as $restaurant)
                        <form method="POST" action="/restaurants/{{ $restaurant->id }}/select">
                            @csrf
                            <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                    role="menuitem">
                                {{ $restaurant->name }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </transition>
    </div>

</div>
