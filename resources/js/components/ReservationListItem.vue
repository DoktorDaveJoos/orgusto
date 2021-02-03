<template>
  <div class="shadow-md mb-2 mt-2 rounded-lg w-8/12 max-w-5xl self-center">
    <div class="w-full bg-gray-200 rounded-t-lg p-3 flex justify-between">
      <div class="font-bold text-sm text-gray-700 self-center">
        <i class="fas fa-clock self-center"></i>
        {{ this.reservation.start | moment("dddd, MMMM Do YYYY") }}
      </div>
      <div>
        <button
          class="rounded-full border-2 px-3 py-1 font-light text-sm text-gray-700 self-end hover:border-blue-300 hover:text-blue-500 mr-2 focus:no-underline focus:bg-green-400 focus:outline-none focus:shadow-outline"
        >
          <i class="fas fa-edit"></i>
          edit
        </button>

        <delete-button :id="this.reservation.id"></delete-button>
      </div>
    </div>

    <div class="p-2">
      <div class="text-xl text-gray-700 mb-2">{{ this.reservation.name }}</div>
      <div class="text-gray-700 text-base mb-2">{{ this.reservation.notice }}</div>
      <div class="py-2">
        <span
          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
        >{{ this.reservation.accepted_from }}</span>
        <span
          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
        >
          <i class="fas fa-hourglass"></i>
          {{ this.reservation.length }} h
        </span>
        <span
          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700"
        >
          <i class="fas fa-user-friends"></i>
          {{ this.reservation.persons }} Persons
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "reservation-list-item",
  props: {
    reservation: {
      type: Object,
      required: true
    }
  },
  methods: {}
};
</script>
