<template>
  <button
    class="rounded-full bg-gray-600 text-white px-2 self-end hover:bg-red-600 focus:no-underline focus:bg-red-400 focus:outline-none focus:shadow-outline"
    v-on:click="deleteReservationWithId"
  >
    <i class="fas fa-trash-alt"></i>
    delete
  </button>
</template>

<script>
export default {
  name: "delete-button",
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  methods: {
    deleteReservationWithId: function() {
      axios
        .delete("/reservations/" + this.id)
        .then(res => res.status == 200 ? window.location.reload() : null)
        .catch(err => alert(err.message));
    }
  }
};
</script>
