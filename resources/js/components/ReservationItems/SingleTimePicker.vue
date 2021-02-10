<template>
    <popper trigger="clickToOpen" :options="{
      placement: 'bottom-start'
    }">
        <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
            <div>
                <div class="flex justify-center mb-1">
                    <span
                        class="text-center text-xs text-gray-500 uppercase font-light leading-tight">Chosen time</span>
                </div>
                <div class="flex justify-around mb-2">
                    <span class="text-lg text-gray-800 font-semibold">{{ addZeros(hour) }}</span>
                    <span class="text-lg text-gray-800 font-semibold">:</span>
                    <span class="text-lg text-gray-800 font-semibold">{{ addZeros(minute) }}</span>
                </div>
                <hr/>
                <div class="flex">
                    <div class="flex flex-col overflow-y-scroll h-64 items-center text-gray-800 text-sm p-2">
                    <span class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
                          :class="hour === b ? 'bg-blue-600 text-white' : ''"
                          v-for="(_ , b) in 24"
                          v-bind:key="b"
                          @click="setHour(b)"
                    >{{ addZeros(b) }}</span>
                    </div>
                    <div class="flex flex-col h-64 items-center text-gray-800 text-sm p-2">
                        <span
                            class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
                            :class="minute === 0 ? 'bg-blue-600 text-white' : ''"
                            @click="setMinutes(0)"
                        >00</span>
                        <span
                            class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
                            :class="minute === 15 ? 'bg-blue-600 text-white' : ''"
                            @click="setMinutes(15)"
                        >15</span>
                        <span
                            class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
                            :class="minute === 30 ? 'bg-blue-600 text-white' : ''"
                            @click="setMinutes(30)"
                        >30</span>
                        <span
                            class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
                            :class="minute === 45 ? 'bg-blue-600 text-white' : ''"
                            @click="setMinutes(45)"
                        >45</span>
                    </div>
                </div>
            </div>
        </div>

        <select-button
            slot="reference"
            :selected="() => active"
            :value="active ? addZeros(hour) + ':' + addZeros(minute) : 'Choose time'"
            icon="fas fa-clock"
        ></select-button>
    </popper>
</template>

<script>

import {getHours, getMinutes, setHours, setMinutes, parseISO} from 'date-fns';
import Popper from "vue-popperjs";

export default {
    components: {
        popper: Popper
    },
    props: ["active", "setSingleTime", "date"],
    data() {
        return {}
    },
    methods: {
        setHour(hour) {
            const newDate = setHours(parseISO(this.date), hour);
            this.setSingleTime(newDate);
        },
        setMinutes(minute) {
            const newDate = setMinutes(parseISO(this.date), minute);
            this.setSingleTime(newDate);
        },
        addZeros(val) {
            const tmp = val.toString();
            return tmp.length < 2 ? '0' + tmp : tmp;
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

<!--suppress CssUnusedSymbol -->
<style>
.popper .popper__arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
}

.popper[x-placement^="bottom"] {
    margin-top: 10px;
}

.popper[x-placement^="bottom"] .popper__arrow {
    top: 0;
    left: 20px !important;
    margin-top: 0;
    content: "";
    position: absolute;
    display: block;
    width: 12px;
    height: 12px;
    border-top: inherit;
    border-left: inherit;
    background: inherit;
    z-index: -1;
    transform: translateY(-50%) rotate(45deg);
}
</style>
