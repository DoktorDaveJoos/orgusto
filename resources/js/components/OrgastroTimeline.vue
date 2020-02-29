<template>
  <div class="py-2 text-center sticky top-0 bg-white mx-8" style="z-index: 5;">
    <div class="w-full flex flex-row">
      <div class="w-1/6 border-r text-gray-600 font-light text-lg text-right"><span class="p-2">Hours</span></div>
      <div class="w-1/6 border-r text-gray-600 font-light text-lg text-left" v-for="i in 5" :key="i">
        <span class="p-1">{{ mapToHour(i) }}</span>
      </div>
    </div>
    <div class="w-full flex flex-row">
      <div class="w-1/6 border-r font-light text-sm text-gray-600 text-right"><span class="p-2">Minutes</span></div>
      <div class="w-1/6 flex flex-row" v-for="i in 5" :key="i">
        <div
          class="w-1/4 border-r font-light text-sm text-gray-600 text-left"
          v-for="j in 4"
          :key="j"
        >
          <span class="p-1">{{ mapToQuarter(j) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "orgastro-timeline",
  props: {
    ihour: {
      type: String,
      required: true
    }
  },
  methods: {
    mapToQuarter: val => {
      let min = val === 1 ? "00" : val === 2 ? "15" : val === 3 ? "30" : "45";
      return min;
    },
    mapToHour: function(val) {
      return parseInt(val) + parseInt(this.ihour);
    }
  }
};
</script>