<template>
    <div class="py-2 text-center sticky top-0 mx-8 text-gray-600" style="z-index: 5;">
        <div class="w-full flex flex-row">
            <div class="w-1/6 border-r border-gray-500 font-light text-lg text-right">
                <span class="p-2">Hours</span>
            </div>
            <div
                class="w-1/6 border-r border-gray-500 font-light text-lg text-left"
                v-for="i in 5"
                :key="i"
            >
                <span class="p-1">{{ mapToHour(i - 1) }}</span>
            </div>
        </div>
        <div class="w-full flex flex-row">
            <div class="w-1/6 border-r border-gray-500 font-light text-sm text-right">
                <span class="p-2">Minutes</span>
            </div>
            <div class="w-1/6 flex flex-row" v-for="i in 5" :key="i">
                <div
                    class="w-1/4 border-r border-gray-500 font-light text-sm text-left"
                    v-for="j in 4"
                    :key="j"
                >
                    <span class="p-1">{{ mapToQuarter(j) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import store from '../store';
import {mapState} from 'vuex';
import {getHours} from 'date-fns';

export default {
    name: "orgusto-timeline",
    store,
    methods: {
        mapToQuarter: val => {
            return val === 1 ? "00" : val === 2 ? "15" : val === 3 ? "30" : "45";
        },
        mapToHour: function (val) {
            let hour = parseInt(val) + this.start;
            if (hour >= 24) {
                hour = hour - 24;
            }
            return hour;
        },
    },
    computed: {
        ...mapState({
           start: state => getHours(state.filter.timelineStart)
        }),
    }
};
</script>
