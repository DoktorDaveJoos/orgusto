<template>
    <div class="relative shadow-lg bg-white mx-auto rounded-lg w-full max-w-5xl">
        <div class="bg-white w-full shadow-lg max-w-5xl self-center mt-6 overflow-hidden rounded-lg">
            <div
                class="orgusto-honey flex flex-row items-center justify-between p-4 py-5 sm:px-6 border-b-4"
                :class="borderColor"
            >
                <h3 class="text-lg self-center leading-6 font-medium text-gray-800">{{ title }}</h3>
                <color-switcher :set-color="setColor"></color-switcher>
            </div>

            <div v-if="customError" class="bg-red-100 text-red-600 text-xs text-italic p-4 my-2 mx-4 rounded-lg">
                {{ customError }}
            </div>

            <employee-picker
                :error="errorContainsKey('user_id')"
                :init="reservationCopy.user"
                v-on:employee:chosen="setEmployee"
            ></employee-picker>

            <hr/>
            <date-picker :init="getInitTime()" v-on:date:chosen="setDate"></date-picker>
            <time-picker :init="reservationCopy.start" v-on:time:chosen="setTime"></time-picker>
            <hr/>
            <person-picker
                :init="reservationCopy.persons"
                :error="errorContainsKey('persons')"
                v-on:person:chosen="setPersons"
            ></person-picker>
            <duration-picker
                :init="reservationCopy.duration"
                :error="errorContainsKey('duration')"
                v-on:duration:chosen="setDuration"
            ></duration-picker>

            <hr/>

            <div class="flex p-4 pb-2 justify-between">
                <div
                    v-if="errorContainsKey('name')"
                    class="text-red-400 flex items-center py-2 pr-4 leading-tight"
                >
                    <i class="fas fa-times"></i>
                </div>

                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"
                    :class="reservationCopy.name ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Name of the guest / group"
                    type="text"
                    v-model="reservationCopy.name"
                />
                <select-button
                    :handle="() => showAdditionalNotice = !showAdditionalNotice"
                    :selected="() => showAdditionalNotice"
                    icon="fas fa-sticky-note"
                    value="notice"
                ></select-button>
            </div>

            <div class="flex px-4 py-2" v-if="showAdditionalNotice">
                <div
                    v-if="errorContainsKey('notice')"
                    class="text-red-400 flex items-center p-2 px-4 leading-tight"
                >
                    <i class="fas fa-times"></i>
                </div>
                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"
                    :class="reservationCopy.notice ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Some additional information ..."
                    type="text"
                    v-model="reservationCopy.notice"
                />
            </div>

            <div class="flex p-4 pt-2">
                <div
                    v-if="errorContainsKey('email')"
                    class="text-red-400 flex items-center p-2 px-4 pl-0 leading-tight"
                >
                    <i class="fas fa-times"></i>
                </div>
                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"
                    :class="reservationCopy.email ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Email"
                    type="email"
                    v-model="reservationCopy.email"
                />
                <div
                    v-if="errorContainsKey('phone_number')"
                    class="text-red-400 flex items-center py-2 pr-4 leading-tight"
                ><i class="fas fa-times"></i>
                </div>
                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"
                    :class="reservationCopy.phone_number ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Phone number"
                    v-model="reservationCopy.phone_number"
                />
            </div>
            <hr/>

            <table-picker
                :error="errorContainsKey('tables')"
                :tables-endpoint="tablesEndpoint"
                :filter-data="filterData"
                :init="tables"
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

import Vue, {PropType} from "vue";
import axios from 'axios';
import Reservation from "../models/Reservation";
import Employee from "../models/Employee";
import Filter from "../models/Filter";
import Tables from "../models/Tables";
import OrgustoDate from "../models/OrgustoDate";
import Duration from "../models/Duration";
import CreateOrUpdateReservation from "../requests/CreateOrUpdateReservation";
import Table from "../models/Table";

export default Vue.extend({
    props: {
        table: Object,
        reservation: Object,
        tablesEndpoint: String,
        reservationsEndpoint: String,
        time: Object as PropType<OrgustoDate>
    },
    data() {
        return {
            reservationCopy: Reservation.ofOrEmpty(this.reservation),
            tables: Tables.empty(),
            errors: {},
            customError: null,
            endpoint: "",
            showAdditionalNotice: false,
            filterData: Filter.of(Reservation.ofOrEmpty(this.reservation))
        }
    },
    mounted() {
        if (this.reservationCopy.notice) {
            this.showAdditionalNotice = true;
        }
        if (this.time) {
            this.reservationCopy.start = this.time;
        }
        if (this.reservation?.tables) {
            this.tables = Tables.of(this.reservation.tables);
        } else if (this.table) {
            this.tables = Tables.of(this.table);
        }
    },
    methods: {
        setTables(tables: Tables): void {
            this.reservationCopy.tables = tables;
        },
        setColor(color: string): void {
            this.reservationCopy.color = color;
        },
        setDate(date: OrgustoDate): void {
            this.reservationCopy.start = date.setTimeOnly(this.reservationCopy.start.asDate);
            this.filterData = Filter.of(this.reservationCopy);
        },
        setTime(date: OrgustoDate): void {
            this.reservationCopy.start = date;
            this.filterData = Filter.of(this.reservationCopy);
        },
        setPersons(persons: number): void {
            this.reservationCopy.persons = persons;
            this.filterData = Filter.of(this.reservationCopy);
        },
        setDuration(duration: Duration): void {
            this.reservationCopy.duration = duration;
            this.filterData = Filter.of(this.reservationCopy);
        },
        setEmployee(employee: Employee): void {
            this.reservationCopy.user = employee;
        },
        getInitTime() {
          return this.reservationCopy.start ? this.reservationCopy.start : OrgustoDate.default();
        },
        handleSubmit() {
            const request: CreateOrUpdateReservation = new CreateOrUpdateReservation(this.reservationCopy);
            const _axios = this.reservation ? axios.put : axios.post;

            _axios(this.reservationsEndpoint, request.asJsonPayload())
                .then(() => location.reload())
                .catch(err => {
                    if (err.response.status !== 422) {
                        this.customError = err.response.data.message;
                    } else {
                        this.errors = err.response.data.errors;
                    }
                });
        },
        errorContainsKey(key): boolean {
            return Object.keys(this.errors).includes(key);
        },
        handleClose(): void {
            this.clearReservationItem();
            this.$emit("modal:close");
        },
        clearReservationItem(): void {
            this.customError = null;
            this.errors = {};
            this.reservationCopy = Reservation.empty();
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
    },
    watch: {
        time(n: OrgustoDate, o: OrgustoDate): void {
            this.reservationCopy.start = n;
        },
        reservation(n: Reservation, o: Reservation) {
            this.filterData = Filter.of(Reservation.ofOrEmpty(n));
            if (n) {
                this.reservationCopy = n;
            }
            if (n?.tables) {
                this.tables = Tables.of(n.tables);
            }
        },
        table(n: Table, o: Table) {
            if(n) {
                this.tables = Tables.of(n);
            }
        },
    }
});
</script>
