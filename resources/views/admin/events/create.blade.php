<x-layouts.app :title="__('Create Event')">
<h1 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Create Event</h1>

<form action="{{ route('admin.events.store') }}" method="POST" class="space-y-4">
    @csrf

    <div class="mb-3">
        <x-label for="name" class="block text-sm text-gray-700 dark:text-gray-300" :value="__('Name')" />
        <x-input id="name" name="name" required class="w-full p-2 border rounded bg-white text-gray-900 placeholder-gray-500 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 dark:border-gray-700" />
    </div>

    <div class="mb-3">
        <x-label for="slug" class="block text-sm text-gray-700 dark:text-gray-300" :value="__('Slug')" />
        <x-input id="slug" name="slug" required class="w-full p-2 border rounded bg-white text-gray-900 placeholder-gray-500 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 dark:border-gray-700" />
    </div>

    <div class="mb-3">
        <x-label for="description" class="block text-sm text-gray-700 dark:text-gray-300" :value="__('Description')" />
        <x-textarea id="description" name="description" class="w-full p-2 border rounded bg-white text-gray-900 placeholder-gray-500 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 dark:border-gray-700" />
    </div>

    <div class="flex gap-2">
        <x-button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Create') }}</x-button>
        <a href="{{ route('admin.events.index') }}" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">Cancel</a>
    </div>
</form>
</x-layouts.app>
