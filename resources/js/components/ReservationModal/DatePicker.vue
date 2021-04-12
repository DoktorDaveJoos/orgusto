<template>
  <div class="p-4 pb-2 flex justify-between">
    <div class="flex flex-row space-x-4">
      <div v-if="error" class="text-red-400 flex items-center leading-tight">
        <i class="fas fa-times"></i>
      </div>
      <select-button :value="__('common.today')" :handle="setDate" :selected="isSelected"></select-button>
      <select-button :value="__('common.tomorrow')" :handle="setDate" :selected="isSelected"></select-button>
      <select-button :value="__('common.day_after_tomorrow')" :handle="setDate" :selected="isSelected"></select-button>
    </div>
    <div>
      <v-date-picker v-model="duplicatedDate" :popover="{visibility: 'click'}">
        <select-button :value="getReadableDate()" :selected="moreIsSelected" icon="fas fa-calendar-alt"></select-button>
      </v-date-picker>
    </div>
  </div>
</template>

<script>
import {
  parseISO,
  startOfToday,
  startOfTomorrow,
  addDays,
  setHours,
  setMinutes,
  getHours,
  getMinutes,
  isSameDay,
  differenceInDays,
} from 'date-fns';

export default {
  name: 'DatePicker',
  props: ['date', 'error'],
  data() {
    return {
      duplicatedDate: parseISO(this.date),
      mappings: {
        [this.__('common.today')]: () => startOfToday(),
        [this.__('common.tomorrow')]: () => startOfTomorrow(),
        [this.__('common.day_after_tomorrow')]: () => addDays(startOfTomorrow(), 1),
      },
    };
  },
  methods: {
    setDate(value) {
      const date = this.mappings[value]();

      this.emitNewDate(date);
    },
    emitNewDate(value) {
      // always set time to new date
      const dateAsISO = parseISO(this.date);
      let updatedDate = setHours(value, getHours(dateAsISO));
      updatedDate = setMinutes(updatedDate, getMinutes(dateAsISO));

      const data = {
        start: updatedDate.toISOString(),
      };

      this.$emit('value:changed', data);
    },
    isSelected(day) {
      return isSameDay(this.mappings[day](), parseISO(this.date));
    },
    moreIsSelected() {
      if (parseISO(this.date) < this.mappings[this.__('common.today')]()) {
        return true;
      } else {
        return differenceInDays(parseISO(this.date), this.mappings[this.__('common.today')]()) > 2;
      }
    },
    getReadableDate() {
      if (this.moreIsSelected()) {
        return parseISO(this.date).toLocaleDateString();
      } else {
        return this.__('common.choose_date');
      }
    },
  },
  watch: {
    duplicatedDate(date, _) {
      this.emitNewDate(date);
    },
  },
};
</script>
