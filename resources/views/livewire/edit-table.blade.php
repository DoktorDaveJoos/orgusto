<div class="flex flex-col mx-40">

    @if (session()->has('message'))
    <div x-data="{ open: true }" x-show="open" class="flex flex-row items-center justify-between bg-purple-600 p-4 my-4 rounded-md font-semibold text-sm leading-tight text-white w-full shadow-md">
        <div class="flex flex-row items-center">
            <div class="p-2 px-3 mr-2 bg-purple-700 rounded-md">
                <i class="fas fa-bell text-white"></i>
            </div>
            {{ session('message') }}
        </div>
        <button @click="open = false">
            <i class="fas fa-times text-white"></i>
        </button>
    </div>
    @endif

    <div class="bg-white overflow-hidden rounded-t-lg border-b border-gray-200">
        <div class="bg-gray-200 px-4 pt-5 pb-4 sm:px-6">
            <div class="flex flex-row justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Table number {{ $table_number }}
                </h3>
                <button id="submitButton" class="orgusto-button bg-gray-300 hover:bg-green-300 hover:text-gray-900 transition-color duration-200 ease-in-out hidden" wire:click="submit">
                    <i class="fas fa-save"></i>
                    save
                </button>
            </div>
            <p class="pt-6 bg-gray-50 text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                Last updated {{ $this->getTableUpdatedAtForHumans() }}
            </p>
        </div>
    </div>
    <div>
        <dl>
            <form wire:submit.prevent="submit">

                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                        Table number
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex flex-col">
                            <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="table_number" type="text">
                            @error('table_number') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                        </div>
                    </dd>
                </div>

                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                        Restaurant
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <a class="text-blue-400" href="{{ route('restaurant.show', ['restaurant' => $restaurant->id]) }}">
                            {{ $restaurant->name }}
                            <i class="fas fa-external-link-alt text-blue-400"></i>
                        </a>
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                        Seats
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex flex-col">
                            <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="seats" type="text">
                            @error('seats') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                        </div>
                    </dd>
                </div>

                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                        Description
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex flex-col">
                            <textarea class="orgusto-input rounded xs:w-full focus:font-semibold px-4 w-full" wire:model.debounce.500ms="description" type="text"></textarea>
                            @error('description') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight">{{ $message }}</span> @enderror
                        </div>
                    </dd>
                </div>
            </form>
        </dl>
    </div>
</div>

<script>
    window.livewire.on('activateSubmit', () => {
        var submit = document.getElementById('submitButton');
        submit.style.display = 'block';
    })
</script>

</div>
