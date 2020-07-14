<template>
  <div class="p-4 pb-2 flex justify-between">
    <div class="flex flex-row space-x-4">
      <select-button value="today" :handle="setDatePicker" :selected="isSelected"></select-button>
      <select-button value="tomorrow" :handle="setDatePicker" :selected="isSelected"></select-button>
      <select-button value="day after tomorrow" :handle="setDatePicker" :selected="isSelected"></select-button>
    </div>
    <div>
      <v-date-picker v-model="singleDate" :popover="{ visibility: 'click' }">
        <select-button
          :value="chosenDate !== '' ? chosenDate : 'Choose date'"
          :selected="() => chosenDate !== ''"
          icon="fas fa-calendar-alt"
        ></select-button>
      </v-date-picker>
    </div>
  </div>
</template>

<script>
export default {
  props: ["init"],
  data() {
    return {
      datepicker: "today",
      chosenDate: "",
      singleDate: this.init
    };
  },
  methods: {
    setDatePicker(indicator) {
      this.chosenDate = "";
      this.datepicker = indicator;
      if (indicator === "today") {
        this.setDate(moment());
      } else if (indicator === "tomorrow") {
        this.setDate(moment().add(1, "days"));
      } else if (indicator === "day after tomorrow") {
        this.setDate(moment().add(2, "days"));
      }
    },
    setDate(date) {
      this.$emit("date:chosen", date);
    },
    isSelected(indicator) {
      return this.datepicker === indicator;
    }
  },
  watch: {
    singleDate(newVal, oldVal) {
      this.datepicker = "";
      this.chosenDate = moment(newVal).format("DD.MM.YYYY");
      this.setDate(moment(newVal));
    }
  }
};
</script>

<style>
</style>
