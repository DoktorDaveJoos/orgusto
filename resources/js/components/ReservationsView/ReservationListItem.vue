<template>
    <tr @click="handleItemClicked" class="border border-b border-gray-200 cursor-pointer"
        :class="hoverColor">
        <td class="px-4 py-2 border-l-8" :class="borderColor">
            <div class="flex flex-col">
                <span class="text-gray-900 text-sm">{{ reservation.name }}</span>
                <span class="text-gray-600 text-xs italic">{{ reservation.notice }}</span>
            </div>
        </td>
        <td class="px-4">
            <div class="flex flex-row">
                <div
                    class="flex flex-row whitespace-nowrap items-center shadow-md text-white leading-tight text-xs rounded-full py-1 px-3"
                    :class="pillColor">
                    <i class="fas fa-calendar-day pr-1"></i>
                    {{ new Date(reservation.start).toLocaleString() }}
                </div>
            </div>
        </td>
        <td class="px-4">
            <div class="flex flex-row">
                <div
                    class="flex flex-row items-baseline shadow-md text-white leading-tight text-xs r rounded-full py-1 px-3"
                    :class="pillColor">
                    <i class="fas fa-clock pr-1"></i>
                    {{ reservation.duration / 60 }}h
                </div>
            </div>
        </td>
        <td class="pl-4 pr-2">
            <div class="flex flex-row items-center flex-wrap">
                <div></div>
                <div v-for="table in reservation.tables"
                     class="flex flex-row items-center shadow-md text-white leading-tight text-xs rounded-full py-1 px-3 m-0.5"
                     :class="pillColor"
                >{{ table.table_number }}
                </div>

            </div>
        </td>
        <td class="px-4">
            <div class="flex flex-row">
                <div
                    class="flex flex-row items-center shadow-md text-white leading-tight text-xs r rounded-full py-1 px-3"
                    :class="pillColor">
                    <i class="fas fa-user-friends pr-1"></i>
                    {{ reservation.persons }}
                </div>
            </div>
        </td>
        <td class="px-4">
            <div v-if="reservation.email" class="flex flex-row items-baseline leading-tight text-xs text-gray-600">
                <i class="fas fa-envelope pr-1"></i>
                {{ reservation.email }}
            </div>
        </td>
        <td class="px-4">
            <div v-if="reservation.phone_number"
                 class="flex flex-row items-baseline leading-tight text-xs text-gray-600">
                <i class="fas fa-phone-alt pr-1"></i>
                {{ reservation.phone_number }}
            </div>

        </td>
        <th>
            <input id="isDone" v-model="reservation.done" name="fulfilled" type="checkbox"
                   @click="handleMarkFulfilled"
                   @click.stop="stopEvent"
                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer">
        </th>


    </tr>


</template>

<script>

import store from '../../store';

export default {
    name: "ReservationListItem",
    store,
    props: ["reservation"],
    data() {
        return {
            open: false
        }
    },
    methods: {
        handleItemClicked() {
            this.$store.dispatch('setActiveReservation', this.reservation.id);
            this.$store.commit('openModal');
        },
        stopEvent(event) {
            event.stopPropagation();
        },
        handleMarkFulfilled() {
            this.$store.dispatch('markFulfilled', {id: this.reservation.id, value: !this.reservation.done})
        }
    },
    computed: {
        borderColor() {
            return `border-${this.reservation.color}-400`;
        },
        hoverColor() {
            return `hover:bg-${this.reservation.color}-100`;
        },
        pillColor() {
            return `bg-${this.reservation.color}-600`
        },
    }
}
</script>

<style scoped>

</style>
