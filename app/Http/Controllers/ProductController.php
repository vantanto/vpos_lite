<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::with('units');
        if ($request->search) {
            $products->where(function($query) use($request) {
                $query->where('code', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%");
            });
        }
        if ($request->category) {
            $products->where('category_id', $request->category);
        }
        $products = $products->orderBy('id', 'desc')
            ->paginate(15);

        return view('product.index', compact('categories', 'products'));
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $arr_validator = [
            'code' => 'nullable|unique:products,code',
            'name' => 'required',
            'sell_price' => 'required|numeric',
            'unit' => 'required',
            'category' => 'nullable|exists:categories,id',
            'discount' => 'nullable|numeric',
        ];
        $arr_validator_attribute = [];
        $unit_idx = $request->unit_idx ?? [];
        foreach ($unit_idx as $un_idx) {
            $arr_validator['un_name_'.$un_idx] = 'required';
            $arr_validator['un_qty_'.$un_idx] = 'required|numeric';
            $arr_validator['un_price_'.$un_idx] = 'required|numeric';
            $arr_validator_attribute['un_name_'.$un_idx] = 'Unit Name';
            $arr_validator_attribute['un_qty_'.$un_idx] = 'Unit Quantity';
            $arr_validator_attribute['un_price_'.$un_idx] = 'Unit Price';
        }

        $validator = \Validator::make($request->all(), $arr_validator, [], $arr_validator_attribute);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $product = new Product();
            $product->code = $request->code;
            $product->name = $request->name;
            $product->discount = $request->discount ?? 0;
            $product->category_id = $request->category;
            $product->is_show = $request->is_show ? true : false;
            $product->description = $request->description;
            $product->save();

            $unit = new Unit();
            $unit->product_id = $product->id;
            $unit->name = $request->unit;
            $unit->quantity = 1;
            $unit->sell_price = $request->sell_price;
            $unit->save();

            foreach ($unit_idx as $un_idx) {
                $unit = new Unit();
                $unit->product_id = $product->id;
                $unit->name = $request->get('un_name_'.$un_idx);
                $unit->quantity = $request->get('un_qty_'.$un_idx);
                $unit->sell_price = $request->get('un_price_'.$un_idx);
                $unit->save();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Product Successfully Created'], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => config('app.debug') ? $ex->getMessage() : 'Product Failed Created'], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $product = Product::with(['units'])->where('id', $id)->first();
        return view('product.show', compact('product'));
    }

    public function edit(Request $request, $id)
    {
        $categories = Category::all();
        $product = Product::with(['units'])->where('id', $id)->first();
        return view('product.edit', compact('categories', 'product'));
    }

    public function update(Request $request, $id)
    {
        $arr_validator = [
            'code' => 'nullable|unique:products,code,'.$id,
            'name' => 'required',
            'sell_price' => 'required|numeric',
            'unit' => 'required',
            'category' => 'nullable|exists:categories,id',
            'discount' => 'nullable|numeric',
        ];
        $arr_validator_attribute = [];
        $unit_idx = $request->unit_idx ?? [];
        foreach ($unit_idx as $un_idx) {
            $arr_validator['un_name_'.$un_idx] = 'required';
            $arr_validator['un_qty_'.$un_idx] = 'required|numeric';
            $arr_validator['un_price_'.$un_idx] = 'required|numeric';
            $arr_validator_attribute['un_name_'.$un_idx] = 'Unit Name';
            $arr_validator_attribute['un_qty_'.$un_idx] = 'Unit Quantity';
            $arr_validator_attribute['un_price_'.$un_idx] = 'Unit Price';
        }

        $validator = \Validator::make($request->all(), $arr_validator, [], $arr_validator_attribute);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $product->code = $request->code;
            $product->name = $request->name;
            $product->discount = $request->discount ?? 0;
            $product->category_id = $request->category;
            $product->is_show = $request->is_show ? true : false;
            $product->description = $request->description;
            $product->save();

            $unit = Unit::find($request->unit_old_id);
            $unit->product_id = $product->id;
            $unit->name = $request->unit;
            $unit->quantity = 1;
            $unit->sell_price = $request->sell_price;
            $unit->save();

            foreach ($unit_idx as $un_idx) {
                $unit = new Unit();
                if ($request->get('unit_old_id_'.$un_idx)) $unit = Unit::find($request->get('unit_old_id_'.$un_idx));
                $unit->product_id = $product->id;
                $unit->name = $request->get('un_name_'.$un_idx);
                $unit->quantity = $request->get('un_qty_'.$un_idx);
                $unit->sell_price = $request->get('un_price_'.$un_idx);
                $unit->save();
            }

            // Delete Unit
            $deleted_unit = $request->deleted_unit;
            if ($deleted_unit) {
                Unit::whereIn('id', $deleted_unit)
                    ->where('id', '!=', $request->unit_old_id)->delete();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Product Successfully Updated'], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => config('app.debug') ? $ex->getMessage() : 'Product Failed Updated'], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Successfully Deleted');
    }
}
