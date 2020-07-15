<template>
  <div class="p-4 pt-2 flex justify-between">
    <div class="flex flex-row">
      <div v-if="error" class="text-red-400 flex items-center leading-tight">
        <i class="fas fa-times"></i>
      </div>
      <button
        class="h-10 text-sm rounded-l-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
        :class="hourpicker === '17' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setHour('17')"
      >17</button>
      <button
        class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
        :class="hourpicker === '18' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setHour('18')"
      >18</button>
      <button
        class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
        :class="hourpicker === '19' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setHour('19')"
      >19</button>
      <button
        class="h-10 text-sm rounded-r-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg mr-4"
        :class="hourpicker === '20' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setHour('20')"
      >20</button>

      <div class="flex flex-row items-center text-gray-800 mr-4">:</div>

      <button
        class="h-10 text-sm rounded-l-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
        :class="minutepicker === '00' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setMinute('00')"
      >00</button>
      <button
        class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
        :class="minutepicker === '15' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setMinute('15')"
      >15</button>
      <button
        class="h-10 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
        :class="minutepicker === '30' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setMinute('30')"
      >30</button>
      <button
        class="h-10 text-sm rounded-r-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg mr-4"
        :class="minutepicker === '45' ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
        @click="setMinute('45')"
      >45</button>
    </div>
    <div>
      <single-time-picker
        :active="singleTimePickerActive"
        :hours="hourpicker"
        :minute="minutepicker"
        :set-single-time="setSingleTime"
      ></single-time-picker>
    </div>
  </div>
</template>

<script>
export default {
  props: ["init", "error"],
  data() {
    return {
      hourpicker: this.init.split(":")[0],
      minutepicker: this.init.split(":")[1],
      singleTimePickerActive: false
    };
  },
  methods: {
    setHour(hour) {
      this.hourpicker = hour.toString();
      this.singleTimePickerActive = false;
      this.setTime(this.time);
    },
    setMinute(minute) {
      this.minutepicker = minute.toString();
      this.singleTimePickerActive = false;
      this.setTime(this.time);
    },
    setSingleTime(time) {
      this.hourpicker = "other";
      this.minutepicker = "other";
      this.singleTimePickerActive = true;
      this.setTime(time);
    },
    setTime(time) {
      this.$emit("time:chosen", time);
    }
  },
  computed: {
    time() {
      const hour = this.hourpicker !== "other" ? this.hourpicker : "17";
      const minute = this.minutepicker !== "other" ? this.minutepicker : "00";
      return this.hourpicker + ":" + this.minutepicker;
    }
  }
};
</script>

<style>
</style>
