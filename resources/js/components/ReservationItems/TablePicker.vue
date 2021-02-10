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
                    v-if="table.table_number"
                    :value="getAsNumber(table, table.table_number)"
                    :selected="() => isActive(table.id)"
                    :handle="() => handleTableClick(table.id)"
                ></select-button>
            </div>
            <div v-if="tables.length === 0" class="my-2 mr-2 text-gray-600 text-xs italic">
                No tables available for this reservation.
            </div>
        </div>

    </div>
</template>

<script>

export default {
    name: "TablePicker",
    props: ["tables", "error"],
    data() {
        return {}
    },
    methods: {
        handleTableClick(tableId) {
        },
        isActive(tableId) {
        },
        getAsNumber(parent, val) {
            return parseInt(val);
        }
    },
}

</script>
