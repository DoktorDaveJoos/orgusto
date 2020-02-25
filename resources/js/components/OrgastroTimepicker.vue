<template>
  <div class="sticky top-0 p-2">
    <vc-calendar v-model="this.attributes"></vc-calendar>
  </div>
</template>

<script>
export default {
  name: "orgastro-timepicker",
  data() {
    return {
      attributes: [
        {
          key: "today",
          highlight: true,
          dates: new Date()
        }
      ]
    };
  }
};
</script>