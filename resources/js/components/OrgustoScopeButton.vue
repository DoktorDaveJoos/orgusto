<template>
  <button
    class="text-gray-600 shadow-lg bg-gray-200 hover:bg-gray-300 w-1/12 h-full rounded-full focus:outline-none"
    v-on:click="handleClick()"
  >
    <i :class="iconClass"></i>
  </button>
</template>

<script>
export default {
  name: "orgusto-scope-button",
  props: {
    direction: {
      type: String,
      required: true
    }
  },
  methods: {
    handleClick: function() {
      this.$bus.$emit("scopeEvent", {
        msg: "scope event",
        type: "scopeHour",
        value: this.direction
      });
    }
  },
  computed: {
    iconClass: function() {
      return "fas fa-chevron-" + this.direction;
    }
  }
};
</script>
