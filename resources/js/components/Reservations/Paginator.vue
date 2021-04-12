<template>
  <div class="flex items-center justify-between border-t border-gray-200">
    <div class="flex-1 flex justify-between sm:hidden">
      <a
        href="#"
        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
      >
        Previous
      </a>
      <a
        href="#"
        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
      >
        Next
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          {{ __('common.showing') }}
          <span class="font-medium">{{ meta.from }}</span>
          {{ __('common.to') }}
          <span class="font-medium">{{ meta.to }}</span>
          {{ __('common.of') }}
          <span class="font-medium">{{ meta.total }}</span>
          {{ __('common.results') }}
        </p>
      </div>
      <div>
        <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
          <button
            v-for="link in meta.links"
            @click="handle(link.url)"
            class="relative inline-flex items-center py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
            :class="getProperClass(link)"
            v-html="link.label"
          ></button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import store from '../../store';
import {mapState} from 'vuex';

export default {
  name: 'Paginator',
  store,
  methods: {
    handle(link) {
      this.$store.dispatch('loadPaginatedReservations', link);
    },
    getProperClass(link) {
      let isActive = link.active ? ' text-indigo-600 bg-indigo-100' : '';
      return 'px-4' + isActive;
    },
  },
  computed: mapState({
    links: state => state.reservations.links,
    meta: state => state.reservations.meta,
  }),
};
</script>

<style scoped></style>
