<template>
  <div class="mx-8 my-4 shadow-lg rounded-full flex flex-row bg-white">
    <!-- Header -->
    <div
      class="w-1/6 rounded-l-full border-r border-gray-300 m-0 p-2 bg-gray-200 text-gray-600 flex flex-row"
    >
      <div class="w-1/2 text-center flex flex-col">
        <span class="uppercase leading-tight text-xs">Table</span>
        <span class="w-full text-center">{{ table.table_number }}</span>
      </div>
      <div class="w-1/2 text-center flex flex-col">
        <span class="uppercase leading-tight text-xs">Seats</span>
        <span class="w-full text-center">{{ table.seats }}</span>
      </div>
    </div>

    <!-- Body -->
    <div v-for="(n, i) in 20" :key="i" style="width: 4.166665%" class="flex flex-row">
      <div v-if="slotHasReservation(i)" class="m-0 flex flex-row w-full">
        <div v-if="isEdgeSlot(i) !== 0" class="m-0 flex flex-row w-full">
          <div
            v-if="isEdgeSlot(i) === 2"
            :class="slotColorAndBorder(i)"
            class="m-0 flex flex-row w-full"
          >
            <span
              class="absolute overflow-x-visible text-gray-700 self-center pl-6 text-sm leading-tight z-0"
            >{{ getReservation(i).name }}</span>
          </div>
          <div
            v-if="isEdgeSlot(i) === 1"
            :class="slotColor(i)"
            class="m-0 flex flex-row w-full rounded-r-full"
          >&nbsp;</div>
        </div>
        <div v-else :class="slotColor(i)" class="m-0 flex flex-row w-full">&nbsp;</div>
      </div>
      <div
        v-else
        class="p-0 switchChild flex w-full text-gray-300 hover:text-gray-400 cursor-pointer"
        @click="addNewReservationAt(i)"
      >
        <div class="self-center w-full text-center">
          <i class="fas fa-plus text-xs"></i>
        </div>
        <span class="w-full text-center hidden text-xs">{{ getTime(i) }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "orgastro-table",
  props: {
    table: {
      type: Object,
      required: true
    },
    tables: {
      type: Array,
      required: true
    },
    slotClicked: Function,
    timelineStart: String
  },
  methods: {
    slotHasReservation(slot) {
      if (this.reservations.length === 0) {
        return false;
      }

      return this.getReservation(slot) !== undefined;
    },

    isEdgeSlot(slot) {
      const reservation = this.getReservation(slot);
      const slotTime = moment(this.timelineStart).add(slot * 15, "m");

      if (slotTime.isSame(reservation.starting_at)) {
        return 2;
      }

      if (
        slotTime.add(15, "m").isSame(
          moment(reservation.starting_at)
            .add(reservation.length, "h")
            .toDate()
        )
      ) {
        return 1;
      }
      return 0;
    },

    getReservation(slot) {
      const slotTime = moment(this.timelineStart).add(slot * 15, "m");

      return this.reservationsArray.find(
        reservation =>
          slotTime >= moment(reservation.starting_at) &&
          slotTime <
            moment(reservation.starting_at)
              .add(reservation.length, "h")
              .toDate()
      );
    },

    slotColorAndBorder(slot) {
      return [
        "bg-" + this.getReservation(slot).color + "-200",
        slot === 0 ? null : "rounded-l-full"
      ];
    },

    slotColor(slot) {
      const rounded_right = slot === 19 ? " rounded-r-full" : "";
      return "bg-" + this.getReservation(slot).color + "-200" + rounded_right;
    },

    addNewReservationAt(slot) {
      const slotTime = moment(this.timelineStart).add(slot * 15, "m");
      this.slotClicked(this.table, slotTime);
    },

    getTime(slot) {
      return moment(this.timelineStart)
        .add(slot * 15, "m")
        .format("HH:mm");
    }
  },
  computed: {
    reservations() {
      return this.table.reservations;
    },
    reservationsArray() {
      return Object.keys(this.reservations).map(key => this.reservations[key]);
    }
  }
};
</script>
