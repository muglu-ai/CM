<x-layouts.app :title="__('Events')">
            <div class="container mx-auto p-4">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Events</h1>
                    <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Create Event
                    </a>
                </div>

                <div class="mb-4 flex gap-2">
                    <input wire:model.debounce.300ms="search" type="text" placeholder="Search events..." class="w-full max-w-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md px-3 py-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <x-admin.table :columns="['Name','Starts','Ends','Actions']">
                    @forelse($events as $event)
                        <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 align-middle text-sm text-gray-900 dark:text-gray-100">{{ $event->name }}</td>
                            <td class="px-4 py-3 align-middle text-sm text-gray-700 dark:text-gray-300">{{ optional($event->starts_at)->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3 align-middle text-sm text-gray-700 dark:text-gray-300">{{ optional($event->ends_at)->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3 align-middle text-sm">
                                <div class="flex items-center space-x-2">
                                    <x-admin.row-actions :editUrl="route('admin.events.edit', $event)" :deleteAction="'delete(' . $event->id . ')'" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">No events found.</td>
                        </tr>
                    @endforelse
                </x-admin.table>

                <div class="mt-4">
                    {{ $events->links() }}
                </div>
            </div>
        </x-layouts.app>
