<div x-data="{ open: true }" x-show="open" class="flex flex-row items-center justify-between bg-purple-600 p-4 my-4 rounded-md font-semibold text-sm leading-tight text-white w-full shadow-md">
  <div class="flex flex-row items-center">
    <div class="p-2 px-3 mr-2 bg-purple-700 rounded-md">
      <i class="fas fa-bell text-white"></i>
    </div>
    {{ $slot }}
  </div>
  <button x-on:click="open = false">
    <i class="fas fa-times text-white"></i>
  </button>
</div>
