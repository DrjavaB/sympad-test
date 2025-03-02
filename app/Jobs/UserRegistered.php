<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UserRegistered implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly User $user)
    {
        $this->onConnection('redis');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $message = sprintf("کاربر %s\nبه خانواده بزرگ سیمپاد خوش آمدید", $this->user->name);
        NotificationService::send($message, $this->user->mobile);
    }
}
