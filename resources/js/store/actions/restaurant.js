import {ApiRoutes, AppRoutes} from '../shared/routes';
import router from '../../router';

export default {
  createRestaurant({commit, dispatch}, restaurantName) {
    axios
      .post(ApiRoutes.restaurants, {
        name: restaurantName,
      })
      .then(res => {
        dispatch('loadRestaurants');
        router.push({path: `${AppRoutes.restaurants}/${res.data.id}`});
      })
      .catch(error => commit('setError', error));
  },

  loadAvailableTables({commit, state}) {
    // remove all tables
    commit('setAvailableTables', []);

    commit('setLoadingState', {
      indicator: 'tables',
      value: true,
    });

    const {activeReservationId} = state.modal;

    const reservation = activeReservationId
      ? state.restaurant.reservations.items.find(res => res.id === state.modal.activeReservationId)
      : state.modal.newReservation;

    const existingReservationQuery = activeReservationId ? `&r_id=${activeReservationId}` : '';
    const url = `${ApiRoutes.tables}?start=${reservation.start}&m=${reservation.duration}${existingReservationQuery}`;

    axios
      .get(url)
      .then(response => {
        const {data} = response;

        commit('setAvailableTables', data);

        commit('setLoadingState', {
          indicator: 'tables',
          value: false,
        });
      })
      .catch(error => {
        if (error.status === 401) {
          // logout
          location.reload();
        } else {
          commit('setError', error);
        }
      });
  },

  loadRestaurants({commit}) {
    axios
      .get(ApiRoutes.restaurants)
      .then(response => {
        const {data} = response.data;
        commit('setRestaurants', data);
      })
      .catch(error => commit('setError', error));
  },

  loadTables({commit}) {
    axios
      .get(ApiRoutes.tables)
      .then(response => {
        const {data} = response.data;
        commit('setTables', data);
      })
      .catch(error => commit('setError', error));
  },
};
