<?php

namespace App\ViewModels;

use App\Domain\Category\CategoryFindAction;
use App\Domain\Category\CategoryListAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\ViewModels\ViewModel;

class CategoryViewModel extends ViewModel
{
    public function __construct(public int $id = 0)
    {
        //
    }

    public function categories(): Collection
    {
        return CategoryListAction::execute([]);
    }

    public function category(): Model|null
    {
        return CategoryFindAction::execute([], $this->id);
    }

    public function headers(): array
    {
        return [
            'ID',
            'Nombre',
            'Opción',
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'name',
            '*',
        ];
    }
}
