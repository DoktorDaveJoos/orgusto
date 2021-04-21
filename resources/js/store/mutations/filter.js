export default {
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

  updateScope(state, payload) {
    state.filter.timelineStart = payload;
  },
};
