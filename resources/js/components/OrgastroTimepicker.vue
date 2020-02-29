<template>
  <div class="flex flex-col">
    <div class="text-left text-sm text-gray-600 font-thin text-center bg-gray-300 rounded-t-lg">
      <span class="w-1/3">Date</span>
    </div>
    <vc-date-picker v-model="date" :input-props="inputProps" :input-debounce="500"></vc-date-picker>
  </div>
</template>

<script>
export default {
  name: "orgastro-timepicker",
  data() {
    return {
      date: new Date(),
      inputProps: {
        class: "text-gray-600 rounded-b-lg bg-gray-300 text-center w-full pb-2 cursor-pointer"
      }
    };
  }
};
</script>