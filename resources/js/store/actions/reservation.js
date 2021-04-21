import {buildQueryParams} from '../shared/helper';
import {addHours, getHours} from 'date-fns';
import {ApiRoutes} from '../shared/routes';
import router from '../../router';

export default {
  proxyLoadReservations({dispatch}) {
    dispatch(router.currentRoute.name === 'tables' ? 'loadScoped' : 'loadPaginated');
  },

  loadPaginated({commit, state}, paginationLink = null) {
    const url = `${ApiRoutes.reservations}?${buildQueryParams(state, paginationLink).toString()}`;

    axios
      .get(url)
      .then(response => {
        const {data, links, meta} = response.data;
        commit('setPaginatedReservations', data, links, meta);
      })
      .catch(error => commit('setError', error));
  },

  loadScoped({commit, state}) {
    // TODO fix this timezone issue
    const hours = getHours(state.filter.timelineStart);
    const date = hours === 0 ? addHours(state.filter.timelineStart, 1) : state.filter.timelineStart;

    const query = {
      date: date.toISOString(),
    };

    const url = `${ApiRoutes.reservations}?${new URLSearchParams(query).toString()}&scoped=true`;

    axios
      .get(url)
      .then(response => {
        const {data} = response.data;
        commit('setReservations', data);
      })
      .catch(error => commit('setError', error));
  },

  setActiveReservation({dispatch, commit}, id) {
    commit('setActiveReservation', id);
    dispatch('loadAvailableTables');
  },

  updateReservation({commit, dispatch}, payload) {
    const {data} = payload;

    // mutate state
    commit('updateReservation', data);

    // getting tables if filter data is changed
    const filter = ['start', 'duration'];
    const key = Object.keys(data).pop();
    if (filter.includes(key)) {
      dispatch('loadAvailableTables');
    }
  },

  saveReservation({commit, dispatch, state}, reservation) {
    commit('clearReservationErrors');

    let payload = {
      ...reservation,
    };

    // remove user object
    delete payload.user;

    // set user_id
    payload.user_id = reservation.user?.id ? reservation.user.id : null;

    // map tables to table_id
    payload.tables = payload.tables.map(table => table.id);

    const putOrPost = payload.id ? axios.put : axios.post;

    putOrPost(`${ApiRoutes.reservations}${payload.id ? '/' + payload.id : ''}`, payload)
      .then(() => {
        // bring in sync
        dispatch('proxyLoadReservations');
        commit('closeModal');
      })
      .catch(error => commit('setReservationErrors', error));
  },

  markFulfilled({commit, state, dispatch}, data) {
    const consolidatedData = {
      id: data.id,
      data: {
        done: data.value,
      },
    };

    commit('setActiveReservation', data.id);
    commit('updateReservation', consolidatedData);

    const res = state.reservations.items.filter(item => item.id === data.id)[0];

    dispatch('saveReservation', res);
    commit('setActiveReservation', null);
  },

  showAllFullFilled({commit, dispatch, state}, val) {
    commit('showAllFullFilled', val);
    dispatch('proxyLoadReservations');
  },

  deleteReservation({dispatch, commit}, id) {
    axios
      .delete(`${ApiRoutes.reservations}/${id}`)
      .then(() => {
        commit('closeModal');
        dispatch('proxyLoadReservations');
      })
      .catch(error => commit('setError', error));
  },

  createNewReservation({commit, dispatch}, presSelectedDate = null) {
    commit('setNewReservation');
    // clicked on tables slot:
    if (presSelectedDate) {
      commit('updateReservation', {
        data: presSelectedDate,
      });
    }
    dispatch('loadAvailableTables');
    commit('openModal');
  },
};
