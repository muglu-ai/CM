<x-layouts.app :title="__('Edit Speaker')">
<h1 class="text-2xl font-semibold mb-6">Edit Speaker</h1>

<form action="{{ route('admin.speakers.update', $speaker) }}" method="POST" class="max-w-2xl space-y-6 bg-white p-6 rounded-lg shadow">
    @csrf
    @method('PUT')

    <div class="space-y-1">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input id="name" name="name" value="{{ $speaker->name }}" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" />
    </div>

    <div class="space-y-1">
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input id="slug" name="slug" value="{{ $speaker->slug }}" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-1">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input id="title" name="title" value="{{ $speaker->title }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        <div class="space-y-1">
            <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
            <input id="company" name="company" value="{{ $speaker->company }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" />
        </div>
    </div>

    <div class="space-y-1">
        <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
        <textarea id="bio" name="bio" rows="5"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">{{ $speaker->bio }}</textarea>
    </div>

    <div>
        <label for="tracks" class="block text-sm font-medium text-gray-700">Tracks</label>
        <select id="tracks" name="tracks[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            @foreach($tracks as $track)
                <option value="{{ $track->id }}" @if(in_array($track->id, old('tracks', $selected ?? []))) selected @endif>{{ $track->name }}</option>
            @endforeach
        </select>
        @error('tracks') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Save</button>
        <a href="{{ route('admin.speakers.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100">Cancel</a>
    </div>
</form>
</x-layouts.app>
