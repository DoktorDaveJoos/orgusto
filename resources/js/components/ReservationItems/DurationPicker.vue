<template>
  <div class="flex flex-col px-4 pt-1 pb-4">
    <span class="uppercase font-medium text-xs text-gray-800 leading-tight mb-1">Duration</span>
    <div class="flex justify-between">
      <div>
        <button
          v-for="t in preselectedTimes"
          :key="(t.h + t.m).toString()"
          class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
          :class="comparePicked(t) ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
          @click="setDurationLocal(t)"
        >
          <div class="flex items-baseline">
            <div>{{ t.h }}</div>:
            <div class="text-xs">{{ t.m }}</div>
            <span class="ml-1">h</span>
          </div>
        </button>
      </div>

      <popper trigger="clickToOpen" :options="{placement: 'bottom-start'}">
        <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
          <div class="flex justify-center mb-1">
            <span
              class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
            >Duration</span>
          </div>
          <hr />
          <div class="flex flex-col text-gray-800">
            <span
              class="flex-1 px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
              :class="comparePicked(a) ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
              v-for="a in moreChoices"
              v-bind:key="(a.h + a.m).toString()"
              @click="setDurationLocal(a)"
            >{{ a.h }} : {{ a.m }} h</span>
          </div>
        </div>

        <button
          slot="reference"
          class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
          :class="moreIsActive ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        >
          {{ moreIsActive ? durationpicker.h + ":" + durationpicker.m + " h" : "More" }}
          <i
            class="fas fa-stopwatch ml-2"
          ></i>
        </button>
      </popper>
    </div>
  </div>
</template>

<script>
import Popper from "vue-popperjs";

export default {
  components: {
    popper: Popper
  },
  props: ["setDuration"],
  data() {
    return {
      preselectedTimes: [
        { h: "1", m: "00" },
        { h: "1", m: "30" },
        { h: "2", m: "00" },
        { h: "2", m: "30" },
        { h: "3", m: "00" },
        { h: "4", m: "00" }
      ],
      moreChoices: [
        { h: "3", m: "30" },
        { h: "4", m: "30" },
        { h: "8", m: "00" },
        { h: "12", m: "00" }
      ],
      durationpicker: { h: "2", m: "00" }
    };
  },
  methods: {
    setDurationLocal(duration) {
      this.durationpicker = duration;
      this.setDuration(JSON.stringify(this.durationpicker));
    },
    comparePicked(aTime) {
      return (
        aTime.h === this.durationpicker.h && aTime.m === this.durationpicker.m
      );
    }
  },
  computed: {
    moreIsActive() {
      return (
        this.moreChoices.find(
          elem =>
            elem.h === this.durationpicker.h && elem.m === this.durationpicker.m
        ) !== undefined
      );
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
