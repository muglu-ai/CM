<x-layouts.app :title="__('Edit Session')">
   <h1 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit Session</h1>

   <form action="{{ route('admin.sessions.update', $session) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm dark:shadow-md text-gray-900 dark:text-gray-100">
       @csrf
       @method('PUT')

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Event</label>
           <select name="event_id" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" required>
               @foreach($events as $event)
                   <option value="{{ $event->id }}" @if($event->id === $session->event_id) selected @endif class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">{{ $event->name }}</option>
               @endforeach
           </select>
       </div>

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Title</label>
           <input name="title" value="{{ $session->title }}" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" required />
       </div>

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Slug</label>
           <input name="slug" value="{{ $session->slug }}" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" required />
       </div>

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Description</label>
           <textarea name="description" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600">{{ $session->description }}</textarea>
       </div>

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Track</label>
           <select name="track_id" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600">
               <option value="" class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">No track</option>
               @foreach($tracks as $track)
                   <option value="{{ $track->id }}" @if(optional($session->track)->id == $track->id) selected @endif class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">{{ $track->name }}</option>
               @endforeach
           </select>
       </div>

       <div class="flex gap-2">
           <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded">Save</button>
           <a href="{{ route('admin.sessions.index') }}" class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded">Cancel</a>
       </div>
   </form>
</x-layouts.app>
