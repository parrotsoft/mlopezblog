<?php

namespace App\Http\Controllers\Api;

use App\Domain\Post\PostDestroyAction;
use App\Domain\Post\PostSaveAction;
use App\Domain\Post\PostUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::query()->paginate(10);

        return PostResource::collection($posts);
    }

    public function store(PostRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->getKey();

        $post = PostSaveAction::execute($data);

        return response()->json([
            'message' => trans('message.created', ['attribute' => 'post']),
            'data' => new PostResource($post)
        ],201);
    }

    public function show(Post $post): PostResource
    {
        return PostResource::make($post);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        PostUpdateAction::execute($request->all(), $id);

        return response()->json([
            'message' => trans('message.updated', ['attribute' => 'post'])
        ],200);
    }

    public function destroy(int $id): JsonResponse
    {
        PostDestroyAction::execute([], $id);

        return response()->json([
            'message' => trans('message.deleted', ['attribute' => 'post'])
        ],200);
    }
}
