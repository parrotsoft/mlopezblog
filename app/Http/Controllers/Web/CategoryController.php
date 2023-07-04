<?php

namespace App\Http\Controllers\Web;

use App\Domain\Category\CategoryDestroyAction;
use App\Domain\Category\CategorySaveAction;
use App\Domain\Category\CategoryUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\ViewModels\CategoryViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('categories.index', new CategoryViewModel());
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        CategorySaveAction::execute($request->all());

        return redirect(route('categories.index'));
    }

    public function show($id): View
    {
        return view('categories.create', new CategoryViewModel($id));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        CategoryUpdateAction::execute($request->all(), $id);

        return redirect(route('categories.index'));
    }

    public function destroy($id): RedirectResponse
    {
        CategoryDestroyAction::execute([], $id);

        return redirect(route('categories.index'));
    }
}
