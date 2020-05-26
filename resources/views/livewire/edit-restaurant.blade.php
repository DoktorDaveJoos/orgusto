<div class="flex w-full justify-center">

    <div class="flex flex-col max-w-5xl px-10 w-full">

        @if (session()->has('message'))
        @component('notification')
        {{ session('message') }}
        @endcomponent
        @endif

        <div class="bg-white overflow-hidden rounded-t-lg border-b border-gray-200">
            <div class="bg-gray-200 px-4 pt-5 pb-4 sm:px-6">
                <div class="flex flex-row justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $name }}
                    </h3>
                    <button id="submitButton" class="orgusto-button my-auto text-green-600 hover:bg-green-600 hover:text-white transition-color duration-200 ease-in-out hidden" wire:click="submit">
                        <i class="fas fa-save mr-2"></i>
                        save restaurant
                    </button>
                </div>
                <p class="pt-6 bg-gray-50 text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                    Last updated {{ $this->getRestaurantUpdatedAtForHumans() }}
                </p>
            </div>
            <div>
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                            Name
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-col">
                                <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="name" type="text">
                                @error('name') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                            Email address
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-col">
                                <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="contact_email" type="text">
                                @error('contact_email') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                            Street
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-col">
                                <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="street" type="text">
                                @error('street') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                            Street number
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-col">
                                <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="street_number" type="text">
                                @error('street_number') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                            Zip code
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-col">
                                <input class="orgusto-input xs:w-full focus:font-semibold px-4" class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="zip_code" type="text">
                                @error('zip_code') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                            City
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-col">
                                <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="city" type="text">
                                @error('city') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm leading-5 uppercase text-gray-600 text-right self-center">
                            Owner
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-col">
                                <input class="orgusto-input xs:w-full focus:font-semibold px-4" wire:model.debounce.500ms="owner" type="text">
                                @error('owner') <span class="rounded-full bg-red-200 text-red-800 px-4 p-2 leading-tight mt-2">{{ $message }}</span> @enderror
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>


        @if (session()->has('account-operations'))
        @component('notification')
        {{ session('account-operations') }}
        @endcomponent
        @endif

        <div class="bg-white mt-6 overflow-hidden rounded-t-lg border-b border-gray-200">
            <div class="flex flex-row content-center justify-between bg-gray-200 px-4 py-4 sm:px-6">
                <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
                    Accounts
                </h3>
                <button onclick="window.dispatchEvent(new CustomEvent('open-modal'))" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i>
                    add account
                </button>
            </div>
            <div>
                <table class="min-w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                                E-mail
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>
                    </thead>
                    @foreach($this->getUsersWithPivot() as $user)
                    <tbody class="bg-white">
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap text-left">
                                <div class="text-xs leading-5 text-gray-600">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-left">
                                <div class="text-xs leading-5 text-gray-600">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <div class="text-xs leading-5 text-gray-600">{{ $user->pivot->role }}</div>
                            </td>
                            <td class="px-6 py-4 flex flex-row-reverse">
                                <button class="orgusto-button mr-0 bg-red-100 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-150 ease-in-out" wire:click="removeAccount({{ $user->id }})">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if (session()->has('table-operations'))
        @component('notification')
        {{ session('table-operations') }}
        @endcomponent
        @endif

        <div class="bg-white mt-6 overflow-hidden rounded-t-lg border-b border-gray-200">
            <div class="flex flex-row content-center justify-between bg-gray-200 px-4 py-4 sm:px-6">
                <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
                    Tables
                </h3>
                <button wire:click="addTable" class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i>
                    add table
                </button>
            </div>
            <div>
                <table class="min-w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                                Table number
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                                Seats
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                                Last updated
                            </th>
                            <th class="px-6 py-3 bg-gray-50"></th>
                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>
                    </thead>
                    @foreach($tables as $table)
                    <tbody class="bg-white">
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap text-center">
                                <div class="text-xs leading-5 text-gray-600">{{ $table->table_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-center">
                                <div class="text-xs leading-5 text-gray-600">{{ $table->seats }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs leading-5 text-gray-600">{{ $table->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-xs leading-5 text-gray-600">{{ $table->updated_at }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <a class="orgusto-button text-indigo-600 bg-indigo-100 hover:text-white hover:bg-indigo-600 transition-colors duration-150 ease-in-out" href="{{ route('restaurant.table.show', ['restaurant' => $restaurant, 'table' => $table] ) }}">Edit</a>
                            </td>
                            <td class="px-6 py-4">
                                <button class="orgusto-button bg-red-100 text-red-600 hover:text-white hover:bg-red-600 transition-colors duration-150 ease-in-out" wire:click="deleteTable({{ $table->id }})">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @livewire('add-account', ['restaurant' => $restaurant])

</div>
<script>
    window.livewire.on('activateSubmit', () => {
        var submit = document.getElementById('submitButton');
        submit.style.display = 'block';
    });
</script>
