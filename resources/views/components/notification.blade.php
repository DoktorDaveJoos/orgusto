<div x-data x-ref="notification" x-init="$refs.notification.classList.add('opacity-0'); window.setTimeout(() => $refs.notification.classList.remove('opacity-0'), 100);" class="notification transition-opacity ease-in-out duration-200">
  <div class="flex flex-row items-center">
    <div class="p-2 px-3 mr-2 bg-purple-700 rounded-md">
      <i class="fas fa-bell text-white"></i>
    </div>
    <span class="pr-4">
      {{ $slot }}
    </span>
  </div>
  <button @click="$refs.notification.classList.add('opacity-0'); window.setTimeout(() => $refs.notification.parentElement.removeChild($refs.notification), 200);">
    <i class="fas fa-times text-white"></i>
  </button>
</div>
