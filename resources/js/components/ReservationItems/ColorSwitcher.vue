<template>
  <div>
    <button
      @click="setColor('red')"
      class="rounded-full h-8 w-8 bg-red-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="setColor('green')"
      class="rounded-full h-8 w-8 bg-green-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="setColor('blue')"
      class="rounded-full h-8 w-8 bg-blue-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="setColor('indigo')"
      class="rounded-full h-8 w-8 bg-indigo-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="setColor('purple')"
      class="rounded-full h-8 w-8 bg-purple-400 shadow-lg focus:outline-none"
    ></button>
    <button
      @click="setColor('gray')"
      class="rounded-full h-8 w-8 bg-gray-400 shadow-lg focus:outline-none"
    ></button>
  </div>
</template>

<script>
export default {
  props: ["setColor"]
};
</script>

<style>
</style>
