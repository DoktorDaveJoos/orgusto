<template>
    <div class="p-4 pb-2 flex justify-between">
        <div class="flex flex-row space-x-4">
            <div v-if="error" class="text-red-400 flex items-center leading-tight">
                <i class="fas fa-times"></i>
            </div>
            <select-button value="today" :handle="setDatePicker" :selected="isSelected"></select-button>
            <select-button value="tomorrow" :handle="setDatePicker" :selected="isSelected"></select-button>
            <select-button value="day after tomorrow" :handle="setDatePicker" :selected="isSelected"></select-button>
        </div>
        <div>
            <v-date-picker v-model="singleDate" :popover="{ visibility: 'click' }">
                <select-button
                    :value="chosenDate !== '' ? chosenDate : 'Choose date'"
                    :selected="() => chosenDate !== ''"
                    icon="fas fa-calendar-alt"
                ></select-button>
            </v-date-picker>
        </div>
    </div>
</template>

<script lang="ts">

import Vue from 'vue';
import OrgustoDate from "../../models/OrgustoDate";

export default Vue.extend({
    props: {
        init: OrgustoDate,
        error: String
    },
    data() {
        return {
            datepicker: "",
            chosenDate: "",
            singleDate: this.init.asDate,
        };
    },
    mounted() {
        if (this.init) {
            if (this.init.isToday) {
                this.datepicker = "today";
            } else if (this.init.diffDaysFromNow === 1) {
                this.datepicker = "tomorrow";
            } else if (this.init.diffDaysFromNow === 2) {
                this.datepicker = "day after tomorrow";
            } else {
                this.chosenDate = this.init.readableDate;
            }
        } else {
            this.datepicker = "today";
        }
    },
    methods: {
        setDatePicker(indicator): void {
            this.chosenDate = "";
            this.datepicker = indicator;

            let date = OrgustoDate.default();
            if (indicator !== "today") {
                date = date.addDays(indicator === "tomorrow" ? 1 : 2);
            }

            this.setDate(date);
        },
        setDate(date: OrgustoDate): void {
            this.$emit("date:chosen", date);
        },
        isSelected(indicator): boolean {
            return this.datepicker === indicator;
        },
    },
    watch: {
        singleDate(newVal, _): void {
            const date = OrgustoDate.ofAny(newVal);
            this.datepicker = "";
            this.chosenDate = date.readableDate;
            this.setDate(date);
        },
    },
});
</script>
