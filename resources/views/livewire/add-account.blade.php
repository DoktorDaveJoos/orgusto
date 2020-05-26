<div x-data="{ openModal: false }" x-show="openModal" @open-modal.window="openModal = true" @close-add-account.window="openModal = false" class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
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
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                        Add Account
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm leading-5 text-gray-500">
                            Add an existing account or invite someone new!
                        </p>
                    </div>
                    <input class="orgusto-input w-full my-4 px-4" type="text" name="user" list="usermails" placeholder="account email" wire:model="searchTerm" />
                    <datalist id="usermails">
                        @if ($users)
                        @foreach($users as $user)
                        <option value="{{ $user->email }}" />
                        @endforeach
                        @endif
                    </datalist>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full sm:ml-3 sm:w-auto">
                <button wire:click="addAccount" type="button" class="orgusto-button bg-indigo-200 text-indigo-600 hover:text-white hover:bg-indigo-600 transition-colors duration-200 ease-in-out">
                    Add
                </button>
            </span>
            <span class="mt-3 flex sm:mt-0 sm:w-auto">
                <button x-on:click="openModal = false" type="button" class="orgusto-button hover:bg-gray-600 hover:text-white">
                    Cancel
                </button>
            </span>
        </div>
    </div>
</div>
