<template>
  <button
    class="text-gray-600 hover:text-indigo-600 border-2 border-gray-400 shadow-lg bg-gray-200 hover:border-indigo-400 w-1/12 h-full rounded-full focus:outline-none transition-color duration-200 ease-in-out"
    v-on:click="handleClick()"
  >
    <i :class="iconClass"></i>
  </button>
</template>

<script>
import store from '../../store';
import {mapState} from 'vuex';
import {addHours, subHours} from 'date-fns';

export default {
  name: 'orgusto-scope-button',
  store,
  props: {
    direction: {
      type: String,
      required: true,
    },
  },
  methods: {
    handleClick: function() {
      if (this.direction === 'left') {
        const newScope = subHours(this.timelineStart, 1);
        this.$store.dispatch('updateScope', newScope);
      } else {
        const newScope = addHours(this.timelineStart, 1);
        this.$store.dispatch('updateScope', newScope);
      }
    },
  },
  computed: {
    iconClass: function() {
      return 'fas fa-chevron-' + this.direction;
    },
    ...mapState({
      timelineStart: state => state.filter.timelineStart,
    }),
  },
};
</script>
