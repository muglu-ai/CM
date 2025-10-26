@props(['editUrl','deleteAction'])

<div class="flex items-center space-x-3">
    <a href="{{ $editUrl }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">Edit</a>
    <button type="button" wire:click="{{ $deleteAction }}" wire:loading.attr="disabled" class="text-red-600 hover:text-red-800 dark:text-red-400" onclick="return confirm('Delete this item?')">Delete</button>
</div>

