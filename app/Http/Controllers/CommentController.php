<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Http\Requests\StoreCommentRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store (StoreCommentRequest $request)
    {
        $data = array_merge($request->all(), ['user_id' => $request->header('X-User-ID')]);
        $result = $this->commentService->createComment($data);
        broadcast(new CommentCreated($result));
        return response()->json(['data' => (bool)$result], 201);
    }

    public function show (string $id)
    {
        $result = $this->commentService->getAllComments($id);
        return response()->json(['data' => $result], 200);
    }
}
