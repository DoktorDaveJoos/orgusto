<template>
  <div class="flex flex-row overflow-y-auto">
    <div v-for="table in tables" :key="table.id" class="border border-gray-400 p-4">{{ table }}</div>
  </div>
</template>

<script>
export default {
  props: ["filterData", "setTables", "tablesEndpoint"],
  data() {
    return {
      tables: []
    };
  },
  watch: {
    filterData(n, o) {
      if (n.date !== undefined && n.date !== "Invalid date") {
        const duration = JSON.parse(n.duration);
        var request = Object.assign({});

        // TODO: At time to date

        request.date = n.date;
        request.end = moment(request.start)
          .add("hours", n.duration.h)
          .add("minutes", n.duration.m)
          .format("YYYY-MM-DD HH:mm:ss");

        const queryParams = $.param(this.filterData);
        console.log(queryParams);
        axios
          .get(this.tablesEndpoint + "?" + queryParams)
          .then(res => (this.tables = res.data))
          .catch(err => console.log(err));
      }
    }
  }
};
</script>

<style>
</style>
