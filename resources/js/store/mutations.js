import {createEmptyReservation} from '../helper/helper';

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

        let res;
        if (state.modal.activeReservationId) {
            res = state.reservations.items.find(reservation => reservation.id === data.id);
        } else {
            res = state.modal.newReservation;
        }
        Object.keys(data.data).forEach(key => {
            console.log(key, data.data[key]);
            res[key] = data.data[key];
        });
    },

    setEmployees(state, data) {
        state.restaurant.users = data;
    },

    setAvailableTables(state, data) {
      state.restaurant.tables = data;
    },

    setActiveReservation(state, id) {
        state.modal.activeReservationId = id;
    },

    closeModal(state) {
        state.restaurant.tables = [];
        state.modal.activeReservationId = null;
        state.modal.isOpen = false;
    },

    openModal(state) {
        state.modal.isOpen = true;
    },

    setLoadingState(state, data) {
        state.loadingStates[data.indicator] = data.value;
    },

    setErrors(state, data) {
        state.reservations.errors = data;
    },

    setNewReservation(state) {
        state.modal.newReservation = createEmptyReservation();
    },

    clearErrors(state) {
        state.reservations.errors = {};
    },

    setRestaurant(state, data) {
        state.restaurant.settings = data.data;
    },
    updateSearchQuery(state, value) {
        state.search.query = value;
    },

    showAllFullFilled(state, value) {
        state.filter.showFulfilled = value;
    },

    setDateRange(state, value) {
        state.filter.dateRange = value;
    },

    setSingleDate(state, value) {
        state.filter.singleDate = value;
    },

    setDateFilterActive(state, payload) {
        state.filter.past = false;
        state.filter.dateFilter.mode = payload.mode;
        state.filter.dateFilter.active = payload.active;
    },

    setTables(state, payload) {
        state.restaurant.allTables = payload;
    },

    updateScope(state, payload) {
        state.filter.timelineStart = payload;
    }
}
