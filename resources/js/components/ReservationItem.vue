<template>
  <div class="relative shadow-lg bg-white mx-auto rounded-lg w-full max-w-5xl">
    <div class="bg-white w-full shadow-lg max-w-5xl self-center mt-6 overflow-hidden rounded-lg">
      <div
        class="orgusto-honey flex flex-row items-center justify-between p-4 py-5 sm:px-6 border-b-4"
        :class="borderColor"
      >
        <h3 class="text-lg self-center leading-6 font-medium text-gray-800">{{ title }}</h3>
        <color-switcher :set-color="setColor"></color-switcher>
      </div>

      <employee-picker
        :error="errorContainsKey('user_id')"
        :employees="employees"
        v-on:employee:chosen="setEmployee"
      ></employee-picker>

      <hr />
      <date-picker :init="date"></date-picker>
      <time-picker :init="time" v-on:time:chosen="setTime"></time-picker>
      <hr />
      <person-picker
        :init="persons"
        :error="errorContainsKey('persons')"
        v-on:person:chosen="setPersons"
      ></person-picker>
      <duration-picker
        :init="duration"
        :error="errorContainsKey('duration')"
        v-on:duration:chosen="setDuration"
      ></duration-picker>

      <hr />

      <div class="flex p-4 pb-2 justify-between">
        <div
          v-if="errorContainsKey('name')"
          class="text-red-400 flex items-center py-2 pr-4 leading-tight"
        >
          <i class="fas fa-times"></i>
        </div>

        <input
          class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"
          :class="reservationTitle ? 'border-indigo-400 text-gray-800' : ''"
          placeholder="Name of the guest / group"
          type="text"
          v-model="reservationTitle"
        />
        <select-button
          :handle="() => showAdditionalNotice = !showAdditionalNotice"
          :selected="() => showAdditionalNotice"
          icon="fas fa-sticky-note"
          value="notice"
        ></select-button>
      </div>

      <div class="flex px-4 py-2" v-if="showAdditionalNotice">
        <div
          v-if="errorContainsKey('notice')"
          class="text-red-400 flex items-center p-2 px-4 leading-tight"
        >
          <i class="fas fa-times"></i>
        </div>
        <input
          class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"
          :class="reservationNotice ? 'border-indigo-400 text-gray-800' : ''"
          placeholder="Some additional information ..."
          type="text"
          v-model="reservationNotice"
        />
      </div>

      <div class="flex p-4 pt-2">
        <div
          v-if="errorContainsKey('email')"
          class="text-red-400 flex items-center p-2 px-4 pl-0 leading-tight"
        >
          <i class="fas fa-times"></i>
        </div>
        <input
          class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg mr-4"
          :class="email ? 'border-indigo-400 text-gray-800' : ''"
          placeholder="Email"
          type="email"
          v-model="email"
        />
        <div
          v-if="errorContainsKey('phone_number')"
          class="text-red-400 flex items-center py-2 pr-4 leading-tight"
        >
          <i class="fas fa-times"></i>
        </div>
        <input
          class="h-10 flex-1 text-sm rounded-lg bg-gray-300 text-gray-400 leading-tight px-4 focus:outline-none border-2 focus:border-indigo-400 focus:text-gray-800 hover:shadow-lg"
          :class="phone_number ? 'border-indigo-400 text-gray-800' : ''"
          placeholder="Phone number"
          type="phone"
          v-model="phone_number"
        />
      </div>
      <hr />

      <table-picker
        :error="errorContainsKey('tables')"
        :tables-endpoint="tablesEndpoint"
        :filter-data="filterData"
        v-on:tables:chosen="setTables"
      ></table-picker>

      <hr />

      <div class="flex justify-end p-4">
        <button
          @click="this.$emit('modal:close')"
          class="p-2 px-4 mr-4 rounded-lg bg-gray-400 text-gray-600 leading-tight text-sm hover:text-gray-800 hover:bg-gray-300 transition-colors duration-150 ease-in-out"
        >Cancel</button>
        <button
          @click="handleSubmit()"
          class="p-2 px-4 rounded-lg bg-indigo-600 border-2 border-indigo-600 leading-tight text-sm text-gray-100 hover:bg-white hover:text-indigo-600 transition-colors duration-150 ease-in-out"
        >{{ this.reservation ? 'Updated' : 'Save' }}</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "reservation-item",
  props: ["reservation", "employees", "tablesEndpoint", "reservationsEndpoint"],
  data() {
    return {
      // TODO: Read that from cookie
      color: "gray",
      date: new Date(),
      time: "18:00",
      persons: "2",
      duration: { h: "2", m: "00" },
      tables: [],
      email: "",
      employee: "",
      phone_number: "",
      reservationTitle: "",
      reservationNotice: "",
      showAdditionalNotice: false,
      errors: {}
    };
  },
  methods: {
    setColor(color) {
      this.color = color.toString();
    },
    setDate(date) {
      console.log(date);
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
    setTables(tables) {
      this.tables = tables;
    },
    handleSubmit() {
      const request = this.validate();

      axios
        .post(this.reservationsEndpoint, request)
        .then(res => console.log(res))
        .catch(err => {
          console.log(err.response);
          this.errors = err.response.data.errors;
        });
    },
    validate() {
      const request = Object.assign({
        color: this.color,
        start: this.processedDate,
        end: this.processedEndDate,
        persons: this.persons,
        duration: this.processedDuration,
        tables: this.tables,
        email: this.email,
        employee: this.employee,
        phone_number: this.phone_number,
        name: this.reservationTitle,
        notice: this.reservationNotice
      });

      return request;
    },
    errorContainsKey(key) {
      console.log(
        "Contains " +
          key +
          ":" +
          Object.keys(this.errors).find(elem => elem === key) !==
          undefined
      );
      return Object.keys(this.errors).find(elem => elem === key) !== undefined;
    }
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
        .format("YYYY-MM-DD HH:mm[:00]");
    },
    processedEndDate() {
      return moment(this.processedDate)
        .add("hours", this.duration.h)
        .add("minutes", this.duration.m)
        .format("YYYY-MM-DD HH:mm[:00]");
    },
    processedDuration() {
      return this.duration.h + "." + this.duration.m;
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
