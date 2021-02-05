<template>
    <div class="flex flex-row items-center mr-10">
        <button @click="handleOpen" class="hover:bg-indigo-600 rounded-lg py-2 text-indigo-600 hover:text-white transition-colors duration-75 ease-in-out">
            <span class="px-4 flex flex-col justify-center ">
                <i class="text-lg fas fa-calendar-plus pointer-events-none"></i>
                <span class="text-xs pt-1 pointer-events-none font-semibold">New reservation</span>
            </span>
        </button>
        <orgusto-modal-wrapper :is-open="open" :handle-close="handleClose">
            <reservation-item
                v-on:modal:close="handleClose"
                :tables-endpoint="tablesEndpoint"
                :reservations-endpoint="reservationsEndpoint"
                :reset="true"
            ></reservation-item>
        </orgusto-modal-wrapper>
    </div>
</template>

<script>

export default {
    props: ["tablesEndpoint", "reservationsEndpoint"],
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
