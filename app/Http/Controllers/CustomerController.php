<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::query();
        if ($request->search) {
            $customers->where(function($query) use($request) {
                $query->where('name', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%")
                    ->orWhere('address', 'like', "%{$request->search}%");
            });
        }
        $customers = $customers->orderBy('id', 'desc')
            ->paginate(15);

        return view('customer.index', compact('customers'));
    }

    public function create(Request $request)
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->description = $request->description;
        $customer->save();
        return response()->json(['status' => 'success', 'msg' => 'Customer Successfully Created'], 200);
    }

    public function edit(Request $request, $id)
    {
        $customer = Customer::find($id);
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->description = $request->description;
        $customer->save();
        return response()->json(['status' => 'success', 'msg' => 'Customer Successfully Updated'], 200);
    }

    public function destroy(Request $request, $id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customers.index')->with('success', 'Customer Successfully Deleted');
    }
}
