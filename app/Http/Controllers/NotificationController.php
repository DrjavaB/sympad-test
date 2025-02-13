<?php

namespace App\Http\Controllers;

use App\Jobs\CustomNotification;
use App\Models\User;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;


class NotificationController extends Controller
{
    #[NoReturn] public function sendNotification(Request $request,User $user)
    {
        CustomNotification::dispatch($request->message, $user)->onQueue('notification');
        return successResponse(null, 'نوتیفیکشن برای کاربر ارسال شد');
    }
}
