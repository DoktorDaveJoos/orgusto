<template>
    <div>
        <v-date-picker v-model="singleDate"
                       :popover="{ placement: 'bottom', visibility: 'click' }">
            <button
                class="bg-white mr-2 self-end border-2 border-gray-300 h-full px-5 rounded-lg text-sm focus:outline-none hover:border-indigo-600 text-gray-600 hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                role="menuitem"
                :class="singleDateIsActive ? 'border-indigo-600' : ''">
                <span class="mr-1">{{  }}</span>
                <i class="fas fa-calendar-day"></i>
            </button>
        </v-date-picker>
        <v-date-picker mode="range" v-model="dateRange"
                       :popover="{ placement: 'bottom', visibility: 'click' }">
            <button
                class="bg-white self-end border-2 border-gray-300 h-full px-5 rounded-lg text-sm focus:outline-none hover:border-indigo-600 text-gray-600 hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                role="menuitem"
                :class="dateRangeIsActive ? 'border-indigo-600' : ''">
                <span>Date range</span>
                <i class="fas fa-filter"></i>
            </button>
        </v-date-picker>
    </div>
</template>

<script>

import store from '../../store';

export default {
    name: "DateFilter",
    store,
    computed: {
        dateRange: {
            get() {
                return this.$store.state.filter.dateRange;
            },
            set(value) {
                this.$store.dispatch('activeDateFilter', {
                    mode: "range",
                    active: true,
                    dateRange: value
                });
            }
        },
        singleDate: {
            get() {
              return this.$store.state.filter.dateRange.start;
            },
            set(value) {
                this.$store.dispatch('activeDateFilter', {
                    mode: "single",
                    active: true,
                    dateRange: {
                        start: value,
                        end: new Date()
                    }
                });
            }
        },
        singleDateIsActive() {
            const {active, mode} =  this.$store.state.filter.dateFilter
            console.log(active, mode);
            return active && mode === "single";
        },
        dateRangeIsActive() {
            const {active, mode} =  this.$store.state.filter.dateFilter
            return active && mode === "range";
        },
    }
}
</script>

<style scoped>

</style>
