<?php

namespace App\Http\Controllers;

use App\Domain\Category\CategoryDestroyAction;
use App\Domain\Category\CategorySaveAction;
use App\Domain\Category\CategoryUpdateAction;
use App\ViewModels\CategoryViewModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return view('categories.index', new CategoryViewModel());
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        CategorySaveAction::execute($request->all());
        return redirect(route('categories.index'));
    }

    public function show($id)
    {
        return view('categories.create', new CategoryViewModel($id));
    }

    public function update(Request $request, $id)
    {
        CategoryUpdateAction::execute($request->all(), $id);
        return redirect(route('categories.index'));
    }

    public function destroy($id)
    {
        CategoryDestroyAction::execute([], $id);
        return redirect(route('categories.index'));
    }
}
