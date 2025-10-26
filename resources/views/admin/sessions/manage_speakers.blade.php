<x-layouts.app :title="__('Manage Speakers for Session')">
    <h1 class="text-xl font-bold mb-4">Manage Speakers for: {{ $session->title }}</h1>

    <div class="mb-6">
        <h2 class="font-semibold mb-2">Attached Speakers</h2>

      <div class="shadow overflow-hidden border-b sm:rounded-lg">
            <x-admin.table :columns="['Name','Role','Actions']">
                @foreach($session->speakers as $speaker)
                    <tr class="">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $speaker->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $speaker->pivot->role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form action="{{ route('admin.sessions.detachSpeaker', [$session, $speaker]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Detach speaker?')">Detach</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-admin.table>
        </div>
    </div>

    <div>
        <h2 class="font-semibold mb-2">Attach Speaker</h2>
        <form action="{{ route('admin.sessions.attachSpeaker', $session) }}" method="POST" class="mt-2">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Speaker</label>
                    <select name="speaker_id" class="w-full p-2 border rounded bg-white" required>
                        @foreach($speakers as $speaker)
                            <option value="{{ $speaker->id }}">{{ $speaker->name }} ({{ $speaker->company }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <input name="role" class="w-full p-2 border rounded" placeholder="Presenter" />
                </div>

                <div class="md:col-span-3">
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Attach</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.sessions.index') }}" class="px-3 py-1 bg-gray-200 rounded">Back to sessions</a>
    </div>
</x-layouts.app>
