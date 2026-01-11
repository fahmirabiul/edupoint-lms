<?php

namespace App\Listeners;

use App\Events\UserEnrolled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyInstructor implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserEnrolled $event): void
    {
        sleep(3);
        Log::info('Sending notification to instructor for user: ' . $event->enrollment->user->email);
    }
}
