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
           <input name="title" id="title" value="{{ $session->title }}" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" required />
       </div>

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Slug</label>
           <input name="slug" id="slug" value="{{ $session->slug }}" readonly class="w-full p-2 border rounded bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-400 border-gray-300 dark:border-gray-600" />
           <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Slug will be automatically generated from title</p>
       </div>

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Description</label>
           <textarea name="description" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600">{{ $session->description }}</textarea>
       </div>

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Event Day</label>
           <select name="event_day" id="event_day" required class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600">
               <option value="">Select Day</option>
               <option value="Day 1" @if($session->event_day == 'Day 1') selected @endif class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">Day 1</option>
               <option value="Day 2" @if($session->event_day == 'Day 2') selected @endif class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">Day 2</option>
               <option value="Day 3" @if($session->event_day == 'Day 3') selected @endif class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">Day 3</option>
           </select>
       </div>

       <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
           <div>
               <label class="block text-sm text-gray-700 dark:text-gray-300">Start Time</label>
               <input name="start_time" id="start_time" type="time" value="{{ $session->starts_at ? $session->starts_at->format('H:i') : '' }}" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" />
           </div>
           <div>
               <label class="block text-sm text-gray-700 dark:text-gray-300">End Time</label>
               <input name="end_time" id="end_time" type="time" value="{{ $session->ends_at ? $session->ends_at->format('H:i') : '' }}" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" />
           </div>
       </div>

       <!-- Hidden fields for actual datetime values -->
       <input type="hidden" name="starts_at" id="starts_at" value="{{ $session->starts_at ? $session->starts_at->format('Y-m-d\TH:i') : '' }}" />
       <input type="hidden" name="ends_at" id="ends_at" value="{{ $session->ends_at ? $session->ends_at->format('Y-m-d\TH:i') : '' }}" />

       <div class="mb-3">
           <label class="block text-sm text-gray-700 dark:text-gray-300">Track</label>
           <select name="track_id" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600">
               <option value="" class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">No track</option>
               @foreach($tracks as $track)
                   <option value="{{ $track->id }}" @if(optional($session->track)->id == $track->id) selected @endif class="bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">{{ $track->name }}</option>
               @endforeach
           </select>
       </div>

       <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
           <div>
               <label class="block text-sm text-gray-700 dark:text-gray-300">Location</label>
               <input name="location" type="text" value="{{ $session->location }}" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" placeholder="e.g., Main Hall, Room A" />
           </div>
           <div>
               <label class="block text-sm text-gray-700 dark:text-gray-300">Room</label>
               <input name="room" type="text" value="{{ $session->room }}" class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" placeholder="e.g., Room 101" />
           </div>
       </div>

       <div class="flex gap-2">
           <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded">Save</button>
           <a href="{{ route('admin.sessions.index') }}" class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded">Cancel</a>
       </div>
   </form>

   <script>
       document.addEventListener('DOMContentLoaded', function() {
           const titleInput = document.getElementById('title');
           const slugInput = document.getElementById('slug');
           const eventDaySelect = document.getElementById('event_day');
           const startTimeInput = document.getElementById('start_time');
           const endTimeInput = document.getElementById('end_time');
           const startsAtHidden = document.getElementById('starts_at');
           const endsAtHidden = document.getElementById('ends_at');

           // Generate slug from title
           function generateSlug(text) {
               return text
                   .toLowerCase()
                   .replace(/[^a-z0-9 -]/g, '')
                   .replace(/\s+/g, '-')
                   .replace(/-+/g, '-')
                   .trim('-');
           }

           // Calculate datetime based on day and time
           function calculateDateTime(day, time) {
               if (!day || !time) return '';
               
               let date;
               if (day === 'Day 1') {
                   date = '2025-11-18';
               } else if (day === 'Day 2') {
                   date = '2025-11-19';
               } else if (day === 'Day 3') {
                   date = '2025-11-20';
               } else {
                   return '';
               }
               
               return date + 'T' + time;
           }

           // Update slug when title changes
           titleInput.addEventListener('input', function() {
               slugInput.value = generateSlug(this.value);
           });

           // Update datetime when day or time changes
           function updateDateTime() {
               const day = eventDaySelect.value;
               const startTime = startTimeInput.value;
               const endTime = endTimeInput.value;
               
               if (day && startTime) {
                   startsAtHidden.value = calculateDateTime(day, startTime);
               }
               
               if (day && endTime) {
                   endsAtHidden.value = calculateDateTime(day, endTime);
               }
           }

           eventDaySelect.addEventListener('change', updateDateTime);
           startTimeInput.addEventListener('change', updateDateTime);
           endTimeInput.addEventListener('change', updateDateTime);

           // Initialize datetime on page load
           updateDateTime();
       });
   </script>
</x-layouts.app>
