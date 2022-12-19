<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::query();
        if ($request->search) {
            $suppliers->where(function($query) use($request) {
                $query->where('name', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%")
                    ->orWhere('address', 'like', "%{$request->search}%");
            });
        }
        $suppliers = $suppliers->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('supplier.index', compact('suppliers'));
    }

    public function create(Request $request)
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->description = $request->description;
        $supplier->save();
        return response()->json(['status' => 'success', 'msg' => 'Supplier Successfully Created'], 200);
    }

    public function edit(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->description = $request->description;
        $supplier->save();
        return response()->json(['status' => 'success', 'msg' => 'Supplier Successfully Updated'], 200);
    }

    public function destroy(Request $request, $id)
    {
        Supplier::find($id)->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier Successfully Deleted');
    }
}
