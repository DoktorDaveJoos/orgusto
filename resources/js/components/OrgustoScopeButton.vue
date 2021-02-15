<template>
    <button
        class="text-gray-600 shadow-lg bg-gray-200 hover:bg-gray-300 w-1/12 h-full rounded-full focus:outline-none"
        v-on:click="handleClick()"
    >
        <i :class="iconClass"></i>
    </button>
</template>

<script>

import store from '../store';
import {mapState} from 'vuex';
import {addHours, subHours} from 'date-fns';

export default {
    name: "orgusto-scope-button",
    store,
    props: {
        direction: {
            type: String,
            required: true
        }
    },
    methods: {
        handleClick: function () {
            if (this.direction === "left") {
                const newScope = subHours(this.timelineStart, 1);
                this.$store.commit('updateScope', newScope);
            } else {
                const newScope = addHours(this.timelineStart, 1);
                this.$store.commit('updateScope', newScope);
            }
        }
    },
    computed: {
        iconClass: function () {
            return "fas fa-chevron-" + this.direction;
        },
        ...mapState({
            timelineStart: state => state.filter.timelineStart
        })
    }
};
</script>
