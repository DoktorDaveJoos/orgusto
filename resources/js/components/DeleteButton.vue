<template>
  <button
    class="rounded-full border-2 text-gray-700 px-3 py-1 self-end hover:border-red-300 hover:text-red-500 text-sm font-light focus:no-underline focus:bg-red-400 focus:outline-none focus:shadow-outline"
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
