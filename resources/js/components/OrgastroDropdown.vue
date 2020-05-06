<template>
  <div class="w-full md:w-1/3 m-2">
    <label
      v-if="title"
      class="uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
    >{{ title }}</label>
    <div class="relative" :class="containerClass">
      <select
        :id="id"
        class="appearance-none cursor-pointer w-full text-gray-700 font-semibold text-sm py-2 px-4 pr-8 rounded focus:outline-none"
        :class="additionalClasses"
        @change="reset ? resetMiddleware($event, reset, onChange) : onChange($event)"
      >
        <option v-if="init" :value="init">{{ init }} {{ unit && init !== '-' ? unit : null }}</option>
        <option
          v-for="option in parseOptions(options)"
          v-bind:key="option instanceof Object ? option.id : option"
          :id="option instanceof Object ? JSON.stringify(option) : option"
          :value="operation ? operation(option) : option"
        >{{ operation ? operation(option) : option }} {{ unit ? unit : null }}</option>
      </select>

      <div
        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
      >
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "orgastro-dropdown",
  props: {
    id: {
      type: String,
      required: true
    },
    init: {
      required: false
    },
    options: {
      required: true
    },
    title: {
      type: String,
      required: false
    },
    unit: {
      type: String,
      required: false
    },
    operation: {
      type: Function,
      required: false
    },
    onChange: {
      type: Function,
      required: true
    },
    reset: {
      type: String
    },
    additionalClasses: {
      type: String
    },
    containerClass: {
      type: String
    },
    parseMiddleware: {
      type: Function
    }
  },
  methods: {
    parseOptions: options => {
      return options instanceof Array ? options : parseInt(options);
    },
    resetMiddleware: (event, reset, thenApply) => {
      const tmp = event.target.options[event.target.selectedIndex].id;
      event.target.value = reset;
      thenApply(tmp);
    }
  }
};
</script>
