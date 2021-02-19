<template>
    <div class="flex flex-col px-4 pt-2 pb-4">
        <div class="flex justify-between">
            <div class="flex space-x-4">
                <div v-if="error" class="text-red-400 flex items-center leading-tight">
                    <i class="fas fa-times"></i>
                </div>
                <select-button
                    v-for="d in preselectedDurations"
                    :key="d"
                    :selected="() => thisDurationEquals(d)"
                    :handle="() => setDuration(d)"
                    :value="getReadableDuration(d)"
                ></select-button>
            </div>

            <popper trigger="clickToOpen" :options="{placement: 'bottom-start'}">
                <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
                    <div class="flex justify-center mb-1">
            <span
                class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
            >{{ __('common.duration') }}</span>
                    </div>
                    <hr/>
                    <div class="flex flex-col text-gray-800 p-1">
                        <span
                            v-for="m in moreChoices"
                            v-bind:key="m"
                            @click="setDuration(m)"
                            class="flex-1 px-3 py-1 mt-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
                            :class="thisDurationEquals(m) ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
                        >{{ getReadableDuration(m) }}</span>
                    </div>
                </div>

                <select-button
                    slot="reference"
                    :selected="() => moreIsActive"
                    :value="moreIsActive ? getReadableDuration(this.duration) : __('common.more')"
                    icon="fas fa-stopwatch"
                ></select-button>
            </popper>
        </div>
    </div>
</template>

<script>
import Popper from "vue-popperjs";

export default {
    name: "DurationPicker",
    components: {
        popper: Popper,
    },
    props: ["duration", "error"],
    data() {
        // TODO: make it adjustable
        return {
            preselectedDurations: [
                60,
                90,
                120,
                150,
                180,
                240
            ],
            moreChoices: [
                210,
                270,
                480,
                720
            ],
        };
    },
    methods: {
        getReadableDuration(minutes) {

            const hours = Math.floor(minutes / 60);
            let minute = minutes % 60;
            minute = minute < 15 ? `0${minute}` : minute;

            return `${hours}:${minute}h`;

        },
        setDuration(duration) {
            this.$emit("value:changed", {duration: duration});
        },
        thisDurationEquals(duration) {
            return this.duration === duration;
        },
    },
    computed: {
        moreIsActive() {
            return this.moreChoices.find(duration => this.duration === duration) !== undefined;
        },
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
