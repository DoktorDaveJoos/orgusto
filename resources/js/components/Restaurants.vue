<template>
  <div>
    <template v-if="restaurants.length > 0">
      <div class="flex flex-col p-10 px-16">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Name
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Besitzer
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Abo Status
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" x-max="1">
                  <tr v-for="restaurant in restaurants">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <div class="rounded-full bg-gray-200 h-10 w-10 flex items-center justify-center">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-5 w-5 text-gray-600"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                              />
                            </svg>
                          </div>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            {{ restaurant.name }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ restaurant.contact_email }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ restaurant.owner.name }}</div>
                      <div class="text-sm text-gray-500">{{ restaurant.owner.email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                      >
                        Active
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-else>
      <div class="p-4 sm:p-16 sm:px-48">
        <div class="bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Noch kein Restaurant!
            </h3>
            <div class="mt-2 max-w-xl text-sm text-gray-500">
              <p>
                Willkommen bei Orgusto! Schön Dich begrüßen zu dürfen.
              </p>
              <p>
                Erstelle dein erstes Restaurant um Orgusto zu nutzen! Sobald du dein erstes Restaurant erstellt hast
                kannst du loslegen! Wir freuen Uns!
              </p>
            </div>
            <div class="mt-3 text-sm">
              <button
                @click="createRestaurant"
                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none"
              >
                Neues Restaurant <span aria-hidden="true">&rarr;</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
    <create-restaurant v-on:modal-close="modal.isOpen = false" :is-open="modal.isOpen"></create-restaurant>
  </div>
</template>

<script>
import store from '../store';
import {mapState} from 'vuex';

export default {
  name: 'restaurants',
  data() {
    return {
      modal: {
        isOpen: false,
      },
    };
  },
  store,
  methods: {
    createRestaurant() {
      this.modal.isOpen = true;
    },
  },
  computed: mapState(['restaurants']),
};
</script>
