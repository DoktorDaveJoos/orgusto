<template>
  <div class="flex flex-col p-4">
    <span
      class="uppercase font-medium text-xs text-gray-800 leading-tight"
    >Free tables matching your reservation</span>
    <div class="flex flex-wrap">
      <div v-if="error" class="text-red-400 flex items-center py-2 pr-4 leading-tight">
        <i class="fas fa-times"></i>
      </div>
      <div class="my-2 mr-2" v-for="table in tables" :key="table.id">
        <select-button
          :value="table.table_number"
          :selected="() => isActive(table.id)"
          :handle="() => handleTableClick(table.id)"
        ></select-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["filterData", "tablesEndpoint", "error"],
  data() {
    return {
      tables: [],
      chosenTables: []
    };
  },
  methods: {
    updateTables(filter) {
      if (filter.date !== undefined && filter.date !== "Invalid date") {
        var request = Object.assign({});
        request.start = filter.date;
        request.end = moment(request.start)
          .add("hours", filter.duration.h)
          .add("minutes", filter.duration.m)
          .format("YYYY-MM-DD HH:mm:ss");

        const queryParams = $.param(request);

        axios
          .get(this.tablesEndpoint + "?" + queryParams)
          .then(res => {
            this.tables = res.data;
          })
          .catch(err => console.log(err));
      }
    },
    handleTableClick(tableId) {
      if (this.chosenTables.find(id => id === tableId) === undefined) {
        this.chosenTables.push(tableId);
      } else {
        this.chosenTables = this.chosenTables.filter(id => id !== tableId);
      }

      this.$emit("tables:chosen", this.chosenTables);
    },
    isActive(tableId) {
      return this.chosenTables.find(id => id === tableId) !== undefined;
    }
  },
  mounted() {
    this.updateTables(this.filterData);
  },
  watch: {
    filterData(n, o) {
      this.updateTables(n);
    }
  }
};
</script>

<style>
</style>
