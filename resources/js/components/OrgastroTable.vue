<template>
  <div class="mx-8 my-4 bg-gray-100 rounded-full flex flex-row">
    <!-- Header -->
    <div class="w-1/6 m-0 p-1 rounded-full bg-gray-300 text-gray-600 flex flex-row">
      <div class="w-1/2 text-center flex flex-col">
        <span class="font-thin text-xs">Table nr.</span>
        <span class="w-full text-center">{{ tnumber }}</span>
      </div>
      <div class="w-1/2 text-center flex flex-col">
        <span class="font-thin text-xs">Seats</span>
        <span class="w-full text-center">{{ Math.floor(Math.random() * 10) }}</span>
      </div>
    </div>

    <!-- Body -->
    <div v-for="(n, i) in 20" :key="i" style="width: 4.166665%" class="flex flex-row">
      <div v-if="slotHasReservation(i)" class="m-0 flex flex-row w-full">
        <div v-if="isEdgeSlot(i) !== 0" class="m-0 flex flex-row w-full">
          <div
            v-if="isEdgeSlot(i) === 2"
            :class="slotColor(i)"
            class="m-0 flex flex-row w-full rounded-l-full flex flex-row"
          >
            <span
              class="absolute overflow-x-visible text-gray-700 self-center pl-4 text-sm font-light z-0"
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
      <div v-else class="p-0 h-full"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "orgastro-table",
  data() {
    return {
      timeline: {
        currStart: moment("2020-02-26 17:00:00")
      }
    };
  },
  props: {
    tnumber: {
      type: String,
      required: true
    },
    reservations: {}
  },
  methods: {
    slotHasReservation: function(slot) {
      if (this.reservations.length === 0) {
        return false;
      }

      if (this.getReservation(slot) !== undefined) {
        return true;
      } else return false;
    },

    isEdgeSlot: function(slot) {
      const reservation = this.getReservation(slot);
      const slotTime = moment(this.timeline.currStart).add(slot * 15, "m");

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

    getReservation: function(slot) {
      const slotTime = moment(this.timeline.currStart).add(slot * 15, "m");

      return this.reservationsArray.find(
        reservation =>
          slotTime >= moment(reservation.starting_at) &&
          slotTime <
            moment(reservation.starting_at)
              .add(reservation.length, "h")
              .toDate()
      );
    },

    slotColor: function(index) {
      return "bg-" + this.getReservation(index).color + "-200";
    }
  },
  computed: {
    reservationsArray: function() {
      return Object.keys(this.reservations).map(key => this.reservations[key]);
    }
  }
};
</script>