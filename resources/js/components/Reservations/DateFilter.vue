<template>
  <div>
    <v-date-picker v-model="singleDate" :update-on-input="false" :popover="{placement: 'bottom', visibility: 'click'}">
      <button
        class="bg-white mr-2 self-end border-2 border-gray-300 h-full px-5 rounded-lg text-sm focus:outline-none text-gray-600 hover:text-indigo-600 transition-colors duration-150 ease-in-out"
        role="menuitem"
        :class="
          singleDateIsActive ? 'border-indigo-400 text-indigo-600 hover:border-red-600' : 'hover:border-indigo-200'
        "
      >
        <span class="mr-1">{{ singleDateIsActive ? singleDate.toLocaleDateString() : __('common.Date') }}</span>
        <i v-if="!singleDateIsActive" class="fas fa-calendar-day"></i>
        <i v-else @click="handleRemove('single')" class="fas fa-times-circle hover:text-red-600"></i>
      </button>
    </v-date-picker>
    <v-date-picker
      mode="range"
      v-model="dateRange"
      :update-on-input="false"
      :popover="{placement: 'bottom', visibility: 'click'}"
    >
      <button
        class="bg-white self-end border-2 border-gray-300 h-full px-5 rounded-lg text-sm focus:outline-none text-gray-600 hover:text-indigo-600 transition-colors duration-150 ease-in-out"
        role="menuitem"
        :class="
          dateRangeIsActive ? 'border-indigo-400 text-indigo-600 hover:border-red-600' : 'hover:border-indigo-200'
        "
      >
        <span class="mr-1">{{
          dateRangeIsActive
            ? dateRange.start.toLocaleDateString() + ' - ' + dateRange.end.toLocaleDateString()
            : __('common.Date_range')
        }}</span>
        <i v-if="!dateRangeIsActive" class="fas fa-filter"></i>
        <i v-else @click="handleRemove('range')" class="fas fa-times-circle hover:text-red-600"></i>
      </button>
    </v-date-picker>
  </div>
</template>

<script>
import store from '../../store';

export default {
  name: 'DateFilter',
  store,
  methods: {
    handleRemove(indicator) {
      if (indicator === 'single') {
        this.$store.dispatch('activateSingleDateFilter', {
          mode: 'none',
          active: false,
          singleDate: this.singleDate,
        });
      } else {
        this.$store.dispatch('activateRangeFilter', {
          mode: 'none',
          active: false,
          dateRange: this.dateRange,
        });
      }
    },
  },
  computed: {
    dateRange: {
      get() {
        return this.$store.state.filter.dateRange;
      },
      set(value) {
        this.$store.dispatch('activateRangeFilter', {
          mode: 'range',
          active: true,
          dateRange: value,
        });
      },
    },
    singleDate: {
      get() {
        return this.$store.state.filter.singleDate;
      },
      set(value) {
        this.$store.dispatch('activateSingleDateFilter', {
          mode: 'single',
          active: true,
          singleDate: value,
        });
      },
    },
    singleDateIsActive() {
      const {active, mode} = this.$store.state.filter.dateFilter;
      return active && mode === 'single';
    },
    dateRangeIsActive() {
      const {active, mode} = this.$store.state.filter.dateFilter;
      return active && mode === 'range';
    },
  },
};
</script>

<style scoped></style>
