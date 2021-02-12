export default {
    loadPaginatedReservations({commit, state}, link = null) {


        // pagination
        const url = link ? link : '/reservations';

        const filterQuery = `${link ? '&' : '?'}done=${state.filter.showFulfilled ? 1 : 0}`;

        let fullUrl = url + filterQuery;

        if (state.filter.dateFilter.active) {

            const {start} = state.filter.dateRange;
            const startQuery = start ? `&from=${new Date(start).toISOString()}` : '';

            fullUrl = fullUrl + startQuery;

            if (state.filter.dateFilter.mode === "range") {
                const {end} = state.filter.dateRange;
                const endQuery = end ? `&to=${new Date(end).toISOString()}` : '';
                fullUrl = fullUrl + endQuery;
            }

        }

        axios.get(fullUrl)
            .then(response => {

                const {data} = response.data;
                const {links} = response.data;
                const {meta} = response.data;

                commit('loadReservations', data);
                commit('loadPaginationLinks', links);
                commit('loadMetaData', meta);

            })
    },

    doSearch({commit, state}) {

        const query = `?search=${state.search.query}&done=${state.filter.showFulfilled ? 1 : 0}`;

        axios.get(`/reservations/search${query}`).then(response => {

            console.log(response.data);

            const {data} = response.data;
            const {links} = response.data;
            const {meta} = response.data;

            commit('loadReservations', data);
            commit('loadPaginationLinks', links);
            commit('loadMetaData', meta);

        })

    },

    loadEmployees({commit}) {
        axios.get('/users')
            .then(response => {
                const {data} = response;
                commit('setEmployees', data);
            })
    },

    createNewReservation({commit, dispatch}) {

        commit('setNewReservation');

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
            value: true
        })

        const {activeReservationId} = state.modal;

        const reservation = activeReservationId
            ? state.reservations.items.find(res => res.id === state.modal.activeReservationId)
            : state.modal.newReservation;

        axios.get(`/tables?start=${reservation.start}&m=${reservation.duration}${activeReservationId ? '&r_id=' + activeReservationId : ''}`)
            .then(response => {

                const {data} = response;

                commit('setAvailableTables', data);

                commit('setLoadingState', {
                    indicator: 'tables',
                    value: false
                })
            })
    },

    updateReservation({commit, dispatch}, data) {

        // mutate state
        commit('updateReservation', data);

        // getting tables if filter data is changed
        const filter = ["start", "duration"];
        const key = Object.keys(data.data).pop();
        if (filter.includes(key)) {
            dispatch('loadAvailableTables');
        }

    },

    saveReservation({commit, dispatch, state}, reservation) {

        commit('clearErrors');

        let payload = {
            ...reservation
        };

        // remove user object
        delete payload.user;

        // set user_id
        payload.user_id = reservation.user?.id ? reservation.user.id : null;

        // map tables to table_id
        payload.tables = payload.tables.map(table => table.id);

        if (payload.id) {

            axios.put(`/reservations/${payload.id}`, payload)
                .then(() => {
                    // bring in sync
                    const activePaginationUrl = state.reservations.meta.links.filter(link => link.active)[0].url;
                    dispatch('loadPaginatedReservations', activePaginationUrl);
                    // close modal
                    commit('closeModal');
                })
                .catch(error => {
                    if (error.status === 422) {
                        commit('setErrors', error.response.data.errors);
                    } else {
                        commit('setErrors', {tables: error.response.data.message});
                    }

                })

        } else {

            axios.post(`/reservations`, payload)
                .then(() => {
                    // bring in sync
                    dispatch('loadPaginatedReservations');
                    // close modal
                    commit('closeModal');
                })
                .catch(error => {
                    if (error.status === 422) {
                        commit('setErrors', error.response.data.errors);
                    } else {
                        commit('setErrors', {tables: error.response.data.message});
                    }
                })

        }

    },

    closeModal({commit, dispatch}) {
        dispatch('loadPaginatedReservations');
        commit('closeModal');
        commit('clearErrors');
    },

    loadRestaurant({commit}) {

        axios.get('/restaurants')
            .then(response => {

                const {data} = response;

                axios.get(`/restaurants/${data[0].id}`)
                    .then(response => {
                        commit('setRestaurant', response.data);
                    })
            })

    },


    markFulfilled({commit, state, dispatch}, data) {

        const consolidatedData = {
            id: data.id,
            data: {
                done: data.value
            }
        }

        commit('setActiveReservation', data.id);
        commit('updateReservation', consolidatedData);

        const res = state.reservations.items.filter(item => item.id === data.id)[0];

        dispatch('saveReservation', res);
        commit('setActiveReservation', null);

    },

    showAllFullFilled({commit, dispatch, state}, val) {

        commit('showAllFullFilled', val);

        const activePaginationLink = state.reservations.meta.links.filter(link => link.active)[0].url;

        dispatch('loadPaginatedReservations', activePaginationLink);


    },

    activeDateFilter({commit, dispatch, state}, payload) {

        commit('setDateFilterActive', payload);
        commit('setDateRange', payload.dateRange);

        const activePaginationLink = state.reservations.meta.links.filter(link => link.active)[0].url;

        dispatch('loadPaginatedReservations', activePaginationLink);


    }


}
