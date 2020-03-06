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
        class: "text-gray-600 rounded-full bg-gray-300 text-center w-full pb-2 cursor-pointer"
      }
    };
  }
};
</script>