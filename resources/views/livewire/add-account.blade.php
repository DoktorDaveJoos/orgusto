<div x-data="{ openModal: false, tab: 'anon' }" x-show="openModal" x-on:open-modal.window="openModal = true" x-on:close-add-account.window="openModal = false" class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
    <!--
            Background overlay, show/hide based on modal state.

            Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
            Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
    <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <!--
            Modal panel, show/hide based on modal state.

            Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-user-friends"></i>
                </div>

                <div class="flex flex-col px-4 w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex flex-row" id="modal-headline">
                        {{  __('restaurants.add_employee') }}
                        <div wire:loading wire:target="addAccount" class="loader h-6 w-6 ml-4"></div>
                    </h3>
                    <div class="flex border-b border-gray-400 my-4 w-full">
                        <button class="text-sm p-2 leading-tight text-gray-600 focus:outline-none" x-bind:class="{'border-b-4 border-gray-500 text-gray-800': tab === 'anon'}" x-on:click="tab = 'anon'">{{  __('restaurants.user_name') }}</button>
                        <button class="mr-4 text-sm p-2 leading-tight text-gray-600 focus:outline-none" x-bind:class="{'border-b-4 border-gray-500 text-gray-800': tab === 'email'}" x-on:click="tab = 'email'">{{  __('restaurants.user_account') }}</button>
                    </div>

                    <div x-show="tab === 'email'" class="mt-3 text-center sm:mt-0 sm:text-left">
                        <div class="mt-2">
                            <p class="text-sm leading-5 text-gray-500">
                                {{  __('restaurants.add_description') }}
                            </p>
                        </div>
                        @forminput(['label' => __('restaurants.email')])
                        <input class="orgusto-input w-full px-4" type="text" name="user" list="usermails" placeholder="{{  __('restaurants.account_email') }}" wire:model="searchTerm" />
                        <datalist id="usermails">
                            @if ($users)
                            @foreach($users as $user)
                            <option value="{{ $user->email }}" />
                            @endforeach
                            @endif
                        </datalist>
                        @error('searchTerm') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
                        @endforminput
                    </div>
                    <div x-show="tab === 'anon'" class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <div class="mt-2 text-gray-600 w-full">
                            <p class="text-sm leading-5">
                                {{  __('restaurants.add_employee_name') }}
                            </p>
                            <br>
                            <p class="text-sm leading-5 font-semibold text-gray-800">
                                {{  __('restaurants.important') }}
                            </p>
                            <p class="text-sm leading-5">
                                {{  __('restaurants.add_by_name_warning') }}
                            </p>
                        </div>
                        @forminput(['label' => 'Name'])
                        <input class="orgusto-input w-full px-4" type="text" name="anon_name" placeholder="{{  __('restaurants.employee_name') }}" wire:model="anon_name" />
                        @endforminput
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full sm:ml-3 sm:w-auto">
                <button x-show="tab === 'email'" @if($is_disabled) disabled @endif wire:click="addAccount" wire:loading.attr="disabled" type="button" class="orgusto-button bg-indigo-200 text-indigo-600 hover:text-white hover:bg-indigo-600 transition-colors duration-200 ease-in-out">
                    {{ $action_button_text }}
                </button>
                <button x-show="tab === 'anon'" @if($anon_is_disabled) disabled @endif wire:click="addAnonymousAccount" wire:loading.attr="disabled" type="button" class="orgusto-button bg-indigo-200 text-indigo-600 hover:text-white hover:bg-indigo-600 transition-colors duration-200 ease-in-out">
                    {{  __('restaurants.add') }}
                </button>
            </span>
            <span class="mt-3 flex sm:mt-0 sm:w-auto">
                <button x-on:click="openModal = false" type="button" class="orgusto-button hover:bg-gray-600 hover:text-white transition-colors duration-200 ease-in-out">
                    {{  __('restaurants.cancel') }}
                </button>
            </span>
        </div>
    </div>
</div>
