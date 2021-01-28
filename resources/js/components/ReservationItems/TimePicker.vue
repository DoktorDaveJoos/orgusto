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
                :time="time"
                :set-single-time="setTime"
            ></single-time-picker>
        </div>
    </div>
</template>

<script lang="ts">

import Vue from 'vue';
import DateString from "../../models/DateString";

export default Vue.extend({
    props: {
        init: DateString,
        error: String
    },
    data() {
        return {
            hour: this.init.asMoment().get('hour'),
            minute: this.init.asMoment().get('minute'),
            time: this.init,
            singleTimePickerActive: false
        };
    },
    mounted() {
        this.singleTimePickerActive = this.hour < 17 || this.hour > 20;
    },
    methods: {
        setHour(hour: number): void {
            this.hour = hour;
        },
        setMinute(minute: number): void {
            if (!this.singleTimePickerActive) this.minute = minute;
        },
        setTime(time: DateString): void {
            this.hour = time.asMoment().get('hour');
            this.minute = time.asMoment().get('minute');
        },
        setSingleTimeState(): void {
            this.singleTimePickerActive = this.hour < 17 || this.hour > 20;
            this.time = DateString.ofAny(this.time.asMoment().set('hour', this.hour).set('minute', this.minute));
            this.$emit("time:chosen", this.time);
        },
        getButtonClass(minute: number): string {
            if (this.singleTimePickerActive) {
                return "opacity-50 cursor-not-allowed hover:shadow-none";
            }
            return this.minute === minute ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : '';
        }
    },
    watch: {
        hour: 'setSingleTimeState',
        minute: 'setSingleTimeState',
        init(n: DateString, o: DateString) {
            this.hour = n.asMoment().get('hour');
            this.minute = n.asMoment().get('minute');
            this.singleTimePickerActive = this.hour < 17 || this.hour > 20;
        }
    }
});
</script>

<style>
</style>
