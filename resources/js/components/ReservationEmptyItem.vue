<template>
  <div class="relative bg-white shadow-md mx-auto rounded-lg min-w-full">
    <!-- Card head -->
    <div class="w-full rounded-t-lg px-4 py-2" :class="color" :key="inputValues.card_color">
      <div class="flex flex-col-reverse sm:flex-row justify-between items-center">
        <div class="flex-1 flex flex-row justify-center items-center w-full my-2">
          <i class="fas fa-clock text-gray-700 mr-4"></i>
          <vc-date-picker v-model="inputValues.date" :input-props="{class: datePickerStyle}"></vc-date-picker>
        </div>

        <div class="flex-1 flex flex-grow justify-center items-center sm:justify-start w-full">
          <orgastro-dropdown
            :onChange="onChange"
            :init="inputValues.hours !== null ? inputValues.hours : 18"
            :options="hourOptions"
            id="hours"
            unit="h"
            additional-classes="bg-gray-100"
            container-class="orgusto-timepicker"
          ></orgastro-dropdown>

          <orgastro-dropdown
            :onChange="onChange"
            :init="inputValues.minutes !== null ? inputValues.minutes : 0"
            :options="minuteOptions"
            :operation="quarterHourStep"
            id="minutes"
            unit="m"
            additional-classes="bg-gray-100"
            container-class="orgusto-timepicker"
          ></orgastro-dropdown>
        </div>

        <div class="flex-1 flex flex-row sm:justify-end w-full">
          <button
            class="orgusto-button bg-gray-300 hover:bg-green-300 hover:text-gray-900 transition-color duration-200 ease-in-out w-full"
            v-on:click="saveBtnPressed"
          >
            <i class="fas fa-save"></i>
            save
          </button>

          <slot name="optional-close"></slot>
        </div>
      </div>
    </div>

    <div class="p-4">
      <div class="text-xl text-gray-700 mb-2 w-full">
        <input
          class="focus:outline-none w-full"
          v-model="inputValues.name"
          placeholder="Some name or a group"
          type="text"
        />
      </div>

      <div class="text-gray-700 text-base mb-2">
        <textarea
          class="focus:outline-none w-full"
          rows="2"
          resize="none"
          placeholder="Some further information"
          v-model="inputValues.notice"
        />
      </div>

      <div class="flex flex-row">
        <orgastro-dropdown
          :onChange="onChange"
          id="person_count"
          init="-"
          title="Persons"
          :options="tableSeats"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400"
        ></orgastro-dropdown>
        <orgastro-dropdown
          :onChange="onChange"
          id="length"
          init="-"
          title="Duration"
          options="8"
          unit="h"
          :operation="halfAnHourStep"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400"
        ></orgastro-dropdown>
        <orgastro-dropdown
          :onChange="onChange"
          id="accepted_from"
          init="-"
          title="Employee"
          :options="users"
          additional-classes="bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-400"
        ></orgastro-dropdown>
      </div>

      <div class="flex flex-row mt-3">
        <orgastro-dropdown
          :onChange="onChange"
          id="card_color"
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
            v-if="inputValues.tables.length > 0"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          >
            Booked tables
            <span class="text-xs font-light">click on number to remove</span>
          </label>

          <button
            class="self-center pt-2 font-semibold text-sm mx-2 p-2 rounded-full hover:bg-red-400 bg-gray-200 focus:outline-none"
            v-for="table in this.inputValues.tables"
            v-bind:key="table.id"
            :id="table.id"
            @click="remove"
          >{{ table.table_number }}</button>
        </div>
      </div>
      <div v-if="displayError" class="flex w-full mt-2" :key="hashInput">
        <span class="bg-red-400 text-white w-8/12 rounded-lg p-2 mt-2 mb-2 w-full" role="alert">
          Following fields must not be empty:
          <ul class="list-disc px-4">
            <li v-for="entry in errorList" :key="entry">{{ entry }}</li>
          </ul>
        </span>
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
      required: false
    },
    tables: {
      type: Array,
      required: false
    },
    date: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      displayError: false,

      datePickerStyle:
        "rounded bg-gray-100 focus:bg-white focus:outline-none font-semibold text-sm self-center p-2 px-3 mr-2 text-gray-700",

      dateOptions: ["Today", "Tomorrow", "Other"],
      hourOptions: "24",
      minuteOptions: "4",

      colorOptions: [
        "gray",
        "blue",
        "green",
        "red",
        "orange",
        "yellow",
        "indigo"
      ],

      tableOptions: "20",

      users: ["Felix Forstenhäusler", "David Joos"],

      notRequired: ["notice", "color"],

      errorMap: new Map([
        ["name", "name or group"],
        ["starting_at", "time"],
        ["accepted_from", "employee"],
        ["length", "duration"],
        ["persons", "persons"],
        ["tables", "tables"]
      ]),

      // values from input:
      inputValues: {
        name: "",
        notice: "",
        starting_at: "",

        hours: null,
        minutes: null,
        date: new Date(),

        person_count: "",
        length: "",
        accepted_from: "",

        card_color: "gray",

        tables: []
      }
    };
  },
  methods: {
    saveBtnPressed() {
      this.computeStartingAt();
      if (this.errorList.length > 0) {
        this.displayError = true;
      } else {
        const request = {
          name: this.inputValues.name,
          notice: this.inputValues.notice,
          starting_at: this.inputValues.starting_at,
          person_count: this.inputValues.person_count,
          length: this.inputValues.length,
          accepted_from: this.inputValues.accepted_from,
          tables: this.inputValues.tables.map(table => table.id),
          color: this.inputValues.card_color
        };

        axios
          .post("/reservations", request)
          .then(res => {
            if (res.status === 200) {
              location.reload();
            }
          })
          .catch(err => console.log(err));

        this.displayError = false;
      }
    },
    halfAnHourStep: val => {
      return val / 2;
    },
    quarterHourStep: val => {
      return (val - 1) * 15;
    },
    parseTableNumber: val => {
      return val.table_number;
    },
    onChange(event) {
      this.inputValues[event.target.id] = event.target.value;
    },
    onDayChange(event) {
      this.inputValues.dateDd = event.target.value;
      if (this.inputValues.dateDd === "Other") {
        this.open = !this.open;
      }
    },
    onChangeTable(tableString) {
      const newTable = JSON.parse(tableString);
      const found = this.inputValues.tables.filter(
        table => table.id === newTable.id
      );
      if (found.length === 0) this.inputValues.tables.push(newTable);
    },
    remove(event) {
      this.inputValues.tables = this.inputValues.tables.filter(
        table => table.id.toString() !== event.target.id
      );
      console.log(this.inputValues.tables);
    },
    computeStartingAt() {
      let reservationDate = new Date(Date.parse(this.inputValues.date));

      reservationDate.setHours(parseInt(this.inputValues.hours));
      reservationDate.setMinutes(parseInt(this.inputValues.minutes));
      this.inputValues.starting_at = reservationDate;

      this.inputValues.starting_at = moment(
        this.inputValues.starting_at
      ).format("YYYY-MM-DD HH:mm:ss");
    },
    clearView(exceptions) {
      Object.keys(this.inputValues).forEach(key => {
        const found = exceptions.filter(e => e === key);
        if (!found) this.inputValues[key] = "";
      });

      this.inputValues.card_color = "gray";
      this.inputValues.tables = [];
    },

    checkNotNull: val => {
      if (val === undefined || val === null || val.length === 0) {
        return false;
      }
      return true;
    }
  },
  computed: {
    color: function() {
      return "bg-" + this.inputValues.card_color + "-200";
    },
    hashInput: function() {
      return Object.keys(this.inputValues)
        .map(input => this.inputValues[input].toString())
        .reduce((prev, cur) => prev.concat(cur));
    },
    errorList: function() {
      return Object.keys(this.inputValues)
        .filter(input => !this.notRequired.includes(input))
        .filter(required => this.inputValues[required].length === 0)
        .map(missing => this.errorMap.get(missing));
    },
    tableSeats() {
      const { tables } = this.inputValues;
      if (!this.checkNotNull(tables)) return "20";
      if (tables.length === 1) {
        console.log(tables[0]);
        return tables[0].seats;
      }
      if (tables.length > 1) {
        const accumulated = {};
        tables.reduce((prev, curr) =>
          Object.assign(accumulated, { seats: prev.seats + curr.seats })
        );
        return accumulated.seats;
      }
    }
  },
  watch: {
    date(newDate, _) {
      this.inputValues.date = newDate.toDate();
      this.inputValues.hours = newDate.hour();
      this.inputValues.minutes = newDate.minute();
    },
    table(newTable, _) {
      this.clearView(["date", "hours", "minutes"]);
      this.inputValues.tables.push(newTable);
    }
  }
};
</script>
