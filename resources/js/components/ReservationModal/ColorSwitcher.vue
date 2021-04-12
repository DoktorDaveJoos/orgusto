<template>
  <div class="flex flex-row items-center space-x-2">
    <button
      @click="handle({color: 'red'})"
      class="rounded-full h-8 w-8 bg-red-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="handle({color: 'green'})"
      class="rounded-full h-8 w-8 bg-green-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="handle({color: 'blue'})"
      class="rounded-full h-8 w-8 bg-blue-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="handle({color: 'indigo'})"
      class="rounded-full h-8 w-8 bg-indigo-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="handle({color: 'gray'})"
      class="rounded-full h-8 w-8 bg-gray-400 shadow-lg focus:outline-none"
    ></button>
  </div>
</template>

<script>
export default {
  name: 'ColorSwitcher',
  methods: {
    handle(data) {
      this.$emit('value:changed', data);
    },
  },
};
</script>

<style></style>
