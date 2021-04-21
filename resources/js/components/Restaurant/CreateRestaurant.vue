<template>
  <div
    v-show="isOpen"
    class="fixed z-10 inset-0 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
		<template v-if="createRestaurant"



    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!--
				Background overlay, show/hide based on modal state.

				Entering: "ease-out duration-300"
					From: "opacity-0"
					To: "opacity-100"
				Leaving: "ease-in duration-200"
					From: "opacity-100"
					To: "opacity-0"
			-->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <!--
				Modal panel, show/hide based on modal state.

				Entering: "ease-out duration-300"
					From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
					To: "opacity-100 translate-y-0 sm:scale-100"
				Leaving: "ease-in duration-200"
					From: "opacity-100 translate-y-0 sm:scale-100"
					To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
			-->
      <div
        class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6"
      >
        <div>
          <div class="mx-auto flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-600">
            <!-- Heroicon name: outline/check -->

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5 text-gray-600"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
              />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-5">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Neues Restaurant!
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Gib den Namen deines Restaurants ein.
              </p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-6">
          <div class="mb-5">
            <label for="restaurant_name" class="sr-only">Restaurant</label>
            <input
              v-model="name"
              type="text"
              name="restaurant_name"
              id="restaurant_name"
              class="shadow-sm block w-full sm:text-sm rounded-md"
              :class="
                showWarning
                  ? 'border-2 border-red-500'
                  : 'focus:ring-indigo-500 focus:border-indigo-500 border-gray-300'
              "
              placeholder="Dein Restaurant"
            />
            <div v-show="showWarning" class="text-xs text-red-500 mt-0.5">
              Gib einen Namen für dein Restaurant ein.
            </div>
          </div>
          <div class="flex space-x-4">
            <button
              @click="handleCreate"
              type="button"
              class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm"
            >
              Erstellen
            </button>
            <button
              @click="handleCancel"
              type="button"
              class="inline-flex justify-center w-full rounded-md border border-gray-200 shadow-sm px-4 py-2 text-base font-medium text-gray-800 hover:bg-gray-200 focus:outline-none sm:text-sm"
            >
              Abbrechen
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import store from '../../store';

export default {
  name: 'createRestaurant',
  store,
  props: ['isOpen'],
  data() {
    return {
      name: null,
      showWarning: false,
    };
  },
  methods: {
    handleCreate() {
      if (this.name != null) {
        this.$store.dispatch('createRestaurant', this.name);
      } else {
        this.showWarning = true;
      }
    },
    handleCancel() {
      this.name = '';
      this.showWarning = false;
      this.$emit('modal-close');
    },
  },
};
</script>

<style>
.half-circle-spinner,
.half-circle-spinner * {
  box-sizing: border-box;
}

.half-circle-spinner {
  width: 60px;
  height: 60px;
  border-radius: 100%;
  position: relative;
}

.half-circle-spinner .circle {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 100%;
  border: calc(60px / 10) solid transparent;
}

.half-circle-spinner .circle.circle-1 {
  border-top-color: #ff1d5e;
  animation: half-circle-spinner-animation 1s infinite;
}

.half-circle-spinner .circle.circle-2 {
  border-bottom-color: #ff1d5e;
  animation: half-circle-spinner-animation 1s infinite alternate;
}

@keyframes half-circle-spinner-animation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
