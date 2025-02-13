<?php

namespace App\Http\Controllers;

use App\Jobs\UserRegistered;
use App\Models\User;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class NotificationController extends Controller
{

    #[NoReturn] public function sendNotification(User $user)
    {
        UserRegistered::dispatch($user)->onQueue('notification');
        return successResponse(null, 'notification sent successfully');
    }
}
