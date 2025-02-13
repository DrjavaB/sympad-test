<?php

namespace App\Services;

use Log;

class NotificationService
{
    public static function send(string $message, string $mobile): void
    {
        // Send SMS
        Log::info('SMS sent to ' . $mobile);
        Log::info('Message: ' . $message);
    }
}
