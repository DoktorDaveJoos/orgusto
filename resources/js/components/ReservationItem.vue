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

      <date-picker :set-date="setDate"></date-picker>
      <time-picker :set-time="setTime"></time-picker>

      <div class="flex p-4 justify-between">
        <input
          class="h-12 w-2/3 px-4 font-semibold bg-gray-300 rounded-lg text-gray-800 p-2 leading-tight text-sm focus:bg-gray-200 focus:outline-none border-2 border-gray-300 focus:border-blue-400"
          placeholder="Name of the guest / group"
          type="text"
          v-model="reservationTitle"
        />
        <button
          @click="showAdditionalNotice = !showAdditionalNotice"
          v-show="!showAdditionalNotice"
          class="h-12 flex flex-row px-4 items-center text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight focus:outline-none hover:shadow-inner ml-4"
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

      <div class="flex flex-col p-4">
        <span
          class="uppercase font-semibold text-xs text-gray-600 leading-tight mb-1"
        >Number of people</span>
        <div class="flex justify-between">
          <div>
            <button
              class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
            >2</button>
            <button
              class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
            >3</button>
            <button
              class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
            >4</button>
            <button
              class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
            >5</button>
            <button
              class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
            >6</button>
          </div>
          <button
            class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
          >
            More
            <i class="fas fa-user-friends ml-2"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "reservation-item",
  props: ["reservation"],
  data() {
    return {
      color: "gray",
      date: "",
      time: "",
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
    }
  }
};
</script>
