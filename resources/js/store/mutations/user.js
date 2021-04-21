export default {
  setUser(state, payload) {
    const {data} = payload.data;
    state.user = data;
  },
};
