<x-layouts.app :title="__('Edit Event')">

<h1 class="text-xl font-bold mb-4">Edit Event</h1>

    <form action="{{ route('admin.events.update', $event) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block text-sm">Name</label>
            <input name="name" value="{{ $event->name }}" class="w-full p-2 border rounded" required />
        </div>

        <div class="mb-3">
            <label class="block text-sm">Slug</label>
            <input name="slug" value="{{ $event->slug }}" class="w-full p-2 border rounded" required />
        </div>

        <div class="mb-3">
            <label class="block text-sm">Description</label>
            <textarea name="description" class="w-full p-2 border rounded">{{ $event->description }}</textarea>
        </div>

        <div class="flex gap-2">
            <button class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
            <a href="{{ route('admin.events.index') }}" class="px-3 py-1 bg-gray-200 rounded">Cancel</a>
        </div>
    </form>
</x-layouts.app>
