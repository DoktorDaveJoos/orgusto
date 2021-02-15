<template>

    <div class="w-full flex justify-center">

        <div class="bg-white w-full shadow-lg max-w-7xl self-center mt-6 mx-6 overflow-hidden rounded-lg">

            <div class="bg-gray-200 justify-between px-6">

                <div class="flex flex-row justify-between py-4">
                    <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
                        Reservations
                    </h3>
                </div>

                <div class="flex flex-row pb-4 h-14 bg-gray-200 justify-between">

                    <div class="flex flex-row h-full flex-1">

                        <button
                            class="bg-indigo-600 h-full px-5 rounded-lg text-sm focus:outline-none mr-4 text-white border-2 border-indigo-600 hover:bg-transparent hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                            @click="addNewReservation">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            New Reservation
                        </button>

                        <search-bar></search-bar>
                        <div class="ml-2 flex items-center">
                            <input id="past" name="candidates" type="checkbox" v-model="filter.past"
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded mr-1">
                            <label for="past" class="text-gray-700 uppercase text-xs">Include past</label>
                        </div>
                    </div>

                    <div class="flex flex-row h-full">
                        <date-filter></date-filter>
                    </div>

                </div>
            </div>

            <table class="table-auto w-full">
                <tr class="bg-gray-200 uppercase">

                    <td class="text-xs font-medium text-gray-800 px-5 py-2">Name</td>
                    <td class="text-xs font-medium text-gray-800 px-5 py-2">Start</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Duration</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Tables</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Persons</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Email</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Phone number</td>
                    <th class="text-xs font-medium text-gray-800 px-4 py-2 flex flex-row center">
                        <input v-model="filter.showFulfilled" name="fulfilled" type="checkbox"
                               @click="handleShowAllFulfilled(!filter.showFulfilled)"
                               class="focus:ring-indigo-500 mr-1 h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer">
                        Fulfilled
                    </th>

                </tr>

                <reservation-list-item
                    v-for="reservation in reservations.items"
                    :key="reservation.id"
                    :reservation="reservation"
                ></reservation-list-item>

                <tr v-if="reservations.items.length === 0" class="border border-b border-gray-200 cursor-pointer">
                    <td class="px-4 py-2 border-l-8 border-yellow-400">
                        <div class="flex flex-col">
                            <span class="text-gray-900 text-sm">No reservations so far.</span>
                            <span class="text-gray-600 text-xs italic">Create one :-)</span>
                        </div>
                    </td>
                </tr>

            </table>

            <div class="w-full bg-gray-200 rounded-b-lg px-2 py-2">

                <Paginator></Paginator>

            </div>

        </div>

        <orgusto-modal-wrapper>
            <reservation-item>
            </reservation-item>
        </orgusto-modal-wrapper>


    </div>

</template>

<script>
import {mapState} from 'vuex';
import store from '../store';
import SearchReservationsBar from "./SearchReservation";
import SearchBar from "./ReservationsView/SearchBar";
import Paginator from "./ReservationsView/Paginator";

export default {
    name: "ReservationsList",
    components: {Paginator, SearchBar, SearchReservationsBar},
    store,
    data() {
        return {}
    },
    mounted() {
        this.$store.dispatch('loadPaginatedReservations');
        this.$store.dispatch('loadEmployees');
        this.$store.dispatch('loadRestaurant');
    },
    methods: {
        addNewReservation() {
            this.$store.dispatch('createNewReservation');
        },
        handleShowAllFulfilled(val) {
            this.$store.dispatch('showAllFullFilled', val);
        }
    },
    computed: mapState({
        reservations: state => state.reservations,
        filter: state => state.filter
    }),
    watch: {
        'filter.past': function() {
            this.$store.dispatch('loadPaginatedReservations')
        }
    }
}

</script>

