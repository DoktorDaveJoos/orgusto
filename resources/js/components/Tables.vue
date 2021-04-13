<template>
  <div>
    <div v-if="allTables.length > 0" class="w-full pl-4">
      <div class="mx-8">
        <div class="flex flex-row py-4">
          <div class="w-1/6">
            <orgastro-timepicker></orgastro-timepicker>
          </div>
          <div class="w-5/6 flex flex-row justify-between px-1 self-stretch">
            <orgusto-scope-button direction="left"></orgusto-scope-button>
            <orgusto-scope-button direction="right"></orgusto-scope-button>
          </div>
        </div>
      </div>

      <orgusto-timeline></orgusto-timeline>

      <orgusto-table v-for="table in allTables" :key="table.id" :table-id="table.id"></orgusto-table>

      <orgusto-modal-wrapper>
        <reservation-item></reservation-item>
      </orgusto-modal-wrapper>
    </div>

    <div v-else class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Whoops!
            </h3>
            <div class="mt-2 max-w-xl text-sm text-gray-500">
              <p>
                Du hast noch keine Tische angelegt. Lege jetzt deinen ersten Tisch an und starte durch!
              </p>
            </div>
            <div class="mt-3 text-sm">
              <a :href="`/restaurants/${restaurant.id}`" class="font-medium text-indigo-600 hover:text-indigo-500">
                Tisch anlegen <span aria-hidden="true">→</span></a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import store from '../store';
import {mapState} from 'vuex';

export default {
  name: 'orgusto-tables',
  store,
  data() {
    return {};
  },
  mounted() {
    this.$store.dispatch('loadUser');
  },
  computed: {
    ...mapState({
      user: state => state.user,
      allTables: state => state.restaurant.allTables,
      restaurant: state => state.restaurant.settings,
    }),
  },
};
</script>
