<template>
  <div class="relative shadow-lg bg-white mx-auto rounded-lg w-full max-w-5xl">
    <!-- Card head -->
    <div class="w-full rounded-t-lg px-4 py-4" :class="color" :key="input.color">
      <div class="flex flex-col-reverse sm:flex-row justify-between items-center">
        <div class="flex-1 flex flex-row justify-center items-center w-full my-2">
          <i class="fas fa-clock text-gray-700 mr-4"></i>
          <v-date-picker v-model="input.date"></v-date-picker>
          <!-- :input-props="{class: 'rounded bg-gray-100 focus:bg-white focus:outline-none font-semibold text-sm self-center p-2 px-3 mr-2 text-gray-700'}" -->
        </div>

        <div class="flex-1 flex flex-grow justify-center items-center sm:justify-start w-full">
          <orgastro-dropdown
            :onChange="onChange"
            :init="input.hours"
            :options="24"
            id="hours"
            unit="h"
            additional-classes="bg-gray-100"
            container-class="orgusto-timepicker"
          ></orgastro-dropdown>

          <orgastro-dropdown
            :onChange="onChange"
            :init="input.minutes"
            :options="4"
            :operation="quarterHourStep"
            id="minutes"
            unit="m"
            additional-classes="bg-gray-100"
            container-class="orgusto-timepicker"
          ></orgastro-dropdown>
        </div>

        <div class="flex-1 flex flex-row sm:justify-end w-full">
          <button
            class="orgusto-button text-blue-600 hover:text-white hover:bg-blue-600 transition-color duration-200 ease-in-out mx-2"
            v-on:click="saveBtnPressed"
          >
            <i class="fas fa-save mr-2"></i>
            save
          </button>

          <slot name="optional-close"></slot>
        </div>
      </div>
    </div>

    <div class="p-2">
      <div class="text-xl text-gray-700 p-2 mb-2 w-full">
        <input
          class="focus:outline-none w-full"
          v-model="input.name"
          placeholder="Some name or a group"
          type="text"
        />
      </div>

      <div class="text-gray-700 p-2 text-base mb-2">
        <textarea
          class="focus:outline-none w-full"
          rows="2"
          resize="none"
          placeholder="Some further information"
          v-model="input.notice"
        />
      </div>

      <div class="flex flex-row">
        <orgastro-dropdown
          :onChange="onChange"
          id="persons"
          init="-"
          title="Persons"
          :options="tableSeats"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400"
        ></orgastro-dropdown>
        <orgastro-dropdown
          :onChange="onChange"
          id="duration"
          init="-"
          title="Duration"
          options="8"
          unit="h"
          :operation="halfAnHourStep"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400"
        ></orgastro-dropdown>
        <orgastro-dropdown
          :onChange="onChangeUser"
          id="user_id"
          init="-"
          title="Employee"
          :options="employees"
          :operation="parseUserName"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400"
        ></orgastro-dropdown>
      </div>

      <div class="flex flex-row mt-3">
        <orgastro-dropdown
          :onChange="onChange"
          id="color"
          title="Color"
          :options="colorOptions"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400 flex-1"
        ></orgastro-dropdown>

        <orgastro-dropdown
          :onChange="onChangeTable"
          id="tables"
          init="-"
          reset="-"
          title="Add table"
          :options="tables"
          :operation="parseTableNumber"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400 flex-1"
        ></orgastro-dropdown>

        <div class="w-full md:w-1/3 m-2">
          <label
            v-if="input.tables.length > 0"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          >
            Booked tables
            <span class="text-xs font-light">click on number to remove</span>
          </label>

          <button
            class="self-center pt-2 font-semibold text-sm mx-2 p-2 rounded-full hover:bg-red-400 bg-gray-200 focus:outline-none"
            v-for="table in this.input.tables"
            v-bind:key="table.id"
            :id="table.id"
            @click="remove"
          >{{ table.table_number }}</button>
        </div>
      </div>

      <div v-if="displayError" class="leading-tight p-4 text-sm text-red-600 font-semibold">
        <p>Following errros occured:</p>
        <div v-for="(error, i, l) in displayError.errors" :key="i" class="pl-4 pt-2">
          <p v-for="(errorItem, j) in error" :key="j" class="text-xs">{{ l + 1 }}. {{ errorItem }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "reservation-empty-item",
  props: {
    table: {
      type: Object,
      required: false,
    },
    tables: {
      type: Array,
      required: false,
    },
    date: {
      type: Object,
      required: false,
    },
    employees: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      displayError: undefined,

      colorOptions: ["gray", "blue", "green", "red", "orange", "indigo"],

      // values from input:
      input: {
        name: "",
        notice: "",
        start: "",
        hours: 18,
        minutes: 0,
        date: new Date(),
        persons: "",
        duration: "",
        user: "",
        color: "gray",
        tables: [],
      },
    };
  },
  methods: {
    saveBtnPressed() {
      var request = Object.assign({}, this.input);
      const { date, hours, minutes } = this.input;
      request.start = moment(date)
        .hours(hours)
        .minutes(minutes)
        .seconds(0)
        .format("YYYY-MM-DD HH:mm:ss");
      request.tables = this.input.tables.map((table) => table.id);
      request.user_id = this.input.user.id;

      request.end = moment(request.start).add("hours", request.duration);
      request.end = request.end.format("YYYY-MM-DD HH:mm:ss");

      request.duration = 120;

      axios
        .post("/reservations", request)
        .then((res) => {
          if (res.status === 200) {
            location.reload();
          }
          if (res.status === 422) {
            // TODO handle error
          }
        })
        .catch((err) => (this.displayError = err.response.data));
    },
    halfAnHourStep: (val) => {
      return val / 2;
    },
    quarterHourStep: (val) => {
      return (val - 1) * 15;
    },
    parseTableNumber: (val) => {
      return val.table_number;
    },
    parseUserName: (val) => {
      return val.name;
    },
    onChange(event) {
      this.input[event.target.id] = event.target.value;
    },
    onChangeUser(event) {
      const found = this.employees.find(
        (user) => user.name === event.target.value
      );
      if (found) this.input.user = found;
    },
    onChangeTable(tableString) {
      const newTable = JSON.parse(tableString);
      const found = this.input.tables.filter(
        (table) => table.id === newTable.id
      );
      if (found.length === 0) this.input.tables.push(newTable);
    },
    remove(event) {
      this.input.tables = this.input.tables.filter(
        (table) => table.id.toString() !== event.target.id
      );
    },
    clearView(exceptions) {
      Object.keys(this.input).forEach((key) => {
        const found = exceptions.filter((e) => e === key);
        if (!found) this.input[key] = "";
      });

      this.input.color = "gray";
      this.input.tables = [];
    },
    checkNotNull: (val) => {
      if (val === undefined || val === null || val.length === 0) {
        return false;
      }
      return true;
    },
  },
  computed: {
    color: function () {
      return "bg-" + this.input.color + "-200";
    },
    tableSeats() {
      const { tables } = this.input;
      if (!this.checkNotNull(tables)) return "20";
      if (tables.length === 1) {
        return tables[0].seats;
      }
      if (tables.length > 1) {
        const accumulated = {};
        tables.reduce((prev, curr) =>
          Object.assign(accumulated, { seats: prev.seats + curr.seats })
        );
        return accumulated.seats;
      }
    },
  },
  watch: {
    date(newDate, _) {
      this.input.date = newDate.toDate();
      this.input.hours = newDate.hour();
      this.input.minutes = newDate.minute();
    },
    table(newTable, _) {
      this.clearView(["date", "hours", "minutes"]);
      this.input.tables.push(newTable);
    },
  },
};
</script>
