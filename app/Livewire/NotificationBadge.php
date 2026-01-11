<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class NotificationBadge extends Component
{
    public $unreadCount = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('notification-received')]
    public function updateCount()
    {
        $this->unreadCount = auth()->user()->unreadNotifications->count();
    }

    public function render()
    {
        return view('livewire.notification-badge');
    }
}
