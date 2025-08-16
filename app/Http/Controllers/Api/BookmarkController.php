<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct(private BookmarkService $service) {}

    public function toggle(Request $request, Post $post): JsonResponse
    {
        $status = $this->service->toggle($request->user(), $post);
        return response()->json(['status' => $status]);
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $data = $this->service->list($request->user(), $perPage);
        return PostResource::collection($data)
            ->additional(['meta' => ['per_page' => $perPage]]);
    }
}
