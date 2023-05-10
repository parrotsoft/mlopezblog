<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiExportController;
use App\Contracts\BaseApiController;
use App\Domain\Post\PostListAction;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PostController extends Controller implements BaseApiController, ApiExportController
{
    //
    public function index(): Collection
    {
        return PostListAction::execute([]);
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

    public function export(): void
    {
        // TODO: Implement export() method.
    }
}
