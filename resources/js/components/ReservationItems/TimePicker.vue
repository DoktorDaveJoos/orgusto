<template>
  <div class="p-4 flex justify-between">
    <div class="flex flex-row">
      <button
        class="h-12 text-sm rounded-l-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="hourpicker === '17' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setHour('17')"
      >17</button>
      <button
        class="h-12 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="hourpicker === '18' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setHour('18')"
      >18</button>
      <button
        class="h-12 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="hourpicker === '19' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setHour('19')"
      >19</button>
      <button
        class="h-12 text-sm rounded-r-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
        :class="hourpicker === '20' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setHour('20')"
      >20</button>

      <div class="flex flex-row items-center text-gray-800 mr-4">:</div>

      <button
        class="h-12 text-sm rounded-l-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="minutepicker === '00' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setMinute('00')"
      >00</button>
      <button
        class="h-12 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="minutepicker === '15' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setMinute('15')"
      >15</button>
      <button
        class="h-12 text-sm bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="minutepicker === '30' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setMinute('30')"
      >30</button>
      <button
        class="h-12 text-sm rounded-r-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="minutepicker === '45' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
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
  props: ["setTime"],
  data() {
    return {
      hourpicker: "17",
      minutepicker: "00",
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
      console.log("got time: ", time);
      this.hourpicker = "other";
      this.minutepicker = "other";
      this.singleTimePickerActive = true;
      this.setTime(time);
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
