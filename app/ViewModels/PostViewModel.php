<?php

namespace App\ViewModels;

use App\Domain\Category\CategoryListAction;
use App\Domain\Post\PostFindAction;
use App\Domain\Post\PostListAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\ViewModels\ViewModel;

class PostViewModel extends ViewModel
{
    public function __construct(public int $id = 0)
    {
        //
    }

    public function posts(): Collection
    {
        return PostListAction::execute([]);
    }

    public function headers(): array
    {
        return [
            'ID',
            'Titulo',
            'Categoría',
            'Opción'
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'title',
            'category',
            '*'
        ];
    }

    public function categories(): Collection
    {
        return CategoryListAction::execute([]);
    }

    public function post(): Model|null
    {
        return PostFindAction::execute([], $this->id);
    }
}
