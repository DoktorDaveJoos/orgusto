<template>
  <div class="w-8/12 self-center mb-2">
    <button
      v-if="!btnPressed"
      v-on:click="toggleBtnPressed"
      class="shadow-md rounded-full bg-blue-600 hover:bg-blue-900 text-white font-semibold px-2 py-1"
    >
      <i class="fas fa-plus mr-2"></i>
      Reservation
    </button>
  </div>
</template>

<script>
export default {
  name: "reservation-empty-item",
  data: function () {
    return {
      btnPressed: false
    }
  },
  props: {},
  methods: {
    toggleBtnPressed: function() {
      console.log('test');
      this.btnPressed = !this.btnPressed;
    }
  }
};
</script>
