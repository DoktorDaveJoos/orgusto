<template>
  <div class="flex flex-col px-4 pb-4 pt-4">
    <span class="uppercase font-medium text-xs text-gray-800 leading-tight mb-2">Who are you?</span>
    <div class="flex justify-between">
      <div class="flex space-x-4">
        <div v-if="error" class="text-red-400 flex items-center leading-tight">
          <i class="fas fa-times"></i>
        </div>

        <select-button
          v-for="employee in preselected"
          :key="employee.id"
          :selected="() => selectedEmployee.name === employee.name"
          :value="employee.name"
          :handle="setEmployeeLocal"
        ></select-button>
      </div>
      <popper trigger="clickToOpen" :options="{placement: 'bottom-start'}">
        <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
          <div class="flex justify-center mb-1">
            <span
              class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
            >Employees</span>
          </div>
          <hr />
          <div class="flex flex-wrap w-32 text-gray-800">
            <span
              v-for="employee in rest"
              v-bind:key="employee.id"
              @click="setEmployeeLocal(employee.name)"
              class="flex-1 px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
              :class="selectedEmployee.name === employee.name ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
            >{{ employee.name }}</span>
          </div>
        </div>
        <select-button
          slot="reference"
          :selected="() => isNotInPreselected"
          :value="isNotInPreselected ? this.selectedEmployee.name : 'Other'"
          icon="fas fa-address-book"
        ></select-button>
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
  props: ["employees", "error"],
  data() {
    return {
      selectedEmployee: {
        name: ""
      }
    };
  },
  methods: {
    setEmployeeLocal(employee) {
      this.selectedEmployee.name = employee;
      this.$emit(
        "employee:chosen",
        this.employees.filter(empl => empl.name === this.selectedEmployee.name)
      );
    },
    hasRest() {
      return (
        this.rest && this.rest.length !== undefined && this.rest.length > 0
      );
    }
  },
  computed: {
    preselected() {
      //TODO: Parse cookie - check last one used

      if (this.employees.length <= 3) {
        return this.employees;
      }

      const preselected = this.employees.slice(0, 3);
      return preselected;
    },
    isNotInPreselected() {
      return (
        this.rest &&
        this.rest.length > 0 &&
        this.rest.find(empl => this.selectedEmployee.name === empl.name) !==
          undefined
      );
    },
    rest() {
      return this.employees.filter(
        empl =>
          this.preselected.find(empl_pre => empl_pre.name === empl.name) ===
          undefined
      );
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
