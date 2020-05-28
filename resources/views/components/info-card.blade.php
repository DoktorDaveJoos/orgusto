<div class="bg-white mt-6 overflow-hidden rounded-t-lg border-b border-gray-200">
  <div class="flex flex-row content-center justify-between bg-gray-200 px-4 py-4 sm:px-6">
    <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
      {{ $title }}
    </h3>
    {{ $optional_button }}
  </div>
  <div>
    {{ $slot }}
  </div>
</div>
