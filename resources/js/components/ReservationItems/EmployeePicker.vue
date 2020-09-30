<template>
    <div class="flex flex-col px-4 pb-4 pt-4">
        <span class="uppercase font-medium text-xs text-gray-800 leading-tight mb-2">Who are you?</span>
        <div class="flex justify-between">
            <div class="flex space-x-4">
                <div v-if="error" class="text-red-400 flex items-center leading-tight">
                    <i class="fas fa-times"></i>
                </div>

                <button
                    v-for="p in preselected"
                    :key="p.id"
                    @click="setEmployeeLocal(p)"
                    class="h-10 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                    :class="p.equals(selected) ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                >
                    {{ p.name }}
                </button>

            </div>
            <popper v-if="hasRest" trigger="clickToOpen" :options="{placement: 'bottom-start'}">
                <div class="popper rounded-lg p-2 border border-gray-400 bg-white">
                    <div class="flex justify-center mb-1">
            <span
                class="text-center text-xs text-gray-500 uppercase font-light leading-tight"
            >Employees</span>
                    </div>
                    <hr/>
                    <div class="flex flex-wrap w-32 text-gray-800">
            <span
                v-for="r in rest"
                v-bind:key="r.id"
                @click="setEmployeeLocal(r)"
                class="flex-1 px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
                :class="r.equals(selected)? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
            >{{ r.name }}</span>
                    </div>
                </div>
                <select-button
                    slot="reference"
                    :selected="() => isNotInPreselected"
                    :value="isNotInPreselected ? this.selected.name : 'Other'"
                    icon="fas fa-address-book"
                ></select-button>
            </popper>
        </div>
    </div>
</template>

<script lang="ts">

import Vue from 'vue';
import axios from 'axios';
import Popper from "vue-popperjs";
import Employee from "../../models/Employee";
import {EmployeeError} from "../../exceptions/Exceptions";

export default Vue.extend({
    components: {
        popper: Popper,
    },
    props: {
        error: Boolean,
        init: Employee
    },
    data() {
        return {
            selected: this.init,
            employees: Array.of(this.init)
        };
    },
    mounted() {
        this.updateEmployees();
    },
    methods: {
        setEmployeeLocal(employee: Employee): void {
            this.selected = employee;
            this.$emit("employee:chosen", this.selected);
        },
        updateEmployees(): void {
            const endpoint: string = "/users";
            axios.get(endpoint).then((res: any) => {
                let responseData = res.data;
                if (!responseData instanceof Array) {
                    responseData = Array.of(responseData);
                }
                this.employees = responseData.map(entry => Employee.of(entry));
            })
            .catch((err: any) => throw EmployeeError.of(`Failed fetching Employees, see: ${err}`))
        }
    },
    computed: {
        hasRest(): boolean {
            return this.rest !== undefined;
        },
        preselected() {
            //TODO: Parse cookie - check last one used
            if (this.employees.length <= 3) {
                return this.employees;
            }
            return this.employees.slice(0, 3);
        },
        isNotInPreselected(): boolean {
            // is in rest
            if (this.rest !== undefined) return false;
            else return this.rest.includes(this.selected);
        },
        rest(): Array<Employee> | undefined {
            return this.employees.slice(3);
        },
    },
});
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
