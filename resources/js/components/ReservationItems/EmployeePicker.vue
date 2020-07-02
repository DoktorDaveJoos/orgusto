<template>
  <div class="p-4 flex justify-between">
    <div class="flex flex-row">
      <button
        v-for="employee in preselected"
        :key="employee.id"
        class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner mr-4"
        :class="selectedEmployee.name === employee.name ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
        @click="setEmployeeLocal(employee)"
      >{{ employee.name }}</button>
    </div>

    <popper v-if="hasRest" trigger="clickToOpen" :options="{placement: 'bottom-start'}">
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
            @click="setEmployeeLocal(employee)"
            class="flex-1 px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
            :class="selectedEmployee.name === employee.name ? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
          >{{ employee.name }}</span>
        </div>
      </div>

      <button
        v-if="preselected.length === 3 && this.employees.length > 0"
        slot="reference"
        class="h-12 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-inner"
        :class="isNotInPreselected ? 'border-2 border-blue-400 text-gray-800 font-semibold' : ''"
      >
        {{ isNotInPreselected ? this.selectedEmployee.name : 'Other' }}
        <i
          class="fas fa-address-book ml-2"
        ></i>
      </button>
    </popper>
  </div>
</template>

<script>
import Popper from "vue-popperjs";

export default {
  components: {
    popper: Popper
  },
  props: ["employees", "setEmployee"],
  data() {
    return {
      selectedEmployee: {
        name: ""
      }
    };
  },
  methods: {
    setEmployeeLocal(employee) {
      this.selectedEmployee = employee;
      this.setEmployee(this.selectedEmployee);
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
    rest() {
      return this.employees.filter(
        empl =>
          this.preselected.find(empl_pre => empl_pre.name === empl.name) ===
          undefined
      );
    },
    hasRest() {
      return (
        this.rest && this.rest.length !== undefined && this.rest.length > 0
      );
    },
    isNotInPreselected() {
      return (
        this.rest.find(empl => this.selectedEmployee.name === empl.name) !==
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
