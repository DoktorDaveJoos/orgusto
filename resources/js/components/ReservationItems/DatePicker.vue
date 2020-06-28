<template>
  <div class="p-4 flex justify-between">
    <div class="flex flex-row">
      <button
        class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
        :class="datepicker === 'today' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setDatePicker('today')"
      >Today</button>
      <button
        class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
        :class="datepicker === 'tomorrow' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setDatePicker('tomorrow')"
      >Tomorrow</button>
      <button
        class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
        :class="datepicker === 'datomorrow' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setDatePicker('datomorrow')"
      >Day after tomorrow</button>
    </div>
    <div>
      <v-date-picker v-model="singleDate" :popover="{ visibility: 'click' }">
        <button
          class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
          :class="choosenDate !== '' ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        >
          {{ choosenDate !== '' ? choosenDate : 'Choose date' }}
          <i class="ml-2 fas fa-calendar-alt"></i>
        </button>
      </v-date-picker>
    </div>
  </div>
</template>

<script>
export default {
  props: ["setDate"],
  data() {
    return {
      datepicker: "today",
      choosenDate: "",
      singleDate: new Date()
    };
  },
  methods: {
    setDatePicker(indicator) {
      this.choosenDate = "";
      this.datepicker = indicator;
      if (indicator === "today") {
        this.setDate(moment());
      } else if (indicator === "tomorrow") {
        this.setDate(moment().add(1, "days"));
      } else if (indicator === "datomorrow") {
        this.setDate(moment().add(2, "days"));
      }
    }
  },
  watch: {
    singleDate(newVal, oldVal) {
      this.datepicker = "";
      this.choosenDate = moment(newVal).format("DD.MM.YYYY");
      this.setDate(moment(newVal));
    }
  }
};
</script>

<style>
</style>
