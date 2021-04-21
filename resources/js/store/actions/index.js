import restaurant from './restaurant';
import filter from './filter';
import user from './user';

export default {
  loadState({dispatch}) {
    dispatch('loadUser');
    dispatch('loadRestaurants');
    dispatch('proxyLoadReservations');
  },

  closeModal({commit, dispatch}) {
    dispatch('proxyLoadReservations');
    commit('closeModal');
    commit('clearErrors');
  },

  filter,
  restaurant,
  user,
};
