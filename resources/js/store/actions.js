export default {
    loadPaginatedReservations({commit}) {
        axios.get('/reservations')
            .then(response => {

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

    updateReservation({commit}, data) {

        console.log(data);

        // mutate state

        commit('updateReservation', data);

        // sync backend


    },

    saveReservation({commit}, reservation) {

        axios.put(`/reservations/${reservation.id}`, reservation)
            .then(() => { console.log('happy af') })


    },


}
