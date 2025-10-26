@props(['columns' => []])

        <div class="overflow-x-auto admin-table-wrapper rounded shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        @foreach($columns as $col)
                            <th scope="col" class="px-3 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                                {{ $col }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-transparent">
                    {{ $slot }}
                </tbody>
            </table>
        </div>
