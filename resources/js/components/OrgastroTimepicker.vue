<template>
    <v-date-picker v-model="computedDate" :input-props="inputProps" :update-on-input="false"></v-date-picker>
</template>

<script>
import store from '../store';
import {setHours, setMinutes, getHours, getMinutes} from 'date-fns';

export default {
    name: "orgusto-timepicker",
    store,
    data() {
        return {
            inputProps: {
                class:
                    "text-gray-600 shadow-lg rounded-full bg-gray-200 p-2 text-center w-full cursor-pointer self-center hover:text-gray-800 transition-color duration-200 ease-in-out"
            },
        };
    },
    computed: {
        computedDate: {
            get() {
                return this.$store.state.filter.timelineStart;
            },
            set(val) {
                const hours = getHours(this.computedDate);
                const minutes = getMinutes(this.computedDate);

                const newScope = setHours(setMinutes(val, minutes), hours);
                this.$store.commit('updateScope', newScope)
            }
        }
    },
};
</script>
