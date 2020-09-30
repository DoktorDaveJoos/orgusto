<template>
    <div class="flex flex-col px-4 pt-2 pb-4">
        <div class="flex justify-between">
            <div class="flex space-x-4">
                <div v-if="error" class="text-red-400 flex items-center leading-tight">
                    <i class="fas fa-times"></i>
                </div>
                <select-button
                    v-for="d in preselectedDurations"
                    v-bind:key="d.print()"
                    :key="d.print()"
                    :selected="() => thisDurationEquals(d)"
                    :handle="() => setDuration(d)"
                    :value="d.print()"
                ></select-button>
            </div>

            <popper trigger="clickToOpen" :options="{placement: 'bottom-start'}">
                <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
                    <div class="flex justify-center mb-1">
            <span
                class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
            >Duration</span>
                    </div>
                    <hr/>
                    <div class="flex flex-col text-gray-800">
            <span
                v-for="m in moreChoices"
                v-bind:key="m.print()"
                @click="setDuration(m)"
                class="flex-1 px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
                :class="thisDurationEquals(m) ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
            >{{ m.print() }}</span>
                    </div>
                </div>

                <select-button
                    slot="reference"
                    :selected="() => moreIsActive"
                    :value="moreIsActive ? duration.print() : 'More'"
                    icon="fas fa-stopwatch"
                ></select-button>
            </popper>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Popper from "vue-popperjs";
import DurationClass from "../../models/Duration";

export default Vue.extend({
    components: {
        popper: Popper,
    },
    props: {
        init: DurationClass,
        error: Boolean
    },
    data() {
        return {
            preselectedDurations: [
                DurationClass.of(1, 0),
                DurationClass.of(1, 30),
                DurationClass.of(2, 0),
                DurationClass.of(2, 30),
                DurationClass.of(3, 0),
                DurationClass.of(4, 0)
            ],
            moreChoices: [
                DurationClass.of(3, 30),
                DurationClass.of(4, 30),
                DurationClass.of(8, 0),
                DurationClass.of(12, 0)
            ],
            duration: this.init,
        };
    },
    methods: {
        setDuration(duration: DurationClass): void {
            this.duration = duration;
        },
        thisDurationEquals(duration: DurationClass): boolean {
            return this.duration.equals(duration);
        },
    },
    computed: {
        moreIsActive(): boolean {
            return this.moreChoices.find((elem) => this.duration.equals(elem)) !== undefined;
        },
    },
    watch: {
        duration: function () {
            this.$emit("duration:chosen", this.duration);
        }
    }
});
</script>

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
