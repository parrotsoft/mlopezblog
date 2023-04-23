<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $headers = [
            'ID',
            'Nombre',
            'Opción'
        ];
        $fields = [
            'id',
            'name',
            '*'
        ];
        return view('categories.index', compact('categories', 'headers', 'fields'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        Category::query()->create($request->all());
        return redirect(route('categories.index'));
    }

    public function show($id)
    {
        $category = Category::query()->find($id);
        return view('categories.create', compact('category'));
    }

    public function update(Request $request, $id)
    {
        Category::query()->find($id)->update($request->all());
        return redirect(route('categories.index'));
    }

    public function destroy($id)
    {
        Category::query()->find($id)->delete();
        return redirect(route('categories.index'));
    }
}
