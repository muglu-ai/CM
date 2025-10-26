<x-layouts.app :title="__('Edit Track')">
    <h1 class="text-2xl font-semibold mb-6">Edit Track</h1>

    <form action="{{ route('admin.tracks.update', $track) }}" method="POST" class="max-w-2xl bg-white shadow-sm rounded-lg p-6 mx-auto">
        @csrf
        @method('PUT')

        <div class="grid gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" name="name" value="{{ old('name', $track->name) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" />
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input id="slug" name="slug" value="{{ old('slug', $track->slug) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" />
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">{{ old('description', $track->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Save
                </button>
                <a href="{{ route('admin.tracks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-sm rounded-md hover:bg-gray-200">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</x-layouts.app>

