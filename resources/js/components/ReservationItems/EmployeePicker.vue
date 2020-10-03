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
                    <div class="flex flex-wrap w-40 text-gray-800 p-1">
            <span
                v-for="r in rest"
                :key="r.id"
                @click="setEmployeeLocal(r)"
                class="flex-1 px-3 py-1 mt-1 rounded-full cursor-pointer hover:bg-gray-200 text-center text-sm"
                :class="r.equals(selected)? 'bg-blue-600 text-white hover:bg-blue-400 hover:text-gray-800' : ''"
            >{{ r.name }}</span>
                    </div>
                </div>

                <button
                    slot="reference"
                    class="h-10 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
                    :class="isNotInPreselected ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
                >
                    {{ isNotInPreselected ? this.selected.name : 'Other' }}
                    <i class="fas fa-address-book ml-2"></i>
                </button>


<!--                <select-button-->
<!--                    slot="reference"-->
<!--                    :selected="someProperty"-->
<!--                    :value="isNotInPreselected ? this.selected.name : 'Other'"-->
<!--                    icon="fas fa-address-book"-->
<!--                ></select-button>-->
            </popper>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import axios from 'axios';
import Employee from "../../models/Employee";
import EmployeeError from "../../errors/EmployeeError";
// noinspection TypeScriptCheckImport
import Popper from "vue-popperjs";

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
            // remove observer tracking
            selected: Employee.of(this.init),
            employees: Array.of(this.init),
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
                let responseData: any = res.data;
                if (!(responseData instanceof Array)) {
                    responseData = Array.of(responseData);
                }
                this.employees = responseData.map(entry => Employee.of(entry));
            })
                .catch((err: any) => {
                        throw EmployeeError.of(`Failed fetching Employees, see: ${err}`)
                    }
                );
        },
    },
    computed: {
        hasRest(): boolean {
            return this.rest.length > 0;
        },
        preselected(): Array<Employee> {
            // TODO: Parse cookie - check last one used
            if (this.employees.length <= 3) {
                return this.employees;
            }
            return this.employees.slice(0, 3);
        },
        isNotInPreselected(): boolean {
            // is in rest
            const found: Employee[] = this.rest.filter((e: Employee) => e.id === this.selected.id);
            return found.length > 0;
        },
        rest(): Array<Employee> {
            return this.employees.slice(3).map((e: Employee) => Employee.of(e));
        },
    },
});
</script>

<!--suppress CssUnusedSymbol -->
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
