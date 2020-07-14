<template>
  <button
    @click="handle ? handle(value) : null"
    class="h-10 text-sm rounded-lg bg-gray-300 text-gray-600 leading-tight px-4 focus:outline-none hover:shadow-lg"
    :class="selected(value) ? 'border-2 border-indigo-400 text-gray-800 font-semibold shadow-lg' : ''"
  >
    {{ capitalized }}
    <i v-if="icon" :class="icon" class="ml-2"></i>
  </button>
</template>

<script>
export default {
  props: ["handle", "selected", "value", "icon"],
  computed: {
    capitalized() {
      if (isNaN(this.value)) {
        return this.value.charAt(0).toUpperCase() + this.value.slice(1);
      }
      return this.value;
    }
  }
};
</script>

<style>
</style>
