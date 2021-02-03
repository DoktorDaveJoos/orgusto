<div class="my-4 px-2 flex-1">
  <label for="{{ $label }}" class="block text-xs leading-4 font-semibold text-gray-700 uppercase tracking-wider">{{ $label }}</label>
  <div class="mt-1 rounded-md w-full flex flex-col">
    {{ $slot }}
  </div>
</div>
