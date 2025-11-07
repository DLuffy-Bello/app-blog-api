<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $postService;

    public function __construct(\App\Services\PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        return response()->json(['message' => 'List of posts']);
    }

    public function show($id)
    {
        return response()->json(['message' => "Details of post with ID: $id"]);
    }

    public function store(StorePostRequest $request)
    {
        $post = $this->postService->createPost($request->all());
        broadcast(new PostCreated($post));
        return response()->json(['message' => 'Post created', 'data' => $post], 201);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => "Post with ID: $id updated"]);
    }

    public function destroy($id)
    {
        return response()->json(['message' => "Post with ID: $id deleted"]);
    }
}
