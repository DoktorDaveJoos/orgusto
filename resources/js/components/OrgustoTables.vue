<template>
  <div>
    <orgusto-table
      v-for="table in tables"
      :key="table.id"
      :table="table"
      :tables="tables"
      :slot-clicked="handleSlotClick"
      :timeline-start="timelineStart"
    ></orgusto-table>

    <orgusto-modal-wrapper :is-open="modalIsOpen" :handle-close="closeModal">
      <reservation-empty-item :table="table" :tables="tables" :date="date" :restaurant="restaurant">
        <template v-slot:optional-close>
          <button
            class="orgusto-button bg-gray-300 hover:bg-red-300 hover:text-gray-900 transition-color duration-200 ease-in-out w-full"
            @click="closeModal"
          >
            <i class="fas fa-ban"></i>
            cancel
          </button>
        </template>
      </reservation-empty-item>
    </orgusto-modal-wrapper>
  </div>
</template>

<script>
export default {
  name: "orgusto-tables",
  props: {
    tables: {
      type: Array,
      required: true
    },
    restaurant: {
      type: Object,
      required: true
    },
    timelineStart: String
  },
  data() {
    return {
      date: null,
      table: null,
      modalIsOpen: false
    };
  },
  methods: {
    handleSlotClick(table, date) {
      this.table = table;
      this.date = date;
      this.openModal();
    },
    closeModal() {
      this.modalIsOpen = false;
    },
    openModal() {
      this.modalIsOpen = true;
    }
  }
};
</script>
