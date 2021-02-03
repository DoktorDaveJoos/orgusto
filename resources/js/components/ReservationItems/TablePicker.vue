<template>
    <div class="flex flex-col p-4">
    <span
        class="uppercase font-medium text-xs text-gray-800 leading-tight"
    >Free tables matching your reservation</span>
        <div class="flex flex-wrap">
            <div v-if="error" class="text-red-400 flex items-center py-2 pr-4 leading-tight">
                <i class="fas fa-times"></i>
            </div>
            <div class="my-2 mr-2" v-for="table in tables.tables" :key="table.id">
                <select-button
                    :value="table.table_number"
                    :selected="() => isActive(table.id)"
                    :handle="() => handleTableClick(table.id)"
                ></select-button>
            </div>
        </div>
        <div v-if="error" class="text-red-600 text-xs text-italic">{{ error.message }}</div>
    </div>
</template>

<script lang="ts">

import Vue, {PropType} from 'vue';

import axios from 'axios';
import Filter from '../../models/Filter';
import Tables from "../../models/Tables";
import Table from "../../models/Table";
import TablesRequest from "../../requests/TablesRequest";

export default Vue.extend({
    props: {
        filterData: {
            type: Object as PropType<Filter>
        },
        tablesEndpoint: String,
        error: Boolean,
        init: {
            type: Object as PropType<Tables>
        }
    },
    data() {
        return {
            tables: Tables.empty(),
            chosenTables: Tables.empty(),
        };
    },
    mounted() {
        this.updateTables(this.filterData);
    },
    methods: {
        updateTables(filter: Filter): void {
            const request: TablesRequest = TablesRequest.of(filter);

            axios.get(this.tablesEndpoint + '?' + request.queryParams)
                .then((res: any) => {
                    this.tables.merge(res.data);
                })
                .catch((err: any) => console.error(err));
        },
        handleTableClick(tableId: string): void {
            const {tables} = this.tables;
            const table: Table | undefined = tables.find(table => table.id === parseInt(tableId));
            if (table) {
                this.chosenTables.mergeTableOrElseRemove(table);
            }
            this.$emit('tables:chosen', this.chosenTables);
        },
        isActive(tableId: string): boolean {
            return this.chosenTables.tables.find(table => table.id === parseInt(tableId)) !== undefined;
        }
    },
    watch: {
        filterData: 'updateTables',
        init(n: PropType<Tables>, o: PropType<Tables>) {
            this.tables = Tables.of(n);
            this.chosenTables = Tables.of(n);
            this.$emit('tables:chosen', this.chosenTables);
        }
    },
});

</script>
