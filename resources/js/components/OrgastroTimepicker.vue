<template>
  <vc-date-picker v-model="date" :input-props="inputProps" :input-debounce="500"></vc-date-picker>
</template>

<script>
export default {
  name: "orgastro-timepicker",
  data() {
    return {
      date: new Date(),
      inputProps: {
        class:
          "text-gray-600 rounded-full bg-gray-300 py-2 text-center w-full cursor-pointer self-center"
      }
    };
  },
  watch: {
    date: function(newDate, oldDate) {
      
      location.href = location.href + "&date=" + moment(newDate).format('YYYY-MM-DD');
    }
  }
};
</script>