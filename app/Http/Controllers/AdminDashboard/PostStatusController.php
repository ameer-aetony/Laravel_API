<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostStatusRequest;
use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\Notification;

class PostStatusController extends Controller
{
    public function changeStatus(PostStatusRequest $request)
    {
        $post = Post::find($request->post_id);
        $post->update([
            'status' => $request->status,
            'rejected_reason' => $request->rejected_reason
        ]);

        Notification::send($post->worker, new AdminNotify($post->worker, $post));
        return response()->json([
            'message' => 'post has been changed'
        ]);
    }
}
