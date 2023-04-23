<?php

namespace App\Domain\Post;

use App\Contracts\ActionInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostFindAction implements ActionInterface
{

    public static function execute(array $data, int $id = 0): Model|bool|array|Collection|null
    {
        return Post::query()->find($id);
    }
}
