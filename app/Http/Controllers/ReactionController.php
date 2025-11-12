<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToggleLikeRequest;
use App\Services\ReactionService;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    private $reactionService;

    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }

    public function toggleLike(ToggleLikeRequest $request)
    {
        $isLiked = $this->reactionService->toggleLike(
            $request->all(),
            $request->header('X-User-ID')
        );
        return response()->json(['data' => ['isLiked' => $isLiked]], 200);
    }
}
