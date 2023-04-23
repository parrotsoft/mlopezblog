<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            @foreach($headers as $header)
                <th scope="col" class="px-6 py-3">
                    {{ $header }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($collections as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @foreach($fields as $field)
                    <td class="px-6 py-4">
                        @if ($field == '*')

                            <div class="flex w-80">
                                <div class="w-1/2">
                                    <x-button-delete-component
                                        url="{{ route($model.'.destroy', $item->id) }}"/>
                                </div>
                                <div class="w-1/2">
                                    <x-button-component :label="'Edit'" route="{{ route($model.'.show', $item->id) }}"/>
                                </div>
                            </div>
                        @else
                            {{ $item->$field }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
