import {isSameDay} from 'date-fns';

export default {
  activateRangeFilter({commit, dispatch, state}, payload) {
    commit('setDateFilterActive', payload);
    commit('setDateRange', payload.dateRange);
    dispatch('proxyLoadReservations');
  },

  activateSingleDateFilter({commit, dispatch, state}, payload) {
    commit('setDateFilterActive', payload);
    commit('setSingleDate', payload.singleDate);
    dispatch('proxyLoadReservations');
  },

  updateScope({commit, state, dispatch}, payload) {
    if (!isSameDay(payload, state.filter.timelineStart)) {
      commit('updateScope', payload);
      dispatch('proxyLoadReservations');
    } else {
      commit('updateScope', payload);
    }
  },
};
