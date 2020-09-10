<template>
  <div class="flex flex-col px-4 pt-2 pb-4">
    <div class="flex justify-between">
      <div class="flex space-x-4">
        <div v-if="error" class="text-red-400 flex items-center leading-tight">
          <i class="fas fa-times"></i>
        </div>
        <select-button
          v-for="t in preselectedTimes"
          :key="(t.h + t.m).toString()"
          :selected="() => comparePicked(t)"
          :handle="() => setDurationLocal(t)"
          :value="t.h + ':' + t.m + 'h'"
        ></select-button>
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

        <select-button
          slot="reference"
          :selected="() => moreIsActive"
          :value="moreIsActive ? durationpicker.h + ':' + durationpicker.m + 'h' : 'More'"
          icon="fas fa-stopwatch"
        ></select-button>
      </popper>
    </div>
  </div>
</template>

<script>
import Popper from "vue-popperjs";

export default {
  components: {
    popper: Popper,
  },
  props: ["init", "error"],
  data() {
    return {
      preselectedTimes: [
        { h: "1", m: "00" },
        { h: "1", m: "30" },
        { h: "2", m: "00" },
        { h: "2", m: "30" },
        { h: "3", m: "00" },
        { h: "4", m: "00" },
      ],
      moreChoices: [
        { h: "3", m: "30" },
        { h: "4", m: "30" },
        { h: "8", m: "00" },
        { h: "12", m: "00" },
      ],
      durationpicker: this.init,
    };
  },
  methods: {
    setDurationLocal(duration) {
      this.durationpicker = duration;
      this.$emit("duration:chosen", this.durationpicker);
    },
    comparePicked(aTime) {
      return (
        aTime.h === this.durationpicker.h && aTime.m === this.durationpicker.m
      );
    },
  },
  computed: {
    moreIsActive() {
      return (
        this.moreChoices.find(
          (elem) =>
            elem.h === this.durationpicker.h && elem.m === this.durationpicker.m
        ) !== undefined
      );
    },
  },
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
