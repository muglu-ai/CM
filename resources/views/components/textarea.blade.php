@props(['value' => '', 'rows' => 4])

<textarea {{ $attributes->merge(['class' => 'w-full p-2 border rounded bg-white text-gray-900 placeholder-gray-500 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 dark:border-gray-700', 'rows' => $rows]) }}>
{{ $slot ?? old($attributes->get('name')) ?? $value }}
</textarea>
