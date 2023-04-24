<?php

namespace App\Http\Controllers\Api;

use App\Contracts\BaseApiController;
use App\Domain\Category\CategoryListAction;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryController extends Controller implements BaseApiController
{
    //
    public function index(): Collection
    {
        return CategoryListAction::execute([]);
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
