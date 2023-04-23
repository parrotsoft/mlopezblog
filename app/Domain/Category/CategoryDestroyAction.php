<?php

namespace App\Domain\Category;

use App\Contracts\ActionInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryDestroyAction implements ActionInterface
{

    public static function execute(array $data, int $id = 0): Model|bool|array
    {
        return Category::query()->find($id)->delete();
    }
}
