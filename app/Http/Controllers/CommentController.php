<?php

namespace App\Http\Controllers;

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
        $result = $this->commentService->createComment($request->all());
        return response()->json(['data' => $result], 201);
    }

    public function show (string $id)
    {
        $result = $this->commentService->getAllComments($id);
        return response()->json(['data' => $result], 200);
    }
}
