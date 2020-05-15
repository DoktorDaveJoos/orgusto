<div class="flex flex-col mx-40">
    <button class="orgusto-button" wire:click="submit">Submit</button>
    <div>
        @if (session()->has('message'))
        {{ session('message') }}
        @endif
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="bg-gray-200 px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Table number {{ $number }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                Last updated {{ $this->getUpdatedAtForHumans() }}
            </p>
        </div>
        <div>
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Table number
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <input wire:model.debounce.500ms="number" type="text">
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Restaurant
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <a class="text-blue-400" href="{{ route('restaurant.show', ['restaurant' => $restaurant_id]) }}">
                            LOL
                        </a>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Seats
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <input wire:model.debounce.500ms="seats" type="text">
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Description
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <input wire:model.debounce.500ms="description" type="text">
                    </dd>
                </div>
            </dl>
        </div>
    </div>

</div>
