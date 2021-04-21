export default {
  closeModal(state) {
    state.modal.activeReservationId = null;
    state.restaurant.tables = [];
    state.modal.isOpen = false;
  },

  openModal(state) {
    state.modal.isOpen = true;
  },
};
