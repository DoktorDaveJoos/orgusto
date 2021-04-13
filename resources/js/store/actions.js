import {isSameDay, getHours, addHours} from 'date-fns';
import router from '../router';
const Routes = {
  reservations: '/api/reservations',
  user: '/api/user',
  users: '/api/users',
  tables: '/api/tables',
  restaurants: '/api/restaurants',
};

const DoneMapping = {
  true: 1,
  false: 0,
};

const buildQueryParams = (state, newPageLink = null) => {
  // fixed query params
  const params = {
    done: DoneMapping[state.filter.showFulfilled],
    past: DoneMapping[state.filter.past],
    search: state.search.query,
  };

  // optional filter
  if (state.filter.dateFilter.active) {
    if (state.filter.dateFilter.mode === 'range') {
      const {start, end} = state.filter.dateRange;
      params.from = start.toISOString();
      // TODO fix timezone issue
      const consolidatedTo = addHours(end, 1);
      params.to = consolidatedTo.toISOString();
    }
    if (state.filter.dateFilter.mode === 'single') {
      const {singleDate} = state.filter;
      params.from = singleDate.toISOString();
    }
  }

  // if no search query -> apply pagination
  if (state.search.query.length === 0) {
    if (newPageLink) {
      params.page = buildPaginationParams(newPageLink).get('page');
    } else if (state.reservations.meta.links?.find(link => link.active)) {
      const activePage = state.reservations.meta.links.find(link => link.active);
      params.page = buildPaginationParams(activePage.url).get('page');
    }
  }

  return new URLSearchParams(params);
};

const buildPaginationParams = url => {
  const parsed = new URL(url);
  return new URLSearchParams(parsed.search);
};

export default {
  loadState({dispatch}) {
    dispatch('loadUser');
    dispatch('loadRestaurants');
    dispatch('loadReservations');
  },

  loadUser({commit}) {
    axios.get(Routes.user).then(response => {
      commit('setUser', response.data);
    });
  },

  loadReservationsProxy({dispatch}) {
    const isTables = location.href.includes(Routes.tables);
    if (isTables) {
      dispatch('loadScopedReservations');
    } else {
      dispatch('loadPaginatedReservations');
    }
  },

  loadPaginatedReservations({commit, state}, paginationLink = null) {
    const url = `${Routes.reservations}?${buildQueryParams(state, paginationLink).toString()}`;

    axios.get(url).then(response => {
      const {data} = response.data;
      const {links} = response.data;
      const {meta} = response.data;

      commit('loadReservations', data);
      commit('loadPaginationLinks', links);
      commit('loadMetaData', meta);
    });
  },

  loadScopedReservations({commit, state}) {
    // TODO fix this timezone issue
    const hours = getHours(state.filter.timelineStart);
    const date = hours === 0 ? addHours(state.filter.timelineStart, 1) : state.filter.timelineStart;

    const query = {
      date: date.toISOString(),
    };

    const url = Routes.reservations + '?' + new URLSearchParams(query).toString() + '&scoped=true';

    axios.get(url).then(response => {
      commit('loadReservations', response.data.data);
    });
  },

  loadTables({commit}) {
    axios.get(Routes.tables).then(response => {
      commit('setTables', response.data.data);
    });
  },

  deleteReservation({dispatch, commit}, id) {
    axios.delete(`${Routes.reservations}/${id}`).then(() => {
      commit('closeModal');
      dispatch('loadReservationsProxy');
    });
  },

  createNewReservation({commit, dispatch}, preSelected) {
    commit('setNewReservation');
    if (preSelected) {
      commit('updateReservation', {
        data: preSelected,
      });
    }
    dispatch('loadAvailableTables');
    commit('openModal');
  },

  setActiveReservation({dispatch, commit}, id) {
    commit('setActiveReservation', id);
    dispatch('loadAvailableTables');
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
      ? state.reservations.items.find(res => res.id === state.modal.activeReservationId)
      : state.modal.newReservation;

    const existingReservationQuery = activeReservationId ? `&r_id=${activeReservationId}` : '';
    const url = Routes.tables + `?start=${reservation.start}&m=${reservation.duration}` + existingReservationQuery;

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
          location.reload();
        }
      });
  },

  updateReservation({commit, dispatch}, data) {
    // mutate state
    commit('updateReservation', data);

    // getting tables if filter data is changed
    const filter = ['start', 'duration'];
    const key = Object.keys(data.data).pop();
    if (filter.includes(key)) {
      dispatch('loadAvailableTables');
    }
  },

  saveReservation({commit, dispatch, state}, reservation) {
    commit('clearErrors');

    let payload = {
      ...reservation,
    };

    // remove user object
    delete payload.user;

    // set user_id
    payload.user_id = reservation.user?.id ? reservation.user.id : null;

    // map tables to table_id
    payload.tables = payload.tables.map(table => table.id);

    if (payload.id) {
      axios
        .put(Routes.reservations + `/${payload.id}`, payload)
        .then(() => {
          // bring in sync
          dispatch('loadReservationsProxy');
          // close modal
          commit('closeModal');
        })
        .catch(error => {
          commit('setErrors', error);
        });
    } else {
      axios
        .post(Routes.reservations, payload)
        .then(() => {
          // bring in sync
          dispatch('loadReservationsProxy');
          // close modal
          commit('closeModal');
        })
        .catch(error => {
          commit('setErrors', error);
        });
    }
  },

  closeModal({commit, dispatch}) {
    dispatch('loadReservationsProxy');
    commit('closeModal');
    commit('clearErrors');
  },

  loadRestaurants({commit}) {
    axios
      .get(Routes.restaurants)
      .then(response => {
        commit('setRestaurants', response.data);
      })
      .catch(() => router.push('restaurants'));
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
    dispatch('loadReservationsProxy');
  },

  activateRangeFilter({commit, dispatch, state}, payload) {
    commit('setDateFilterActive', payload);
    commit('setDateRange', payload.dateRange);
    dispatch('loadReservationsProxy');
  },

  activateSingleDateFilter({commit, dispatch, state}, payload) {
    commit('setDateFilterActive', payload);
    commit('setSingleDate', payload.singleDate);
    dispatch('loadReservationsProxy');
  },

  updateScope({commit, state, dispatch}, payload) {
    if (!isSameDay(payload, state.filter.timelineStart)) {
      commit('updateScope', payload);
      dispatch('loadReservationsProxy');
    } else {
      commit('updateScope', payload);
    }
  },
};
