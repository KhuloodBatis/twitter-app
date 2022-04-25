<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use App\Http\Resources\Notification\NotificationCollection;



class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(5);
        return new NotificationCollection($notifications);
    }

    public function destroy(Request $request, $notification)
    {
        $request->user()->notifications()
            ->where('id', $notification)
            ->delete();
        return response()->json(['status' => 'notification was  deleted']);
    }
}
