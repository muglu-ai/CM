<x-layouts.app :title="__('Sessions')">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Sessions</h1>
                <a href="{{ route('admin.sessions.create') }}" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded">Create Session</a>
            </div>

            <div class="overflow-x-auto rounded shadow">
                <table class="w-full bg-white dark:bg-gray-800">
                    <thead>
                    <tr class="text-left">
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Title</th>
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Event</th>
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Track</th>
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Day</th>
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Time</th>
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Location</th>
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sessions as $session)
                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-3">
                                <div class="font-medium">{{ $session->title }}</div>
                                @if($session->description)
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($session->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="p-3">{{ optional($session->event)->name }}</td>
                            <td class="p-3">
                                @if($session->track)
                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded">{{ $session->track->name }}</span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">No track</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded">{{ $session->event_day ?? 'Not set' }}</span>
                            </td>
                            <td class="p-3">
                                @if($session->starts_at && $session->ends_at)
                                    <div class="text-sm">
                                        <div>{{ $session->starts_at->format('H:i') }} - {{ $session->ends_at->format('H:i') }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $session->starts_at->format('M d, Y') }}</div>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Not set</span>
                                @endif
                            </td>
                            <td class="p-3">
                                @if($session->location || $session->room)
                                    <div class="text-sm">
                                        @if($session->location)
                                            <div>{{ $session->location }}</div>
                                        @endif
                                        @if($session->room)
                                            <div class="text-gray-500 dark:text-gray-400">{{ $session->room }}</div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Not set</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.sessions.edit', $session) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Edit</a>
                                    <a href="{{ route('admin.sessions.manageSpeakers', $session) }}" class="text-gray-600 dark:text-gray-300 hover:underline text-sm">Speakers</a>
                                    <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 dark:text-red-400 hover:underline text-sm" onclick="return confirm('Delete session?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $sessions->links() }}
            </div>
        </div>
    </x-layouts.app>
