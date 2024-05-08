<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StrongPostRequest;
use App\Services\PostService\StrongPostService;


class PostController extends Controller
{
  public function index(){
  $posts= Post::all();
  return response()->json([
    'posts' => $posts
  ]);
  }

  public function store(StrongPostRequest $request ){

  return  (new StrongPostService)->store($request);

  }


  public function approved(){
    $posts= Post::with('worker:id,name')->get()->makeHidden('status');
    return response()->json([
      'posts' => $posts
    ]);
    }
}
