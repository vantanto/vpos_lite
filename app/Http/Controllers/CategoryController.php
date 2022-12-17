<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();
        if ($request->search) {
            $categories->where('name', 'like', "%{$request->search}%");
        }
        $categories = $categories->orderBy('id', 'desc')
            ->paginate(15);
        
        return view('category.index', compact('categories'));
    }

    public function create(Request $request)
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $category = new Category;
        $category->name = $request->name;
        $category->save();
        return response()->json(['status' => 'success', 'msg' => 'Category Successfully Created'], 200);
    }

    public function edit(Request $request, $id)
    {
        $category = Category::find($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return response()->json(['status' => 'success', 'msg' => 'Category Successfully Updated'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Successfully Deleted');
    }
}
