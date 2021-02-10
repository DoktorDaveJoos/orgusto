export default {

    loadReservations(state, items) {
        state.reservations.items = items;
    },

    loadPaginationLinks(state, paginationLinks) {
        state.reservations.links = paginationLinks;
    },

    loadMetaData(state, meta) {
        state.reservations.meta = meta;
    },

    updateReservation(state, data) {
        let res = state.reservations.items.find(reservation => reservation.id === data.id);
        Object.keys(data.data).forEach(key => {
            res[key] = data.data[key];
        });
    },

    setEmployees(state, data) {
        state.restaurant.users = data;
    },

    setActiveReservation(state, id) {
        state.modal.activeReservationId = id;
    },

    closeModal(state) {
        state.modal.activeReservationId = null;
        state.modal.isOpen = false;
    },

    openModal(state) {
        state.modal.isOpen = true;
    }
}
