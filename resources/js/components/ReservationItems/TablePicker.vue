<template>
    <div class="flex flex-col p-4">
    <span
        class="uppercase font-medium text-xs text-gray-800 leading-tight"
    >{{ __('common.free_tables') }}</span>
        <div class="flex flex-wrap">
            <div v-if="hasTableError" class="text-red-400 flex items-center py-2 pr-4 leading-tight">
                <i class="fas fa-times"></i>
            </div>
            <div class="my-2 mr-2" v-for="table in sortedTables" :key="table.id">
                <select-button
                    v-if="table && table.table_number"
                    :value="getAsNumber(table, table.table_number)"
                    :selected="() => isActive(table.id)"
                    :handle="() => handleTableClick(table.id)"
                ></select-button>
            </div>
            <div v-if="isLoading" class="flex flex-row my-2 items-center my-2 mr-2 text-gray-600 text-xs italic">
                <div class="lds-dual-ring"></div>
                <div class="ml-4 animate-pulse">
                    {{ __('common.getting_tables') }}
                </div>
            </div>
            <div v-if="!isLoading && tables.length === 0" class="my-2 mr-2 text-gray-600 text-xs italic">
                {{ __('common.no_tables') }}
            </div>
        </div>
        <div v-if="hasTableError">
            <span class="my-2 mr-2 text-red-600 text-xs italic">
                {{ errors.tables instanceof Array ? errors.tables[0] : errors.tables }}
            </span>
        </div>
    </div>
</template>

<script>

import store from '../../store';
import {mapState} from 'vuex';

export default {
    name: "TablePicker",
    props: ["selectedTables"],
    store,
    data() {
        return {}
    },
    methods: {
        handleTableClick(tableId) {
            if (this.selectedTables.find(table => table.id === tableId)) {
                this.$emit("value:changed", {tables: this.selectedTables.filter(table => table.id !== tableId)});
            } else {
                this.$emit("value:changed", {tables: this.selectedTables.concat(this.tables.find(table => table.id === tableId))});
            }
        },
        isActive(tableId) {
            return this.selectedTables.find(table => table.id === tableId) !== undefined;
        },
        getAsNumber(parent, val) {
            return parseInt(val);
        },
    },
    computed: {
        ...mapState({
            tables: state => state.restaurant.tables,
            isLoading: state => state.loadingStates.tables,
            errors: state => state.reservations.errors
        }),
        sortedTables() {
            return this.tables.sort((a, b) => a.table_number - b.table_number);
        },
        hasTableError() {
            return Object.keys(this.errors).includes('tables');
        }
    }
}

</script>

<style scoped>
.lds-dual-ring {
    display: inline-block;
    width: 24px;
    height: 24px;
}
.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 24px;
    height: 24px;
    margin: 0px;
    border-radius: 50%;
    border: 3px solid #374152;
    border-color: #1f2a37 transparent #374152 transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
