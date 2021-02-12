<template>
    <div class="relative shadow-lg bg-white mx-auto rounded-lg w-full max-w-5xl">
        <div class="bg-white w-full shadow-lg max-w-5xl self-center mt-6 overflow-hidden rounded-lg">
            <div
                class="orgusto-honey flex flex-row items-center justify-between p-4 py-5 sm:px-6 border-b-4"
                :class="borderColor"
            >
                <h3 class="text-lg self-center leading-6 font-medium text-gray-800">{{ reservation.name }}</h3>
                <color-switcher :color="reservation.color" v-on:value:changed="setValue"></color-switcher>
            </div>

            <employee-picker
                :error="errorContainsKey('user_id')"
                :user="reservation.user"
                v-on:value:changed="setValue"
            ></employee-picker>

            <hr/>
            <date-picker :error="errorContainsKey('start')" :date="reservation.start" v-on:value:changed="setValue"></date-picker>
            <time-picker :error="errorContainsKey('start')" :date="reservation.start" v-on:value:changed="setValue"></time-picker>
            <hr/>
            <person-picker
                :persons="reservation.persons"
                v-on:value:changed="setValue"
                :error="errorContainsKey('persons')"
            ></person-picker>
            <duration-picker
                :duration="reservation.duration"
                v-on:value:changed="setValue"
                :error="errorContainsKey('duration')"
            ></duration-picker>

            <hr/>

            <div class="flex p-4 pb-2 justify-between">
                <div v-if="errorContainsKey('name')"
                     class="text-red-400 flex items-center py-2 pr-4 leading-tight">
                    <i class="fas fa-times"></i>
                </div>

                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"
                    :class="reservation.name ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Name of the guest / group"
                    type="text"
                    v-model="reservation.name"
                />
            </div>

            <div class="flex px-4 py-2">
                <div v-if="errorContainsKey('notice')"
                     class="text-red-400 flex items-center p-2 px-4 leading-tight">
                    <i class="fas fa-times"></i>
                </div>
                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"
                    :class="reservation.notice ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Some additional information ..."
                    type="text"
                    v-model="reservation.notice"
                />
            </div>

            <div class="flex p-4 pt-2">
                <div v-if="errorContainsKey('email')"
                     class="text-red-400 flex items-center p-2 px-4 pl-0 leading-tight">
                    <i class="fas fa-times"></i>
                </div>
                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"
                    :class="reservation.email ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Email"
                    type="email"
                    v-model="reservation.email"

                />
                <div
                    v-if="errorContainsKey('phone_number')"
                    class="text-red-400 flex items-center py-2 pr-4 leading-tight"
                ><i class="fas fa-times"></i>
                </div>
                <!--suppress HtmlFormInputWithoutLabel -->
                <input
                    class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"
                    :class="reservation.phone_number ? 'border-indigo-400 text-gray-800' : ''"
                    placeholder="Phone number"
                    v-model="reservation.phone_number"
                />
            </div>
            <hr/>

            <table-picker
                :error="errorContainsKey('tables')"
                :selected-tables="reservation.tables"
                v-on:value:changed="setValue"
            ></table-picker>

            <hr/>

            <div class="flex justify-end p-4">
                <button @click="handleClose"
                        class="p-2 px-4 mr-4 rounded-lg bg-gray-400 text-gray-600 leading-tight text-sm hover:text-gray-800 hover:bg-gray-300 transition-colors duration-150 ease-in-out">
                    Cancel
                </button>
                <button v-if="reservation.id"
                        @click="handleDelete"
                        class="p-2 px-4 mr-4 rounded-lg bg-red-600 text-gray-100 leading-tight text-sm hover:text-red-600 hover:bg-white transition-colors duration-150 ease-in-out"
                >Delete
                </button>
                <button
                    @click="handleSubmit"
                    class="p-2 px-4 rounded-lg bg-indigo-600 border-2 border-indigo-600 leading-tight text-sm text-gray-100 hover:bg-white hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                >{{ this.reservation.id ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import store from '../store';
import {mapState} from 'vuex';

export default {
    name: "ReservationItem",
    store,
    data() {
        return {}
    },
    methods: {
        handleSubmit() {
            this.$store.dispatch('saveReservation', this.reservation);
        },
        errorContainsKey(key) {
            return Object.keys(this.errors).includes(key);
        },
        handleClose() {
            this.$store.dispatch('closeModal');
        },
        handleDelete() {

        },
        setValue(value) {
            const data = {
                id: this.reservation.id,
                data: value
            }
            this.$store.dispatch('updateReservation', data);
        }
    },
    computed: {
        borderColor() {
            return `border-${this.reservation.color}-400`;
        },
        ...mapState({
            reservation: state => {
                const reservation = state.reservations.items.find(reservation => reservation.id === state.modal.activeReservationId);
                if (reservation) {
                    return reservation;
                } else {
                    return state.modal.newReservation;
                }
            },
            errors: state => state.reservations.errors
        })
    },
}
</script>
