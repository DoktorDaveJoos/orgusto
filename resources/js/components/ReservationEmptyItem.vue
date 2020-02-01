<template>
  <div class="w-8/12 self-center mb-2">
    <button
      v-if="!btnPressed"
      v-on:click="toggleBtnPressed"
      class="shadow-md rounded-full bg-blue-600 hover:bg-blue-900 text-white font-semibold px-2 py-1"
    >
      <i class="fas fa-plus mr-2"></i>
      Reservation
    </button>

    <div v-if="btnPressed" class="shadow-md mb-2 mt-2 rounded-lg hover:shadow-xl">
      <div class="w-full bg-gray-200 rounded-lg p-3 flex justify-between">
        <div class="inline-block font-bold text-sm text-gray-700">
          <button class="border border-grey-700 rounded-full focus:outline-none px-2">today</button>
        </div>
        <div>
          <button
            class="rounded-full bg-gray-600 text-white px-2 self-end hover:bg-green-600 mr-2 focus:no-underline focus:bg-green-400 focus:outline-none focus:shadow-outline"
            v-on:click="saveBtnPressed"
          >
            <i class="fas fa-save mr-1"></i>
            save
          </button>
          <button
            class="rounded-full bg-gray-600 text-white px-2 self-end hover:bg-red-600 mr-2 focus:no-underline focus:bg-red-400 focus:outline-none focus:shadow-outline"
          >
            <i class="fas fa-ban mr-1"></i>
            cancel
          </button>
        </div>
      </div>

      <div class="p-2">
        <div class="text-xl text-gray-700 mb-2">
          <input
            class="bg-gray-100 focus:outline-none"
            v-model="nameInputValue"
            placeholder="Some name or a group"
            type="text"
          />
        </div>
        <div class="text-gray-700 text-base mb-2">
          <textarea
            class="bg-gray-100 focus:outline-none"
            rows="2"
            resize="none"
            style="width: 100%"
            placeholder="Some further information"
            v-model="noticeInputValue"
          />
        </div>
        <div class="py-2">
          <span
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
          >From</span>
          <span
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
          >
            <i class="fas fa-hourglass"></i>
            time h
          </span>
          <span
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700"
          >
            <i class="fas fa-user-friends"></i>
            Amount Persons
          </span>
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
      noticeInputValue: ""
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
    }
  }
};
</script>
