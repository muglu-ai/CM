<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Event;

class EventsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    protected $listeners = ['refreshEvents' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $ev = Event::find($id);
        if (! $ev) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Event not found.']);
            return;
        }

        $ev->delete();

        session()->flash('success', 'Event deleted.');
        $this->emit('refreshEvents');
    }

    public function render()
    {
        $query = Event::query()->orderBy('starts_at');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $events = $query->paginate(12);

        return view('livewire.admin.events-index', compact('events'));
    }
}

