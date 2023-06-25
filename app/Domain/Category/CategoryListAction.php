<?php

namespace App\Domain\Category;

use App\Contracts\ActionInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryListAction implements ActionInterface
{
    public static function execute(array $data, int $id = 0): Model|bool|array|Collection
    {
        return Category::all();
    }
}
