<?php

namespace App\Domain\Category;

use App\Contracts\ActionInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryFindAction implements ActionInterface
{
    public static function execute(array $data, int $id = 0): Model|null
    {
        return Category::query()->find($id);
    }
}
