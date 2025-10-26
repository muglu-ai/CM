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
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Starts</th>
                        <th class="p-3 text-sm font-medium text-gray-700 dark:text-gray-300">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sessions as $session)
                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-3">{{ $session->title }}</td>
                            <td class="p-3">{{ optional($session->event)->name }}</td>
                            <td class="p-3">{{ optional($session->track)->name }}</td>
                            <td class="p-3">{{ $session->starts_at }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.sessions.edit', $session) }}" class="text-blue-600 dark:text-blue-400 mr-3 hover:underline">Edit</a>
                                <a href="{{ route('admin.sessions.manageSpeakers', $session) }}" class="text-gray-600 dark:text-gray-300 mr-3 hover:underline">Speakers</a>
                                <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 dark:text-red-400 hover:underline" onclick="return confirm('Delete session?')">Delete</button>
                                </form>
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
