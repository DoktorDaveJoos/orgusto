<template>
    <div>
        <orgusto-table
            v-for="table in tables"
            :key="table.id"
            :table="table"
            :tables="tables"
            :slot-clicked="handleSlotClick"
            :timeline-start="formattedTimelineStart"
        ></orgusto-table>

        <orgusto-modal-wrapper :is-open="modalIsOpen" :handle-close="closeModal">
            <reservation-item
                v-on:modal:close="closeModal"
                :reservation="reservation"
                :time="this.date"
                :table="this.table"
                :tables-endpoint="tablesEndpoint"
                :reservations-endpoint="reservationsEndpoint"
            ></reservation-item>
        </orgusto-modal-wrapper>
    </div>
</template>

<script>

import OrgustoDate from "../models/OrgustoDate";
import Reservation from "../models/Reservation";

export default {
    name: "orgusto-tables",
    props: {
        tables: {
            type: Array,
            required: true
        },
        employees: {
            type: Array,
            required: true
        },
        tablesEndpoint: String,
        reservationsEndpoint: String,
        timelineStart: String
    },
    data() {
        return {
            date: null,
            table: null,
            reservation: null,
            modalIsOpen: false
        };
    },
    methods: {
        handleSlotClick(table, date, reservation) {
            this.reservation = reservation ? Reservation.of(reservation) : reservation;
            this.table = table;
            this.date = date;
            this.openModal();
        },
        closeModal() {
            this.modalIsOpen = false;
        },
        openModal() {
            this.modalIsOpen = true;
        }
    },
    computed: {
        formattedTimelineStart() {
            return OrgustoDate.ofAny(this.timelineStart);
        }
    }
};
</script>
