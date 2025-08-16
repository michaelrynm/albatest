<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $service) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $filters = [
            'category_id' => $request->get('category_id'),
            'search'      => $request->get('search'),
        ];
        $data = $this->service->paginate($filters, $perPage);
        return PostResource::collection($data)
            ->additional(['meta' => ['per_page' => $perPage]]);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->service->store(
            $request->validated(),
            $request->user(),
            $request->file('cover')
        );

        return response()->json(new PostResource($post), 201);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post->load(['author','category']));
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        // Hanya pemilik yang boleh update
        abort_unless($post->user_id === $request->user()->id, 403, 'Forbidden');

        $post = $this->service->update(
            $post,
            $request->validated(),
            $request->file('cover')
        );

        return response()->json(new PostResource($post));
    }

    public function destroy(Request $request, Post $post): JsonResponse
    {
        abort_unless($post->user_id === $request->user()->id, 403, 'Forbidden');
        $this->service->delete($post);
        return response()->json(['message' => 'Post deleted']);
    }
}
