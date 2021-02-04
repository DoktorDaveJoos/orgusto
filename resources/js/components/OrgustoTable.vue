<template>
    <div class="mx-8 my-4 shadow-lg rounded-full flex flex-row bg-white border-2 border-gray-400">
        <!-- Header -->
        <div
            class="w-1/6 rounded-l-full border-r border-gray-300 m-0 p-2 bg-gray-200 text-gray-600 flex flex-row"
        >
            <div class="w-1/2 text-center flex flex-col">
                <span class="uppercase leading-tight text-xs">Table</span>
                <span class="w-full text-center">{{ table.table_number }}</span>
            </div>
            <div class="w-1/2 text-center flex flex-col">
                <span class="uppercase leading-tight text-xs">Seats</span>
                <span class="w-full text-center">{{ table.seats }}</span>
            </div>
        </div>

        <!-- Body -->
        <div v-for="(n, i) in 20" :key="i" style="width: 4.166665%" class="flex flex-row">
            <div v-if="slotHasReservation(i)" class="m-0 flex flex-row w-full cursor-pointer"
                 @click="editReservationAt(i)"
            >
                <div v-if="isEdgeSlot(i) !== 0" class="m-0 flex flex-row w-full">
                    <div
                        v-if="isEdgeSlot(i) === 2"
                        :class="slotColorAndBorder(i)"
                        class="m-0 flex flex-row w-full"
                    >
            <span
                class="absolute overflow-x-visible text-gray-700 self-center pl-6 text-sm leading-tight z-0"
            >{{ getReservation(i).name }}</span>
                    </div>
                    <div
                        v-if="isEdgeSlot(i) === 1"
                        :class="slotColor(i)"
                        class="m-0 flex flex-row w-full rounded-r-full"
                    >&nbsp;
                    </div>
                </div>
                <div v-else :class="slotColor(i)" class="m-0 flex flex-row w-full">&nbsp;</div>
            </div>
            <div
                v-else
                class="p-0 switchChild flex w-full text-gray-300 hover:text-gray-400 cursor-pointer"
                @click="addNewReservationAt(i)"
            >
                <div class="self-center w-full text-center">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                <span class="w-full text-center hidden text-xs">{{ getTime(i) }}</span>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import OrgustoDate from "../models/OrgustoDate";
import Vue, {PropType} from "vue";

const SLOT_CONSTANTS = {
    FIRST: 0,
    LAST: 19
}

const SLOT_IDENT = {
    EDGE_START: 2,
    EDGE_END: 1,
    BETWEEN: 0
}

export default Vue.extend({
    name: "orgusto-table",
    props: {
        table: {
            type: Object,
            required: true,
        },
        tables: {
            type: Array,
            required: true,
        },
        slotClicked: Function,
        timelineStart: Object as PropType<OrgustoDate>,
    },
    methods: {
        slotHasReservation(slot: number): boolean {
            if (this.reservations.length === 0) {
                return false;
            }

            return this.getReservation(slot) !== undefined;
        },

        isEdgeSlot(slot: number): number {
            const reservation: any = this.getReservation(slot);

            const reservationStart = OrgustoDate.ofString(reservation.start);
            const reservationEnd = reservationStart.addMinutes(reservation.duration);
            const slotTime = this.timelineStart.addMinutes(slot * 15);

            // check if is start of reservation
            if (slotTime.isSame(reservationStart)) {
                return SLOT_IDENT.EDGE_START;
            }

            // check if is end of reservation
            if (slotTime.addMinutes(15).isSame(reservationEnd)) {
                return SLOT_IDENT.EDGE_END;
            }

            // is normal field
            return SLOT_IDENT.BETWEEN;
        },

        getReservation(slot: number): any | undefined {
            const slotTime = this.timelineStart.addMinutes(slot * 15);

            return this.reservationsArray.find(
                (reservation: any) => {

                    const reservationStart = OrgustoDate.ofString(reservation.start);
                    const reservationEnd = reservationStart.addMinutes(reservation.duration);

                    return slotTime.asDate >= reservationStart.asDate &&
                        slotTime.asDate < reservationEnd.asDate;
                });
        },

        slotColorAndBorder(slot: number): Array<string> {
            const reservation = this.getReservation(slot);

            return [
                reservation ? "bg-" + reservation.color + "-200" : "",
                slot === SLOT_CONSTANTS.FIRST ? "" : "rounded-l-full",
            ];
        },

        slotColor(slot): string {
            const reservation: any | undefined = this.getReservation(slot);

            const rounded_right = slot === SLOT_CONSTANTS.LAST ? " rounded-r-full" : "";
            return reservation ? "bg-" + reservation.color + "-200" : "" + rounded_right;
        },

        addNewReservationAt(slot: number): void {
            const slotTime = this.timelineStart.addMinutes(slot * 15);
            const reservation = this.getReservation(slot);

            this.slotClicked(this.table, slotTime, reservation);
        },
        editReservationAt(slot: number): void {
            const slotTime = this.timelineStart.addMinutes(slot * 15);
            const reservation = this.getReservation(slot);

            this.slotClicked(this.table, slotTime, reservation);
        },
        getTime(slot: number): string {
            return this.timelineStart.addMinutes(slot * 15).readableTime;
        },
    },
    computed: {
        reservations(): Array<any> {
            return this.table.reservations;
        },
        reservationsArray(): Array<any> {
            return Object.keys(this.reservations).map(
                (key) => this.reservations[key]
            );
        },
    },
});
</script>
