<template>
    <div class="flex flex-row items-center">
        <button @click="handleOpen"
                class="text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-full leading-tight text-xs px-2 h-8">
            <i class="far fa-edit mr-1"></i>Edit
        </button>
        <orgusto-modal-wrapper :is-open="open" :handle-close="handleClose">
            <reservation-item
                v-on:modal:close="handleClose"
                :reservation="reservation"
                :tables-endpoint="tablesEndpoint"
                :reservations-endpoint="reservationsEndpoint"
            ></reservation-item>
        </orgusto-modal-wrapper>

        <button
            v-if="reservation.done === 0"
            @click="handleDone"
            class="ml-4 text-green-600 hover:bg-green-600 hover:text-white rounded-full leading-tight text-xs px-2 h-8">
            <i class="fas fa-check mr-1"></i>Mark fulfilled
        </button>

        <button
            v-if="reservation.done === 1"
            @click="handleDone"
            class="ml-4 text-blue-400 hover:bg-blue-600 hover:text-white rounded-full leading-tight text-xs px-2 h-8">
            <i class="fas fa-redo mr-1"></i>Reactivate
        </button>

        <button
            @click="handleDelete"
            class="ml-4 text-red-600 hover:bg-red-600 hover:text-white rounded-full leading-tight text-xs px-2 h-8">
            <i class="far fa-trash-alt mr-1"></i>Delete
        </button>
    </div>
</template>

<script>

import axios from 'axios';

export default {
    props: ["tablesEndpoint", "reservationsEndpoint", "reservation", "deleteReservationsEndpoint"],
    data() {
        return {
            open: false
        };
    },
    methods: {
        handleOpen() {
            this.open = true;
        },
        handleClose() {
            this.open = false;
        },
        handleDelete() {
            axios.delete(this.deleteReservationsEndpoint)
                .then(() => location.reload())
                .catch(err => console.log(err));
        },
        handleDone() {
            axios.put(this.reservationsEndpoint + '/fulfilled')
                .then(() => location.reload());
        }
    }
};
</script>

<style>
</style>
