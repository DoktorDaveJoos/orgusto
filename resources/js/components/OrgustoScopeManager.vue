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

      if (event.type === "date") {
        location.href =
          window.location.origin + "/manage?date=" + event.value + "&hour=" + this.scope;
      }

      if (event.type === "scopeHour") {
        const newScope = event.value === "left" ? parseInt(this.scope) - 1 : parseInt(this.scope) + 1;
        location.href =
            window.location.origin + "/manage?date=" + this.date + "&hour=" + newScope;
      }
    }
  }
};
</script>