<template>
  <div class="flex flex-col px-4 pb-1 pt-2">
    <span class="uppercase font-medium text-xs text-gray-800 leading-tight mb-1">Number of people</span>
    <div class="flex justify-between">
      <div>
        <button
          v-for="a in 6"
          :key="a"
          class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
          :class="personpicker === a.toString() ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
          @click="setPerson(a)"
        >{{ a }}</button>
      </div>

      <popper trigger="clickToOpen" :options="{placement: 'bottom-start'}">
        <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
          <div class="flex justify-center mb-1">
            <span
              class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
            >Persons</span>
          </div>
          <hr />
          <div class="flex flex-wrap w-32 text-gray-800">
            <span
              class="flex-1 px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
              :class="personpicker === (a + 6).toString() ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
              v-for="a in 15"
              v-bind:key="a"
              @click="setPerson(a + 6)"
            >{{ a + 6 }}</span>
          </div>
        </div>

        <button
          slot="reference"
          class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
          :class="moreIsActive ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        >
          {{ moreIsActive ? personpicker : "More" }}
          <i class="fas fa-user-friends ml-2"></i>
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
  props: ["setPersons"],
  data() {
    return {
      personpicker: "2"
    };
  },
  methods: {
    setPerson(persons) {
      this.personpicker = persons.toString();
      this.setPersons(this.personpicker);
    }
  },
  computed: {
    moreIsActive() {
      return parseInt(this.personpicker) > 6;
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
