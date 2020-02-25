<template>
  <div class="mx-8 my-4 bg-gray-200 rounded-full flex flex-row">
    <!-- Header -->
    <div class="w-1/6 m-0 p-2 rounded-full bg-gray-300 text-gray-600 flex flex-row">
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
    <div v-for="i in 20" :key="i" style="width: 4.166665%" class="m-0 flex flex-row">
      <div v-if="slotHasReservation(i)" class="m-0 flex flex-row w-full">
        <div v-if="isEdgeSlot(i) !== 0" class="m-0 flex flex-row w-full">
          <div v-if="isEdgeSlot(i) === 2" class="m-0 flex flex-row w-full bg-green-300 rounded-l-full flex flex-row">
            <span class="absolute overflow-x-visible text-gray-700 self-center pl-4 text-sm font-light z-0">{{ getReservation(i).name }}</span>
          </div>
          <div v-if="isEdgeSlot(i) === 1" class="m-0 flex flex-row w-full bg-green-300 rounded-r-full">&nbsp;</div>
        </div>
        <div v-else class="m-0 flex flex-row w-full bg-green-300">&nbsp;</div>
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
        currStart: moment("2020-02-25 17:00")
      },
      reservations: [
        {
          name: "Frau Müller",
          starting_at: moment("2020-02-25 17:00"),
          length: 1.5
        },
        {
          name: "Herr Maier",
          starting_at: moment("2020-02-25 19:30"),
          length: 2
        }
      ]
    };
  },
  props: {
    tnumber: {
      type: String,
      required: true
    }
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
      const slotTimePlus = moment(this.timeline.currStart)
        .add(slot * 15 + 1, "m")
        .toDate();
      const slotTime = moment(this.timeline.currStart)
        .add(slot * 15 - 16, "m")
        .toDate();

      return slotTimePlus >
        moment(reservation.starting_at)
          .add(reservation.length, "h")
          .toDate()
        ? 1
        : slotTime < reservation.starting_at
        ? 2
        : 0;
    },

    getReservation: function(slot) {
      const slotTime = moment(this.timeline.currStart)
        .add(slot * 15, "m")
        .toDate();
      return this.reservations.find(
        reservation =>
          slotTime > reservation.starting_at &&
          slotTime <=
            moment(reservation.starting_at)
              .add(reservation.length, "h")
              .toDate()
      );
    }
  },
  computed: {}
};
</script>