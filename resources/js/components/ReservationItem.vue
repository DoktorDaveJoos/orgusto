<template>
    <div class="relative shadow-lg bg-white mx-auto rounded-lg w-full max-w-5xl">
        <div class="bg-white w-full shadow-lg max-w-5xl self-center mt-6 overflow-hidden rounded-lg">
            <div
                class="orgusto-honey flex flex-row items-center justify-between p-4 py-5 sm:px-6 border-b-4"
                :class="borderColor"
            >
                <h3 class="text-lg self-center leading-6 font-medium text-gray-800">{{ title }}</h3>
<!--                <color-switcher :set-color="setColor"></color-switcher>-->
            </div>

<!--            <employee-picker-->
<!--                :error="errorContainsKey('user_id')"-->
<!--                :init="reservationCopy.employees"-->
<!--                :employees="employees"-->
<!--                v-on:employee:chosen="setEmployee"-->
<!--            ></employee-picker>-->

<!--            <hr/>-->
<!--            <date-picker :init="reservationCopy.start"></date-picker>-->
<!--            <time-picker :init="reservationCopy.start" v-on:time:chosen="setTime"></time-picker>-->
<!--            <hr/>-->
<!--            <person-picker-->
<!--                :init="reservationCopy.persons"-->
<!--                :error="errorContainsKey('persons')"-->
<!--                v-on:person:chosen="setPersons"-->
<!--            ></person-picker>-->
<!--            <duration-picker-->
<!--                :init="reservationCopy.duration"-->
<!--                :error="errorContainsKey('duration')"-->
<!--                v-on:duration:chosen="setDuration"-->
<!--            ></duration-picker>-->

<!--            <hr/>-->

<!--            <div class="flex p-4 pb-2 justify-between">-->
<!--                <div-->
<!--                    v-if="errorContainsKey('name')"-->
<!--                    class="text-red-400 flex items-center py-2 pr-4 leading-tight"-->
<!--                >-->
<!--                    <i class="fas fa-times"></i>-->
<!--                </div>-->

<!--                <input-->
<!--                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"-->
<!--                    :class="reservationCopy.name ? 'border-indigo-400 text-gray-800' : ''"-->
<!--                    placeholder="Name of the guest / group"-->
<!--                    type="text"-->
<!--                    v-model="reservationCopy.name"-->
<!--                />-->
<!--                <select-button-->
<!--                    :handle="() => showAdditionalNotice = !showAdditionalNotice"-->
<!--                    :selected="() => showAdditionalNotice"-->
<!--                    icon="fas fa-sticky-note"-->
<!--                    value="notice"-->
<!--                ></select-button>-->
<!--            </div>-->

<!--            <div class="flex px-4 py-2" v-if="showAdditionalNotice">-->
<!--                <div-->
<!--                    v-if="errorContainsKey('notice')"-->
<!--                    class="text-red-400 flex items-center p-2 px-4 leading-tight"-->
<!--                >-->
<!--                    <i class="fas fa-times"></i>-->
<!--                </div>-->
<!--                <input-->
<!--                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"-->
<!--                    :class="reservationCopy.notice ? 'border-indigo-400 text-gray-800' : ''"-->
<!--                    placeholder="Some additional information ..."-->
<!--                    type="text"-->
<!--                    v-model="reservationCopy.notice"-->
<!--                />-->
<!--            </div>-->

<!--            <div class="flex p-4 pt-2">-->
<!--                <div-->
<!--                    v-if="errorContainsKey('email')"-->
<!--                    class="text-red-400 flex items-center p-2 px-4 pl-0 leading-tight"-->
<!--                >-->
<!--                    <i class="fas fa-times"></i>-->
<!--                </div>-->
<!--                <input-->
<!--                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"-->
<!--                    :class="reservationCopy.email ? 'border-indigo-400 text-gray-800' : ''"-->
<!--                    placeholder="Email"-->
<!--                    type="email"-->
<!--                    v-model="reservationCopy.email"-->
<!--                />-->
<!--                <div-->
<!--                    v-if="errorContainsKey('phone_number')"-->
<!--                    class="text-red-400 flex items-center py-2 pr-4 leading-tight"-->
<!--                >-->
<!--                    <i class="fas fa-times"></i>-->
<!--                </div>-->
<!--                <input-->
<!--                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"-->
<!--                    :class="reservationCopy.phone_number ? 'border-indigo-400 text-gray-800' : ''"-->
<!--                    placeholder="Phone number"-->
<!--                    type="phone"-->
<!--                    v-model="reservationCopy.phone_number"-->
<!--                />-->
<!--            </div>-->
<!--            <hr/>-->

            <table-picker
                :error="errorContainsKey('tables')"
                :tables-endpoint="tablesEndpoint"
                :filter-data="filterData"
                :init="reservationCopy.tables"
                v-on:tables:chosen="setTables"
            ></table-picker>

            <hr/>

            <div class="flex justify-end p-4">
                <button
                    @click="handleClose"
                    class="p-2 px-4 mr-4 rounded-lg bg-gray-400 text-gray-600 leading-tight text-sm hover:text-gray-800 hover:bg-gray-300 transition-colors duration-150 ease-in-out"
                >Cancel
                </button>
                <button
                    @click="handleSubmit"
                    class="p-2 px-4 rounded-lg bg-indigo-600 border-2 border-indigo-600 leading-tight text-sm text-gray-100 hover:bg-white hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                >{{ this.reservation ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import Vue from "vue";
import ReservationClass from "../models/Reservation";
import FilterClass, {Filter} from "../models/Filter";
import Tables from "../models/Tables";

export default Vue.extend({
    props: {
        reservation: Object,
        employees: Array,
        tablesEndpoint: String,
        reservationsEndpoint: String
    },
    data() {
        return {
            reservationCopy: ReservationClass.of(this.reservation),
            errors: {},
            endpoint: "",
            showAdditionalNotice: false
        };
    },
    methods: {
        setTables(tables: Tables): void {
            console.log(tables);
        },
        handleSubmit(): void {

            // axios
            //     .put(this.reservationsEndpoint, {})
            //     .then((res) => {
            //         if (res.status === 200) {
            //             location.reload();
            //         }
            //     })
            //     .catch((err) => {
            //         this.errors = err.response.data.errors;
            //     });

        },
        errorContainsKey(key): boolean {
            return Object.keys(this.errors).find((elem) => elem === key) !== undefined;
        },
        handleClose(): void {
            this.$emit("modal:close");
        },
    },
    computed: {
        title(): string {
            return this.reservation && this.reservation.name
                ? this.reservation.name
                : "New Reservation";
        },
        borderColor(): string {
            return "border-" + this.reservationCopy.color + "-400";
        },
        filterData(): Filter {
            return FilterClass.of(this.reservation);
        },
    },
});
</script>
