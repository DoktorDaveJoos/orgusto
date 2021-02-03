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
            class="ml-4 text-red-600 hover:bg-red-600 hover:text-white rounded-full leading-tight text-xs px-2 h-8">
            <i class="far fa-trash-alt mr-1"></i>Delete
        </button>
    </div>
</template>

<script>
export default {
    props: ["tablesEndpoint", "reservationsEndpoint", "reservation"],
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
        }
    }
};
</script>

<style>
</style>
