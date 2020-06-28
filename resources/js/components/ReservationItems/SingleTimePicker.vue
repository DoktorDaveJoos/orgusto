<template>
  <popper trigger="clickToOpen" :options="{
      placement: 'bottom-start',

    }">
    <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
      <div>
        <div class="flex justify-center mb-1">
          <span
            class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
          >Choosen time</span>
        </div>
        <div class="flex justify-around mb-2">
          <span class="text-lg text-gray-800 font-semibold">{{ hour }}</span>
          <span class="text-lg text-gray-800 font-semibold">:</span>
          <span class="text-lg text-gray-800 font-semibold">{{ minutes }}</span>
        </div>
        <hr />
        <div class="flex">
          <div class="flex flex-col overflow-y-scroll h-64 items-center text-gray-800 text-sm p-2">
            <span
              class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
              :class="hour === b.toString() ? 'bg-blue-600 text-white' : ''"
              v-for="(a,b) in 24"
              v-bind:key="b"
              @click="setHour(b)"
            >{{ b }}</span>
          </div>

          <div class="flex flex-col h-64 items-center text-gray-800 text-sm p-2">
            <span
              class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
              :class="minutes === '00' ? 'bg-blue-600 text-white' : ''"
              @click="setMinutes('00')"
            >00</span>
            <span
              class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
              :class="minutes === '15' ? 'bg-blue-600 text-white' : ''"
              @click="setMinutes('15')"
            >15</span>
            <span
              class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
              :class="minutes === '30' ? 'bg-blue-600 text-white' : ''"
              @click="setMinutes('30')"
            >30</span>
            <span
              class="px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200"
              :class="minutes === '45' ? 'bg-blue-600 text-white' : ''"
              @click="setMinutes('45')"
            >45</span>
          </div>
        </div>
      </div>
    </div>

    <button
      slot="reference"
      class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
      :class="active ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
    >
      {{ active ? hour + ":" + minutes : "Choose time" }}
      <i class="ml-2 fas fa-clock"></i>
    </button>
  </popper>
</template>

<script>
import Popper from "vue-popperjs";

export default {
  components: {
    popper: Popper
  },
  props: ["active", "setSingleTime", "hours", "minute"],
  data() {
    return {
      hour: this.hours ?? "17",
      minutes: this.minute ?? "00"
    };
  },
  methods: {
    setHour(hour) {
      this.hour = hour.toString();
      this.setSingleTime(this.time);
    },
    setMinutes(minute) {
      this.minutes = minute.toString();
      this.setSingleTime(this.time);
    }
  },
  computed: {
    time() {
      return this.hour + ":" + this.minutes;
    }
  }
};
</script>

<style>
.popper .popper__arrow {
  width: 0;
  height: 0;
  border-style: solid;
  position: absolute;
}
.popper[x-placement^="bottom"] {
  margin-top: 10px;
}
.popper[x-placement^="bottom"] .popper__arrow {
  top: 0;
  left: 20px !important;
  margin-top: 0;
  content: "";
  position: absolute;
  display: block;
  width: 12px;
  height: 12px;
  border-top: inherit;
  border-left: inherit;
  background: inherit;
  z-index: -1;
  transform: translateY(-50%) rotate(45deg);
}
</style>
