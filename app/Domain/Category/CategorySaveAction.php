<?php

namespace App\Domain\Category;

use App\Contracts\ActionInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategorySaveAction implements ActionInterface
{

    public static function execute(array $data, int $id = 0): Model
    {
        return Category::query()->create($data);
    }
}
