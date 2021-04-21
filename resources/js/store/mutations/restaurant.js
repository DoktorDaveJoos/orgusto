export default {
  setAvailableTables(state, data) {
    state.restaurant.tables = data;
  },

  setRestaurants(state, data) {
    state.restaurants = data;
  },

  setTables(state, payload) {
    state.restaurant.allTables = payload;
  },

  updateSelectedRestaurant(state, payload) {
    state.selectedRestaurant = JSON.parse(payload);
  },
};
