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
            <div v-if="tables.tables.length === 0" class="my-2 mr-2 text-gray-600 text-xs italic">
                No tables available for this reservation.
            </div>
        </div>

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
        init: Object as PropType<Tables>
    },
    data() {
        return {
            tables: this.init ? Tables.of(this.init) : Tables.empty(),
            chosenTables: this.init ? Tables.of(this.init) : Tables.empty(),
        };
    },
    mounted() {
        this.updateTables(this.filterData);
    },
    methods: {
        updateTables(filter: Filter): void {

            const request: TablesRequest = TablesRequest.of(filter);

            // reset tables before requesting
            this.tables = this.init ? Tables.of(this.init) : Tables.empty();
            this.chosenTables = this.init ? Tables.of(this.init) : Tables.empty();

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
        init(n: Tables | Table, o: Tables | Table) {
            this.tables = Tables.of(n);
            this.chosenTables = Tables.of(n);
            this.$emit('tables:chosen', this.chosenTables);
        }
    },
});

</script>
