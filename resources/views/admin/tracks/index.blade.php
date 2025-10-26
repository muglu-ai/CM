<x-layouts.app :title="__('Tracks')">

<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Tracks</h1>
    <a href="{{ route('admin.tracks.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Create Track</a>
</div>

<x-admin.table :columns="['Name', 'Description', 'Actions']" :items="$tracks">
    @foreach($tracks as $track)
        <tr class="border-t">
            <td class="p-3">{{ $track->name }}</td>
            <td class="p-3">{{ Str::limit($track->description, 100) }}</td>
            <td class="p-3">
                <a href="{{ route('admin.tracks.edit', $track) }}" class="text-blue-600 mr-3">Edit</a>
                <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600" onclick="return confirm('Delete track?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</x-admin.table>

<div class="mt-4">{{ $tracks->links() }}</div>
</x-layouts.app>

