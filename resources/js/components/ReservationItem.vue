<template>
  <div class="relative shadow-lg bg-white mx-auto rounded-lg w-full max-w-5xl">
    <div class="bg-white w-full shadow-lg max-w-5xl self-center mt-6 overflow-hidden rounded-lg">
      <div
        class="orgusto-honey flex flex-row content-center justify-between px-4 py-4 sm:px-6 border-b-4"
        :class="borderColor"
      >
        <h3 class="text-lg self-center leading-6 font-medium text-gray-900">{{ title }}</h3>
        <color-switcher :set-color="setColor"></color-switcher>
      </div>

      <employee-picker :employees="employees" :set-employee="setEmployee"></employee-picker>
      <date-picker :set-date="setDate"></date-picker>
      <time-picker :set-time="setTime"></time-picker>
      <person-picker :set-persons="setPersons"></person-picker>
      <duration-picker :set-duration="setDuration"></duration-picker>

      <div class="flex p-4 justify-between">
        <input
          class="h-12 w-full px-4 font-semibold bg-gray-300 rounded-lg text-gray-800 p-2 leading-tight text-sm focus:bg-gray-200 focus:outline-none border-2 border-gray-300 focus:border-blue-400"
          placeholder="Name of the guest / group"
          type="text"
          v-model="reservationTitle"
        />
        <button
          @click="showAdditionalNotice = !showAdditionalNotice"
          class="h-12 flex flex-row px-4 items-center text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight focus:outline-none hover:shadow-inner ml-4"
          :class="showAdditionalNotice ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        >
          Notice
          <i class="fas fa-sticky-note ml-2"></i>
        </button>
      </div>

      <div class="flex p-4" v-if="showAdditionalNotice">
        <input
          class="h-12 px-4 w-full font-semibold bg-gray-300 rounded-lg text-gray-800 p-2 leading-tight text-sm focus:bg-gray-200 focus:outline-none border-2 border-gray-300 focus:border-blue-400"
          placeholder="Some additional information ..."
          type="text"
          v-model="reservationNotice"
        />
      </div>

      <div class="flex p-4">
        <input
          class="h-12 px-4 w-full font-semibold bg-gray-300 rounded-lg text-gray-800 p-2 leading-tight text-sm focus:bg-gray-200 focus:outline-none border-2 border-gray-300 focus:border-blue-400 mr-4"
          placeholder="Email"
          type="email"
          v-model="email"
        />
        <input
          class="h-12 px-4 w-full font-semibold bg-gray-300 rounded-lg text-gray-800 p-2 leading-tight text-sm focus:bg-gray-200 focus:outline-none border-2 border-gray-300 focus:border-blue-400"
          placeholder="Phone number"
          type="phone"
          v-model="phone_number"
        />
      </div>

      <table-picker
        :tables-endpoint="tablesEndpoint"
        :filter-data="filterData"
        :set-tables="setTables"
      ></table-picker>
    </div>
  </div>
</template>

<script>
export default {
  name: "reservation-item",
  props: ["reservation", "employees", "tablesEndpoint", "reservationsEndpoint"],
  data() {
    return {
      color: "gray",
      date: "",
      time: "",
      persons: "",
      email: "",
      employee: "",
      duration: {},
      phone_number: "",
      reservationTitle: "",
      reservationNotice: "",
      showAdditionalNotice: false
    };
  },
  methods: {
    setColor(color) {
      this.color = color.toString();
    },
    setDate(date) {
      this.date = date;
    },
    setTime(time) {
      this.time = time;
    },
    setPersons(persons) {
      this.persons = persons;
    },
    setEmployee(employee) {
      this.employee = employee.id;
    },
    setDuration(duration) {
      this.duration = duration;
    },
    setTables(tables) {}
  },
  computed: {
    title() {
      return this.reservation && this.reservation.name
        ? this.reservation.name
        : "New Reservation";
    },
    borderColor() {
      return "border-" + this.color + "-400";
    },
    processedDate() {
      const splittedTime = this.time.split(":");
      return moment(this.date)
        .set({
          hours: splittedTime[0],
          minutes: splittedTime[1]
        })
        .format("DD-MM-YYYY HH:mm[:00]");
    },
    filterData() {
      return {
        date: this.processedDate,
        persons: this.persons,
        duration: this.duration
      };
    }
  }
};
</script>
