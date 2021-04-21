import {createEmptyReservation} from '../../helper/helper';

export default {
  // Paginated
  setPaginatedReservations(state, items, links, meta) {
    state.restaurant.reservations.items = items;
    state.restaurant.reservations.links = links;
    state.restaurant.reservations.meta = meta;
  },

  setReservations(state, items) {
    state.restaurant.reservations.items = items;
  },

  setPaginationLinks(state, paginationLinks) {
    state.restaurant.reservations.links = paginationLinks;
  },

  setMetaData(state, meta) {
    state.restaurant.reservations.meta = meta;
  },

  setActiveReservation(state, id) {
    state.modal.activeReservationId = id;
  },

  setNewReservation(state) {
    state.modal.newReservation = createEmptyReservation();
  },

  updateReservation(state, data) {
    const {activeReservationId} = state.modal;

    let res = activeReservationId
      ? state.restaurant.reservations.items.find(reservation => reservation.id === data.id)
      : state.modal.newReservation;

    Object.keys(data).forEach(key => {
      res[key] = data[key];
    });
  },

  clearReservationErrors(state) {
    state.restaurant.reservations.errors = {};
  },

  setReservationErrors(state, error) {
    if (error.response.status === 422) {
      state.restaurant.reservations.errors = error.response.data.errors;
    } else if (error.response.status === 400) {
      state.restaurant.reservations.errors = {
        tables: error.response.data.message,
      };
    } else if (error.response.status === 401) {
      // logout
      location.reload();
    }
  },
};
