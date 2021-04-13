<template>
  <div>
    <nav class="flex justify-center bg-gray-200 shadow-md sticky top-0 z-50 h-20">
      <div class="max-w-6xl w-full flex flex-row justify-between content-center">
        <div class="flex flex-row items-center">
          <router-link to="reservations">
            <img class="w-32" src="img/orgusto-logo-svg.svg" />
          </router-link>
        </div>

        <div class="flex items-center">
          <!--        @if(auth()->user()->restaurants->count() > 1 || (!auth()->user()->selected &&-->
          <!--        auth()->user()->restaurants->count() >= 1))-->
          <!--        <x-restaurant-switcher></x-restaurant-switcher>-->
          <!--        @endif @if(auth()->user()->restaurants->count() >= 1)-->
          <router-link
            to="/reservations"
            class="px-6 py-3 ml-6 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out font-semibold text-indigo-600"
          >
            <i class="text-lg text-center far fa-calendar"></i>
            <span class="text-xs pt-1">Reservierungen</span>
          </router-link>

          <router-link
            to="/tables"
            class="px-6 py-3 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out font-semibold text-indigo-600"
          >
            <i class="text-lg text-center fa fa-stream"></i>
            <span class="text-xs pt-1">Tische</span>
          </router-link>
        </div>

        <div class="flex flex-row items-center">
          <div class="mx-auto text-right">
            <div class="relative inline-block text-left">
              <div>
                <button
                  @click="pane.open = !pane.open"
                  type="button"
                  class="inline-flex items-center justify-center w-full px-4 py-4 text-sm font-medium text-gray-700 focus:outline-none"
                  id="options-menu"
                  aria-haspopup="true"
                  aria-expanded="true"
                >
                  <img class="w-8 mr-2" src="img/user-icon.svg" />
                  {{ user.name }}
                  <svg
                    class="-mr-1 ml-2 h-5 w-5"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </button>
              </div>

              <div
                v-show="pane.open"
                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
              >
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                  <router-link
                    :to="'/users/' + user.id"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >Profil
                  </router-link>

                  <router-link
                    class="group block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    to="/restaurants"
                  >
                    Restaurants
                  </router-link>

                  <a
                    class="group block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    href="/logout"
                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"
                  >
                    Logout
                  </a>

                  <form id="logout-form" action="/logout" method="POST" class="hidden">@csrf</form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <router-view></router-view>
  </div>
</template>

<script>
import store from '../store';
import {mapState} from 'vuex';

export default {
  name: 'App',
  data() {
    return {
      pane: {
        open: false,
      },
    };
  },
  store,
  mounted() {
    this.$store.dispatch('loadUser');
  },
  computed: mapState(['user']),
};
</script>
