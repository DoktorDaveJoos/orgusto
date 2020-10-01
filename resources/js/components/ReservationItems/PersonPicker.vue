<template>
    <div class="flex flex-col px-4 pb-2 pt-4">
    <span
        class="uppercase font-medium text-xs text-gray-800 leading-tight mb-1"
    >Number of people & duration</span>
        <div class="flex justify-between">
            <div class="flex space-x-4">
                <div v-if="error" class="text-red-400 flex items-center leading-tight">
                    <i class="fas fa-times"></i>
                </div>
                <select-button
                    v-for="a in 6"
                    :key="a"
                    :value="a"
                    :handle="setPerson"
                    :selected="() => persons === a"
                ></select-button>
            </div>

            <popper trigger="clickToOpen" :options="{placement: 'bottom-start'}">
                <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
                    <div class="flex justify-center mb-1">
            <span
                class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
            >Persons</span>
                    </div>
                    <hr/>
                    <div class="flex flex-wrap w-32 p-1 text-gray-800">
            <span
                class="flex-1 px-3 py-1 mt-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
                :class="persons === (a + 6).toString() ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
                v-for="a in 15"
                v-bind:key="a"
                @click="setPerson(a + 6)"
            >{{ a + 6 }}</span>
                    </div>
                </div>

                <select-button
                    slot="reference"
                    :selected="() => moreIsActive"
                    :value=" moreIsActive ? persons : 'More'"
                    icon="fas fa-user-friends"
                ></select-button>
            </popper>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";

// noinspection TypeScriptCheckImport
import Popper from "vue-popperjs";

export default Vue.extend({
    components: {
        popper: Popper
    },
    props: {
        init: Number,
        error: Boolean
    },
    data() {
        return {
            persons: this.init,
        };
    },
    methods: {
        setPerson(persons: number): void {
            this.persons = persons;
        },
    },
    computed: {
        moreIsActive(): boolean {
            return this.persons > 6;
        }
    },
    watch: {
        persons: function () {
            this.$emit('person:chosen', this.persons)
        }
    }
});
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
