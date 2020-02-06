<template>
  <div class="w-8/12 self-center mb-2">
    <button
      v-if="!btnPressed"
      v-on:click="toggleBtnPressed"
      class="shadow-md rounded-full bg-blue-600 hover:bg-blue-900 text-white px-3 py-1"
    >
      <i class="fas fa-plus mr-2"></i>
      Reservation
    </button>

    <div v-if="btnPressed" class="shadow-md mb-2 mt-2 rounded-lg hover:shadow-xl">
      <div
        class="w-full rounded-lg p-3 flex justify-between"
        :class="color"
        :key="inputValues.card_color"
      >
        <div class="flex w-2/4 relative">
          <div class="font-bold text-sm text-gray-700 self-center mr-2 static">
            <i class="fas fa-clock self-center"></i>
          </div>

          <div class="self-center">
            <vc-date-picker v-model="inputValues.date" :input-props="{class: datePickerStyle}"></vc-date-picker>
          </div>
          <div class="flex w-3/4">
            <orgastro-dropdown
              :onChange="onChange"
              :init="inputValues.hours"
              id="hours"
              :options="hourOptions"
              unit="h"
            ></orgastro-dropdown>
            <orgastro-dropdown
              :onChange="onChange"
              id="minutes"
              :init="inputValues.minutes"
              :options="minuteOptions"
              :operation="tenMinutesStep"
            ></orgastro-dropdown>
          </div>
        </div>

        <div class="self-center">
          <button
            class="rounded-full border-2 text-gray-700 px-3 py-1 hover:border-green-300 hover:text-green-500 text-sm font-light focus:no-underline focus:border-green-400 focus:outline-none focus:shadow-outline"
            v-on:click="saveBtnPressed"
          >
            <i class="fas fa-save mr-1"></i>
            save
          </button>
          <button
            class="rounded-full border-2 text-gray-700 px-3 py-1 hover:border-red-300 hover:text-red-500 text-sm font-light focus:no-underline focus:border-red-400 focus:outline-none focus:shadow-outline"
            v-on:click="toggleBtnPressed"
          >
            <i class="fas fa-ban mr-1"></i>
            cancel
          </button>
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
            class="focus:outline-none"
            rows="2"
            resize="none"
            style="width: 100%"
            placeholder="Some further information"
            v-model="inputValues.notice"
          />
        </div>

        <div class="flex">
          <orgastro-dropdown
            :onChange="onChange"
            id="person_count"
            init="-"
            title="Persons"
            options="20"
          ></orgastro-dropdown>
          <orgastro-dropdown
            :onChange="onChange"
            id="length"
            init="-"
            title="Duration"
            options="8"
            unit="h"
            :operation="halfAnHourStep"
          ></orgastro-dropdown>
          <orgastro-dropdown
            :onChange="onChange"
            id="accepted_from"
            init="-"
            title="Employee"
            :options="users"
          ></orgastro-dropdown>
        </div>

        <div class="flex mt-3">
          <orgastro-dropdown
            :onChange="onChange"
            id="card_color"
            title="Color"
            :options="colorOptions"
          ></orgastro-dropdown>

          <orgastro-dropdown
            :onChange="onChangeTable"
            id="tables"
            init="-"
            reset="-"
            title="Add table"
            :options="tableOptions"
          ></orgastro-dropdown>

          <div>
            <label
              v-if="inputValues.tables.length > 0"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
            >
              Booked tables
              <span class="text-xs font-light">click on number to remove</span>
            </label>
            <div class>
              <button
                class="self-center pt-2 font-semibold text-sm mx-2 p-2 rounded-full hover:bg-red-400 bg-gray-200 focus:outline-none"
                v-for="table in this.inputValues.tables"
                v-bind:key="table"
                @click="remove"
              >{{ table }}</button>
            </div>
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
  </div>
</template>

<script>
export default {
  name: "reservation-empty-item",
  data: function() {
    return {
      btnPressed: false,
      displayError: false,
      open: false,

      datePickerStyle:
        "rounded bg-gray-100 focues:bg-white font-semibold text-sm self-center p-2 px-3 mr-2 text-gray-700",

      dateOptions: ["Today", "Tomorrow", "Other"],
      hourOptions: ["16", "17", "18", "19", "20", "21", "22"],
      minuteOptions: "6",

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

        hours: new Date(Date.now()).getHours().toString() + " h",
        minutes: new Date(Date.now()).getMinutes().toString(),
        date: new Date(Date.now()),

        person_count: "",
        length: "",
        accepted_from: "",

        card_color: "gray",

        tables: []
      }
    };
  },
  methods: {
    toggleBtnPressed: function() {
      this.btnPressed = !this.btnPressed;
    },
    toggleNameClicked: function() {
      this.nameClicked = !this.nameClicked;
    },
    saveBtnPressed: function() {
      this.computeStartingAt();
      if (this.errorList.length > 0) {
        this.displayError = true;
      } else {

        const request = {
          "name": this.inputValues.name,
          "notice": this.inputValues.notice,
          "starting_at": this.inputValues.starting_at,
          "person_count": this.inputValues.person_count,
          "length": this.inputValues.length,
          "accepted_from": this.inputValues.accepted_from
        }

        // name', 'notice', 'person_count', 'starting_at', 'length', 'accepted_from', 'user_id'

        console.log(request);

        axios
          .post("/reservations", request)
          .then(res => console.log(res))
          .catch(err => console.log(err));

        this.displayError = false;
      }
    },
    halfAnHourStep: val => {
      return val / 2;
    },
    tenMinutesStep: val => {
      return (val - 1) * 10;
    },
    onChange: function(event) {
      this.inputValues[event.target.id] = event.target.value;
    },
    onDayChange: function(event) {
      this.inputValues.dateDd = event.target.value;
      if (this.inputValues.dateDd === "Other") {
        this.open = !this.open;
      }
    },
    onChangeTable: function(val) {
      const index = this.inputValues.tables.indexOf(val);
      if (index === -1) {
        this.inputValues.tables.push(val);
      }
    },
    remove: function(event) {
      const index = this.inputValues.tables.indexOf(event.target.innerText);
      if (index > -1) {
        this.inputValues.tables.splice(index, 1);
      }
    },
    computeStartingAt: function() {
      let reservationDate = new Date(Date.parse(this.inputValues.date));

      reservationDate.setHours(parseInt(this.inputValues.hours));
      reservationDate.setMinutes(parseInt(this.inputValues.minutes));

      this.inputValues.starting_at = reservationDate;
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
    }
  }
};
</script>
