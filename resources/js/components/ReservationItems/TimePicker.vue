<template>
    <div class="p-4 pt-2 flex justify-between">
        <div class="flex flex-row">
            <div v-if="error" class="text-red-400 flex items-center leading-tight">
                <i class="fas fa-times"></i>
            </div>
            <button
                class="h-10 text-sm rounded-l-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                :class="hour === 17 ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                @click="setHour(17)"
            >17
            </button>
            <button
                class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                :class="hour === 18 ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                @click="setHour(18)"
            >18
            </button>
            <button
                class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                :class="hour === 19 ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                @click="setHour(19)"
            >19
            </button>
            <button
                class="h-10 text-sm rounded-r-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg mr-4"
                :class="hour === 20 ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                @click="setHour(20)"
            >20
            </button>

            <div class="flex flex-row items-center text-gray-800 mr-4">:</div>

            <button
                class="h-10 text-sm rounded-l-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                :class="getButtonClass(0)"
                @click="setMinute(0)"
            >00
            </button>
            <button
                class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                :class="getButtonClass(15)"
                @click="setMinute(15)"
            >15
            </button>
            <button
                class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                :class="getButtonClass(30)"
                @click="setMinute(30)"
            >30
            </button>
            <button
                class="h-10 text-sm rounded-r-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg mr-4"
                :class="getButtonClass(45)"
                @click="setMinute(45)"
            >45
            </button>
        </div>
        <div>
            <single-time-picker
                :active="singleTimePickerActive"
                :date="date"
                :set-single-time="setTime"
            ></single-time-picker>
        </div>
    </div>
</template>

<script >

import {getHours, getMinutes, setHours, setMinutes, parseISO} from 'date-fns';

export default {
    name: "TimePicker",
    props: ["date"],
    data() {
        return {
            copiedDate: parseISO(this.date),
            error: false,
            singleTimePickerActive: getHours(parseISO(this.date)) < 17 || getHours(parseISO(this.date)) > 20,
        }
    },
    methods: {
        setHour(hour) {
            const newDate = setHours(parseISO(this.date), hour);
            console.log(newDate);
            this.$emit("value:changed", {start: newDate.toISOString()});
        },
        setMinute(minute){
            const newDate = setMinutes(parseISO(this.date), minute);
            this.$emit("value:changed", {start: newDate.toISOString()});
        },
        setTime(date) {
            this.$emit("value:changed", {start: date.toISOString()});
        },
        getButtonClass(minute){
            if (this.singleTimePickerActive) {
                return "opacity-50 cursor-not-allowed hover:shadow-none";
            }
            return this.minute === minute ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : '';
        }
    },
    computed: {
        hour: function() {
            return getHours(parseISO(this.date));
        },
        minute: function() {
            return getMinutes(parseISO(this.date));
        }
    }
}
</script>

<style>
</style>
