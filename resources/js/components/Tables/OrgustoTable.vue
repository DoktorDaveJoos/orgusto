<template>
  <div class="mx-8 my-4 shadow-lg rounded-full flex flex-row bg-white border-2 border-gray-400">
    <!-- Header -->
    <div class="w-1/6 rounded-l-full border-r border-gray-300 m-0 p-2 bg-gray-200 text-gray-600 flex flex-row">
      <div class="w-1/2 text-center flex flex-col">
        <span class="uppercase leading-tight text-xs">{{ __('common.Tables') }}</span>
        <span class="w-full text-center">{{ table.table_number }}</span>
      </div>
      <div class="w-1/2 text-center flex flex-col">
        <span class="uppercase leading-tight text-xs">{{ __('common.seats') }}</span>
        <span class="w-full text-center">{{ table.seats }}</span>
      </div>
    </div>

    <!-- Body -->
    <div v-for="(n, i) in 20" :key="i" style="width: 4.166665%" class="flex flex-row" @click="handleSlotClick(i)">
      <!-- Reservation at slot -->
      <div v-if="slotHasReservation(i)" class="m-0 flex flex-row w-full cursor-pointer">
        <div class="m-0 flex flex-row w-full" :class="getSlotClass(i)">
          <div v-if="showInfo(i)" class="flex flex-row items-center pl-6">
            <div v-if="getReservation(i).done">
              <i class="fas fa-calendar-check text-gray-600"></i>
            </div>
            <div class="flex flex-col absolute overflow-x-visible" :class="getReservation(i).done ? 'pl-6' : null">
              <span class="text-sm font-medium" :class="getReservation(i).done ? 'text-gray-400' : 'text-gray-800'">{{
                getReservation(i).name
              }}</span>
              <span v-show="!getReservation(i).done" class="text-gray-600 text-xs">
                <i class="fas fa-user-friends"></i>
                {{ getReservation(i).persons }} {{ __('common.guests') }}</span
              >
            </div>
          </div>
        </div>
      </div>

      <!-- No Reservation at slot -->
      <div v-else class="p-0 switchChild flex w-full text-gray-300 hover:text-gray-400 cursor-pointer">
        <div class="self-center w-full text-center">
          <i class="fas fa-plus text-xs"></i>
        </div>
        <span class="w-full text-center hidden text-xs">{{ getTime(i) }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import store from '../../store';
import {mapState} from 'vuex';

import {addMinutes, parseISO, format, isSameMinute} from 'date-fns';

const SLOT_CONSTANTS = {
  FIRST: 0,
  LAST: 19,
};

const SlotMapper = new Proxy(
  {
    19: 'end',
  },
  {
    get(target, args) {
      return target[args] ? target[args] : null;
    },
  },
);

const ClassMapper = new Proxy(
  {
    19: 'rounded-r-full',
    start: 'rounded-l-full',
    end: 'rounded-r-full',
  },
  {
    get(target, args) {
      return target[args] ? target[args] : null;
    },
  },
);

export default {
  name: 'orgusto-table',
  store,
  props: ['tableId'],
  methods: {
    slotHasReservation(slot) {
      if (this.reservations.length === 0) {
        return false;
      }

      return this.getReservation(slot) !== undefined;
    },
    getSlotClass(slot) {
      const reservation = this.getReservation(slot);

      return [
        `bg-${reservation.color}-${reservation.done ? '100' : '200'}`,
        ClassMapper[SlotMapper[slot]],
        ClassMapper[this.isEdgeSlot(slot)],
      ];
    },

    isEdgeSlot(slot) {
      const reservation = this.getReservation(slot);

      const reservationStart = parseISO(reservation.start);
      const reservationEnd = addMinutes(reservationStart, reservation.duration);
      const slotTime = addMinutes(this.timelineStart, slot * 15);

      // check if is start of reservation
      if (isSameMinute(slotTime, reservationStart)) {
        return 'start';
      }

      // check if is end of reservation
      if (isSameMinute(addMinutes(slotTime, 15), reservationEnd)) {
        return 'end';
      }

      return null;
    },

    getReservation(slot) {
      const slotTime = addMinutes(this.timelineStart, slot * 15);

      return this.reservations.find(reservation => {
        const start = parseISO(reservation.start);
        const end = addMinutes(start, reservation.duration);
        return slotTime >= start && slotTime < end;
      });
    },

    slotColorAndBorder(slot) {
      const reservation = this.getReservation(slot);

      return [
        reservation ? 'bg-' + reservation.color + '-200' : '',
        slot === SLOT_CONSTANTS.FIRST ? '' : 'rounded-l-full',
      ];
    },

    slotColor(slot) {
      const reservation = this.getReservation(slot);

      const rounded_right = slot === SLOT_CONSTANTS.LAST ? ' rounded-r-full' : '';
      return reservation ? 'bg-' + reservation.color + '-200' : '' + rounded_right;
    },
    getTime(slot) {
      const slotTime = addMinutes(this.timelineStart, slot * 15);
      return format(slotTime, 'HH:mm');
    },

    handleSlotClick(slot) {
      const reservation = this.getReservation(slot);

      if (!reservation) {
        const slotTime = addMinutes(this.timelineStart, slot * 15);
        const preSelected = {
          tables: Array.of(this.table),
          start: slotTime.toISOString(),
        };
        this.$store.dispatch('createNewReservation', preSelected);
      } else {
        this.$store.dispatch('setActiveReservation', reservation.id);
        this.$store.commit('openModal');
      }
    },
    showInfo(slot) {
      return slot === 0 || this.isEdgeSlot(slot) === 'start';
    },
  },

  computed: {
    ...mapState({
      table: function(state) {
        return state.restaurant.allTables.find(table => table.id === this.tableId);
      },
      timelineStart: state => state.filter.timelineStart,
      reservations: function(state) {
        return state.reservations.items.filter(reservation =>
          reservation.tables.find(table => table.id === this.tableId),
        );
      },
    }),
  },
};
</script>
