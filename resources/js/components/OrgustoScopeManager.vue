<template></template>

<script>
export default {
  name: "orgusto-scope-manager",
  props: {
    date: {
      type: String,
      required: true
    },
    scope: {
      type: String,
      required: true
    }
  },
  mounted() {
    // Register event listener
    this.$bus.$on("scopeEvent", event => this.handleEvent(event));
  },
  methods: {
    handleEvent: function(event) {
      console.log(window.location);

      if (event.type === "date") {
        location.href =
          window.location.origin +
          "/manage/" +
          event.value +
          "/" +
          this.scope;
      }

      if (event.type === "scopeHour") {
        location.href =
          window.location.origin + "/manage/" + this.date + "/" + event.value;
      }
    }
  }
};
</script>