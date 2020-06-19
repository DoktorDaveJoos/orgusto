<div class="w-full flex justify-center">

  <div class="bg-white w-full shadow-lg max-w-5xl self-center mt-6 overflow-hidden rounded-lg">
    <div class="flex flex-row content-center justify-between bg-gray-200 px-4 py-4 sm:px-6  {{ isset($optional_color) ? 'border-l-8 border-'.$optional_color.'-400' : '' }}">
      <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
        {{ $title }}
      </h3>
      {{ $optional_button ?? '' }}
    </div>
    <div>
      {{ $slot }}
    </div>
  </div>

</div>