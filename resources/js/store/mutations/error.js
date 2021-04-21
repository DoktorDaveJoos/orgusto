export default {
  setError({state}, error) {
    state.error.hasError = true;
    state.error.errorMsg = error.message;
  },

  clearError({state}) {
    state.error.hasError = false;
    state.error.errorMsg = null;
  },
};
