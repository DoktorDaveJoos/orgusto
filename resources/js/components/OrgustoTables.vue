<template>
    <div>

        <div class="w-full pl-4">
            <div class="mx-8">
                <div class="flex flex-row py-4">
                    <div class="w-1/6">
                        <orgastro-timepicker></orgastro-timepicker>
                    </div>
                    <div class="w-5/6 flex flex-row justify-between px-1 self-stretch">
                        <orgusto-scope-button direction="left"></orgusto-scope-button>
                        <orgusto-scope-button direction="right"></orgusto-scope-button>
                    </div>
                </div>
            </div>

            <orgusto-timeline></orgusto-timeline>

            <orgusto-table
                v-for="table in allTables"
                :key="table.id"
                :table-id="table.id"
            ></orgusto-table>

            <orgusto-modal-wrapper>
                <reservation-item
                ></reservation-item>
            </orgusto-modal-wrapper>
        </div>
    </div>
</template>

<script>

import store from '../store';
import {mapState} from 'vuex';

export default {
    name: "orgusto-tables",
    store,
    data() {
        return {};
    },
    mounted() {
      this.$store.dispatch('loadTables');
      this.$store.dispatch('loadEmployees');
      this.$store.dispatch('loadScopedReservations');
    },
    computed: {
        ...mapState({
            allTables: state => state.restaurant.allTables,
        })
    }
};
</script>
