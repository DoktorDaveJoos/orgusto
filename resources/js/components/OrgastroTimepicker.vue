<template>
  <vc-date-picker v-model="computedDate" :input-props="inputProps" :input-debounce="500"></vc-date-picker>
</template>

<script>
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
          "text-gray-600 rounded-full bg-gray-300 py-2 text-center w-full cursor-pointer self-center"
      }
    };
  },
  computed: {
    computedDate: {
      get () {
        return new Date(this.date);
      },
      set (val) {
        if (!moment(this.date).isSame(moment(val), 'date')) {
          this.date = val;
        } 
      }
    }
  },
  watch: {
    date: function(newDate, oldDate) {
      this.$bus.$emit("scopeEvent", {
        msg: "scope event",
        type: "date",
        value: moment(newDate).format("YYYY-MM-DD")
      })
    }
  }
};
</script>