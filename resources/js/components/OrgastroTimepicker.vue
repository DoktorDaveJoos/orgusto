<template>
    <v-date-picker v-model="computedDate" :input-props="inputProps" :input-debounce="500"></v-date-picker>
</template>

<script>
import OrgustoDate from "../models/OrgustoDate";

export default {
    name: "orgastro-timepicker",
    props: {
        date: String
    },
    data() {
        return {
            inputProps: {
                class:
                    "text-gray-600 shadow-lg rounded-full bg-gray-200 p-2 text-center w-full cursor-pointer self-center hover:text-gray-800 transition-color duration-200 ease-in-out"
            },
        };
    },
    computed: {
        computedDate: {
            get() {
                return new Date(this.date);
            },
            set(val) {

                // const date = OrgustoDate.ofString(val).addMinutes(new Date().getTimezoneOffset() * (-1));
                const date = OrgustoDate.ofString(val);

                // Normalize Timezone due to missing timezone support in v-date-picker:
                // const timeZoneNormalizedDate = parsedVal.asDate.getTimezoneOffset() < 0 ? parsedVal.addDays(1) : parsedVal;

                if (!date.isSameDay(OrgustoDate.ofString(this.date).asDate)) {
                    this.$bus.$emit("scopeEvent", {
                        msg: "scope event",
                        type: "date",
                        value: date.asISO
                    });
                }
            }
        }
    },
};
</script>
