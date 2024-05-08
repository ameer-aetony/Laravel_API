<?php

namespace App\Services\PostService;

use App\Models\Admin;
use App\Models\Post;
use App\Models\Post_Photo;
use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StrongPostService
{
    protected $model;
    function __construct()
    {
        $this->model = new Post();
    }

    function stroePost($data)
    {
        $data = $data->except('photo');
        $data['worker_id'] = auth()->guard('worker')->id();
        $data['price']= $this->adminPercent($data['price']);
        $post = $this->model::create($data);
        return $post;
    }

    function storePostPhoto($request, $postId)
    {
        foreach ($request->file('photos') as $photo) {
            $postPhotos = new Post_Photo();
            $postPhotos->post_id = $postId;
            $postPhotos->photo = $photo->store('posts');
            $postPhotos->save();
        }
    }

    function sendAdminNotification($post)
    {
        $admins = Admin::get();

        Notification::send($admins, new AdminNotify(auth()->guard('worker')->user(), $post));
    }

    public function adminPercent($price)
    {
        $discount = $price * 0.05;
        $priceAfterDiscount = $price - $discount;
        return $priceAfterDiscount;

    }

    function store($request)
    {

        try {
            DB::beginTransaction();
            $post = $this->stroePost($request);
            if ($request->hasFile('photos')) {
                $postPhoto = $this->storePostPhoto($request, $post->id);
                $this->sendAdminNotification($post);
                DB::commit();
                return response()->json([
                    'message' => 'psot has been created successfuly, your price after discount is '.$post->price,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
