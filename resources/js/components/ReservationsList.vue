<template>
  <div class="w-full flex justify-center">
    <div class="bg-white w-full shadow-lg max-w-7xl self-center mt-6 mx-6 overflow-hidden rounded-lg">
      <div class="bg-gray-200 justify-between px-6">
        <div class="flex flex-row justify-between py-4">
          <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
            {{ __('common.Reservations') }}
          </h3>
        </div>

        <div class="flex flex-row pb-4 h-14 bg-gray-200 justify-between">
          <div class="flex flex-row h-full flex-1">
            <button
              class="bg-indigo-600 h-full px-5 rounded-lg text-sm focus:outline-none mr-4 text-white border-2 border-indigo-600 hover:bg-transparent hover:text-indigo-600 transition-colors duration-150 ease-in-out"
              @click="addNewReservation"
            >
              <i class="fas fa-calendar-plus mr-2"></i>
              {{ __('common.new_reservation') }}
            </button>

            <search-bar></search-bar>
            <div class="ml-4 flex items-center">
              <input
                id="past"
                name="candidates"
                type="checkbox"
                v-model="filter.past"
                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded mr-1"
              />
              <label for="past" class="text-gray-700 uppercase text-xs">{{ __('common.include_past') }}</label>
            </div>
          </div>

          <div class="flex flex-row h-full">
            <date-filter></date-filter>
          </div>
        </div>
      </div>

      <table class="table-auto w-full">
        <tr class="bg-gray-200 uppercase">
          <td class="text-xs font-medium text-gray-800 px-5 py-2">{{ __('common.name') }}</td>
          <td class="text-xs font-medium text-gray-800 px-5 py-2">{{ __('common.start') }}</td>
          <td class="text-xs font-medium text-gray-800 px-4 py-2">{{ __('common.duration') }}</td>
          <td class="text-xs font-medium text-gray-800 px-4 py-2">{{ __('common.tables') }}</td>
          <td class="text-xs font-medium text-gray-800 px-4 py-2">{{ __('common.guests') }}</td>
          <td class="text-xs font-medium text-gray-800 px-4 py-2">{{ __('common.email') }}</td>
          <td class="text-xs font-medium text-gray-800 px-4 py-2">{{ __('common.phone_number') }}</td>
          <td class="text-xs font-medium text-gray-800 px-4 py-2 flex flex-row center">
            <input
              v-model="filter.showFulfilled"
              name="fulfilled"
              type="checkbox"
              @click="handleShowAllFulfilled(!filter.showFulfilled)"
              class="focus:ring-indigo-500 mr-1 h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer"
            />
            {{ __('common.fulfilled') }}
          </td>
        </tr>

        <reservation-list-item
          v-for="reservation in reservations.items"
          :key="reservation.id"
          :reservation="reservation"
        ></reservation-list-item>

        <tr v-if="reservations.items.length === 0" class="border border-b border-gray-200 cursor-pointer">
          <td class="px-4 py-2 border-l-8 border-yellow-400">
            <div class="flex flex-col">
              <span class="text-gray-900 text-sm">{{ __('common.no_reservations') }}</span>
              <span class="text-gray-600 text-xs italic">{{ __('common.create_one') }}</span>
            </div>
          </td>
          <!-- fill -->
          <td v-for="n in 7" :key="n"></td>
        </tr>
      </table>

      <div class="w-full bg-gray-200 rounded-b-lg px-6 py-2">
        <Paginator></Paginator>
      </div>
    </div>

    <orgusto-modal-wrapper>
      <reservation-item> </reservation-item>
    </orgusto-modal-wrapper>
  </div>
</template>

<script>
import {mapState} from 'vuex';
import store from '../store';
import SearchReservationsBar from './SearchReservation';
import SearchBar from './Reservations/SearchBar';
import Paginator from './Reservations/Paginator';

export default {
  name: 'ReservationsList',
  components: {Paginator, SearchBar, SearchReservationsBar},
  store,
  data() {
    return {};
  },
  mounted() {
    this.$store.dispatch('loadUser');
  },
  methods: {
    addNewReservation() {
      this.$store.dispatch('createNewReservation');
    },
    handleShowAllFulfilled(val) {
      this.$store.dispatch('showAllFullFilled', val);
    },
  },
  computed: {
    ...mapState({
      user: state => state.user,
      reservations: state => state.reservations,
      filter: state => state.filter,
    }),
  },
  watch: {
    'filter.past': function() {
      this.$store.dispatch('loadPaginatedReservations');
    },
    user(updated, old) {
      if (updated) {
        this.$store.dispatch('loadPaginatedReservations');
        this.$store.dispatch('loadEmployees');
        this.$store.dispatch('loadRestaurant');
      }
    },
  },
};
</script>
