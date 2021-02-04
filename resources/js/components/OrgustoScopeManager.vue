<template></template>

<script>
import OrgustoDate from "../models/OrgustoDate";

export default {
  name: "orgusto-scope-manager",
  props: ["date"],
  mounted() {
    // Register event listener
    this.$bus.$on("scopeEvent", event => this.handleEvent(event));
  },
  methods: {
    handleEvent: function(event) {

        const scopedHour = OrgustoDate.ofString(this.date).hour;

        let date;

        if (event.type === 'date') {
            // always set scope hour
            date = OrgustoDate.ofString(event.value).setHours(scopedHour);
        } else {
            // scope hour is part of date
            date = OrgustoDate.ofString(this.date);
        }

        // just add or subtract an hour from date
        if (event.type === "scopeHour") {
            date = event.value > 0 ? date.addHours(1) : date.subtractHours(1);
        }

        const encodedDate = encodeURIComponent(date.asISO);

        location.href =
            window.location.origin + "/manage?date=" + encodedDate;

    }
  }
};
</script>
