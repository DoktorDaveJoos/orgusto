<div class="bg-white mt-6 overflow-hidden rounded-t-lg border-b border-gray-200">
  <div class="flex flex-row content-center justify-between bg-gray-200 px-4 py-4 sm:px-6">
    <h3 class="text-lg self-center leading-6 font-medium text-gray-900">
      {{ $title }}
    </h3>
    {{ $optional_button }}
  </div>
  <div>
    <table class="min-w-full">
      <thead class="bg-gray-200">
        <tr>
          @foreach($header_keys as $header_key)
          <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
            {{ $header_key }}
          </th>
          @endforeach
        </tr>
      </thead>
      @foreach($data_list as $entry)
      <tbody class="bg-white">
        <tr>
          @foreach($data_keys as $data_key)
          <td class="px-6 py-4 whitespace-no-wrap text-left">
            <div class="text-xs leading-5 text-gray-600">{{ $entry[$data_key] }}</div>
          </td>
          @endforeach
          {{ $action_buttons }}
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
