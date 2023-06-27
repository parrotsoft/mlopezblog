<?php

namespace App\Http\Controllers\Api;

use App\Domain\Post\PostDestroyAction;
use App\Domain\Post\PostSaveAction;
use App\Domain\Post\PostUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters(['title', 'body', 'price', 'category_id'])
            ->allowedIncludes('category')
            ->paginate(10);

        return PostResource::collection($posts);
    }

    public function store(PostRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->getKey();

        $post = PostSaveAction::execute($data);

        return response()->json([
            'message' => trans('message.created', ['attribute' => 'post']),
            'data' => new PostResource($post),
        ], 201);
    }

    public function show(Post $post): PostResource
    {
        return PostResource::make($post);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(PostRequest $request, int $id): JsonResponse
    {
        $post = Post::query()->findOrFail($id);

        $this->authorize('update', $post);

        PostUpdateAction::execute($request->all(), $post->getKey());

        return response()->json([
            'message' => trans('message.updated', ['attribute' => 'post']),
        ], 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $post = Post::query()->findOrFail($id);

        $this->authorize('delete', $post);

        PostDestroyAction::execute([], $post->getKey());

        return response()->json([
            'message' => trans('message.deleted', ['attribute' => 'post']),
        ], 200);
    }
}
