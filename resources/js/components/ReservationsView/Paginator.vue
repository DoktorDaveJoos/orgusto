<template>

    <div class="flex items-center justify-between border-t border-gray-200">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#"
               class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                Previous
            </a>
            <a href="#"
               class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                Next
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ meta.from }}</span>
                    to
                    <span class="font-medium">{{ meta.to }}</span>
                    of
                    <span class="font-medium">{{ meta.total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
                    <button v-for="link in meta.links"
                            @click="handle(link.url)"
                            class="relative inline-flex items-center py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                            :class="getProperClass(link)"
                    >

                        <svg v-if="isPrevious(link.label)" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ isPrevious(link.label) || isNext(link.label) ? '' : link.label }}
                        <svg v-if="isNext(link.label)" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>

                </nav>
            </div>
        </div>
    </div>

</template>

<script>

import store from '../../store';
import {mapState} from 'vuex';

export default {
    name: "Paginator",
    store,
    methods: {
        handle(link) {
            this.$store.dispatch('loadPaginatedReservations', link);
        },
        isPrevious(label) {
            return label.toString().includes('Previous');
        },
        isNext(label) {
            return label.toString().includes('Next');
        },
        getProperClass(link) {
            let isActive = link.active ? ' text-indigo-600 bg-indigo-100' : "";
            if (this.isPrevious(link.label)) {
                return 'rounded-l-md px-2' + isActive;
            }
            if(this.isNext(link.label)) {
                return 'rounded-r-md px-2' + isActive;
            }
            return 'px-4' + isActive;
        }
    },
    computed: mapState({
        links: state => state.reservations.links,
        meta: state => state.reservations.meta
    })
}
</script>

<style scoped>

</style>
