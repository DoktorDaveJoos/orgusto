<template>

    <div class="w-full flex justify-center">

        <div class="bg-white w-full shadow-lg max-w-7xl self-center mt-6 overflow-hidden rounded-lg sm:mx-6">
            <div class="orgusto-honey flex flex-row content-center justify-between px-4 py-4 sm:px-6">
                <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
                    Reservations
                </h3>
            </div>

            <table class="table-auto w-full">
                <tr class="bg-gray-200 uppercase">

                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Name</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Start</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Duration</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Tables</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Persons</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Email</td>
                    <td class="text-xs font-medium text-gray-800 px-4 py-2">Phone number</td>
                    <th class="text-xs font-medium text-gray-800 px-4 py-2">Fulfilled</th>
                    <td></td>
                    <td></td>

                </tr>

                <reservation-list-item
                    v-for="reservation in reservations.items"
                    :key="reservation.id"
                    :reservation="reservation"
                ></reservation-list-item>

            </table>
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

export default {
    name: "ReservationsList",
    store,
    data() {
        return {}
    },
    mounted() {
        this.$store.dispatch('loadPaginatedReservations');
        this.$store.dispatch('loadEmployees');
    },
    computed: mapState({
        reservations: state => state.reservations
    })
}

</script>

