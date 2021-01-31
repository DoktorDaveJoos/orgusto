<template>
    <v-date-picker v-model="computedDate" :input-props="inputProps" :input-debounce="500"></v-date-picker>
</template>

<script>
import OrgustoDate from "../models/OrgustoDate";

export default {
    name: "orgastro-timepicker",
    props: {
        date: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            inputProps: {
                class:
                    "text-gray-600 shadow-lg rounded-full bg-gray-200 p-2 text-center w-full cursor-pointer self-center hover:text-gray-800 transition-color duration-200 ease-in-out"
            }
        };
    },
    computed: {
        computedDate: {
            get() {
                return new Date(this.date);
            },
            set(val) {
                if (!moment(this.date).isSame(moment(val), "date")) {
                    this.date = val;
                }
            }
        }
    },
    watch: {
        date: function (newDate, oldDate) {
            this.$bus.$emit("scopeEvent", {
                msg: "scope event",
                type: "date",
                value: OrgustoDate.ofString(newDate).format("yyyy-MM-dd")
            });
        }
    }
};
</script>
