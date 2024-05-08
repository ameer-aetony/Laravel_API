<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $admin = Admin::find(5);
        return response()->json([
            'notifications' => $admin->notifications
        ]);
    }

    public function unread()
    {
        $admin = Admin::find(5);
        return response()->json([
            'notifications' => $admin->unreadNotifications
        ]);
    }

    public function markRead()
    {
        $admin = Admin::find(5);
        foreach ($admin->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function deleteAll()
    {
        $admin = Admin::find(5);
        $admin->notifications()->delete();
        return response()->json([
            'message' => 'deleted'
        ]);
    }

    public function delete($id)
    {
        DB::table('notifications')->where('id', $id)->delete();
        return response()->json([
            'message' => 'deleted',
        ]);
    }
}
