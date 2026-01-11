<?php

namespace App\Listeners;

use App\Events\UserEnrolled;
use App\Notifications\CourseEnrollmentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyUserOfEnrollment implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(UserEnrolled $event): void
    {
        $user = $event->enrollment->user;

        // Send notification to user
        $user->notify(new CourseEnrollmentNotification($event->enrollment));

        Log::info('Notification sent to user: ' . $user->email);
    }
}
