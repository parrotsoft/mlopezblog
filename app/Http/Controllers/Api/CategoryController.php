<?php

namespace App\Http\Controllers\Api;

use App\Contracts\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller implements BaseApiController
{
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::query()->select(['id', 'name'])->paginate(10);

        return CategoryResource::collection($categories);
    }

    public function store(Request $request): void
    {
        // TODO: Implement store() method.
    }

    public function show(int $id): void
    {
        // TODO: Implement show() method.
    }

    public function update(Request $request, int $id): void
    {
        // TODO: Implement update() method.
    }

    public function destroy($id): void
    {
        // TODO: Implement destroy() method.
    }
}
