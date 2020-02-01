<template>
  <div class="w-8/12 self-center mb-2">
    <button
      v-if="!btnPressed"
      v-on:click="toggleBtnPressed"
      class="shadow-md rounded-full bg-blue-600 hover:bg-blue-900 text-white px-3 py-1"
    >
      <i class="fas fa-plus mr-2"></i>
      Reservation
    </button>

    <div v-if="btnPressed" class="shadow-md mb-2 mt-2 rounded-lg hover:shadow-xl">
      <div class="w-full bg-gray-200 rounded-lg p-3 flex justify-between">
        <div class="flex flex">
          <div class="font-bold text-sm text-gray-700 self-center mr-2">
            <i class="fas fa-clock self-center"></i>
          </div>

          <div class="relative w-24 self-center">
            <select
              class="block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-sm text-gray-700 py-2 px-2 pr-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="date"
            >
              <option>Today</option>
              <option>Tomorrow</option>
              <option>Other</option>
            </select>
            <div
              class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
            >
              <svg
                class="fill-current h-4 w-4"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
              >
                <path
                  d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                />
              </svg>
            </div>
          </div>
        </div>

        <div>
          <button
            class="rounded-full border-2 text-gray-700 px-3 py-1 self-end hover:border-green-300 hover:text-green-500 text-sm font-light focus:no-underline focus:bg-red-400 focus:outline-none focus:shadow-outline"
            v-on:click="saveBtnPressed"
          >
            <i class="fas fa-save mr-1"></i>
            save
          </button>
          <button
            class="rounded-full border-2 text-gray-700 px-3 py-1 self-end hover:border-red-300 hover:text-red-500 text-sm font-light focus:no-underline focus:bg-red-400 focus:outline-none focus:shadow-outline"
          >
            <i class="fas fa-ban mr-1"></i>
            cancel
          </button>
        </div>
      </div>

      <div class="p-4">
        <div class="text-xl text-gray-700 mb-2">
          <input
            class="focus:outline-none"
            v-model="nameInputValue"
            placeholder="Some name or a group"
            type="text"
          />
        </div>
        <div class="text-gray-700 text-base mb-2">
          <textarea
            class="focus:outline-none"
            rows="2"
            resize="none"
            style="width: 100%"
            placeholder="Some further information"
            v-model="noticeInputValue"
          />
        </div>

        <div class="flex">
          <orgastro-dropdown title="Persons" options="20"></orgastro-dropdown>

          <orgastro-dropdown title="Duration" options="8"></orgastro-dropdown>

          <orgastro-dropdown title="Employee" :options="users"></orgastro-dropdown>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "reservation-empty-item",
  data: function() {
    return {
      btnPressed: false,

      nameInputValue: "",
      noticeInputValue: "",

      btnTodayIsActive: true,
      btnTmrwIsActive: false,
      btnOtherIsActive: false,

      users: ["Felix Forstenhäusler", "David Joos"]
    };
  },
  methods: {
    toggleBtnPressed: function() {
      this.btnPressed = !this.btnPressed;
    },
    toggleNameClicked: function() {
      this.nameClicked = !this.nameClicked;
    },
    saveBtnPressed: function() {
      console.log(this.nameInputValue, this.noticeInputValue);
    },
    btnTodayPressed: function() {
      this.btnTodayIsActive = true;
      this.btnTmrwIsActive = false;
      this.btnOtherIsActive = false;
    },
    btnTmrwPressed: function() {
      this.btnTodayIsActive = false;
      this.btnTmrwIsActive = true;
      this.btnOtherIsActive = false;
    },
    btnOtherPressed: function() {
      this.btnTodayIsActive = false;
      this.btnTmrwIsActive = false;
      this.btnOtherIsActive = true;
    }
  }
};
</script>
