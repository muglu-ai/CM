<x-layouts.app :title="__('Speaker')">
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Speakers</h1>
    <div class="flex items-center space-x-3">
        <form action="{{ route('admin.speakers.index') }}" method="GET" class="flex items-center">
            <input
                type="text"
                name="q"
                value="{{ $search ?? request('q') }}"
                placeholder="Search name, company, title..."
                class="border rounded-l px-3 py-1"
            >
            <button type="submit" class="px-3 py-1 bg-gray-800 text-white rounded-r">Search</button>
        </form>
        <a href="{{ route('admin.speakers.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Create Speaker</a>
    </div>
</div>

<x-admin.table :columns="['Name','Company','Tracks','Actions']">
    @foreach($speakers as $speaker)
        <tr class="border-t">
            <td class="p-3">{{ $speaker->name }}</td>
            <td class="p-3">{{ $speaker->company }}</td>
            <td class="p-3">
                @if($speaker->tracks->isNotEmpty())
                    {{ $speaker->tracks->pluck('name')->join(', ') }}
                @else
                    <span class="text-gray-500">—</span>
                @endif
            </td>
            <td class="p-3">
                <a href="{{ route('admin.speakers.edit', $speaker) }}" class="text-blue-600 mr-3">Edit</a>
                <form action="{{ route('admin.speakers.destroy', $speaker) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600" onclick="return confirm('Delete speaker?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</x-admin.table>

<div class="mt-4">{{ $speakers->links() }}</div>
</x-layouts.app>
