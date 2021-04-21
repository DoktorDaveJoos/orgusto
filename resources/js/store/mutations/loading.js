export default {
  setLoadingState(state, data) {
    state.loadingStates[data.indicator] = data.value;
  },
};
