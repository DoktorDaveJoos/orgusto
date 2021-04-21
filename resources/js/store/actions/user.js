import {ApiRoutes} from '../shared/routes';

export default {
  loadUser({commit}) {
    axios
      .get(ApiRoutes.user)
      .then(response => {
        commit('setUser', response.data);
      })
      .catch(error => {
        commit('setError', error);
      });
  },
};
