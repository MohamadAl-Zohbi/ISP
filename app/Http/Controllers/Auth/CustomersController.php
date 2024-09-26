<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function create_customer(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super' && $emp->rank != 'admin') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $customer = Customers::create(
            [
                'name' => $request->input('name'),
                'number' => $request->input('number'),
                'location' => $request->input('location'),
                'description' => $request->input('description'),
                'expiry' => $request->input('expiry'),
                'nationality' => $request->input('nationality'),
                'user' => $request->input('user'),
                'pass' => $request->input('pass'),
                // 'service_id' => $request->input('service_id'),
                'created_by' => $request->input('created_by'),
                'is_frozen' => $request->input('is_frozen'),
            ]
        );
        if ($customer) {
            return response()->json(['status' => true, 'details' => $customer]);
        }
        return response()->json(['status' => false, 'details' => 'customer did not created']);
    }

    public function update_customer(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super' && $emp->rank != 'admin') {
            return response()->json(['status' => 'no permession']);
        }

        $customer = Customers::where('id', $id)->first();
        if ($customer) {
            $customer->name = $request->input('name');
            $customer->number = $request->input('number');
            $customer->location = $request->input('location');
            $customer->expiry = $request->input('expiry');
            $customer->nationality = $request->input('nationality');
            $customer->user = $request->input('user');
            $customer->pass = $request->input('pass');
            // $customer->service_id = $request->input('service_id');
            $customer->created_by = $request->input('created_by');
            $customer->description = $request->input('description');
            $customer->is_frozen = $request->input('is_frozen');
            $customer->save();
            return response()->json(['status' => true, 'details' => $customer]);
        }
    }

    public function get_customer(Request $request, $id)
    {
        // $emp = $request->user();
        // if ($emp->rank != 'super') {
        //     return response()->json(['status' => false, 'details' => 'no permission']);
        // }

        $customer = Customers::find($id);
        if ($customer) {
            return response()->json(['status' => true, 'details' => $customer]);
        }
        return response()->json(['status' => false, 'details' => 'no user found']);
    }

    public function show_all_customers(Request $request)
    {
        // $emp = $request->user();
        // if ($emp->rank != 'super') {
        //     return response()->json(['status' => false, 'details' => 'no permission']);
        // }

        $customer = Customers::all();
        if ($customer) {
            return response()->json(['status' => true, 'details' => $customer]);
        }
    }

    public function search_customer(Request $request)
    {
        $customers = Customers::query()
            // ->whereBetween('expiry', [request('from'), request('to')])
            ->where(function ($query) {
                $search = request('search');
                $query->where('name', 'LIKE', "%{$search}%")
                    ->Orwhere('user', 'LIKE', "%{$search}%")
                    ->Orwhere('nationality', 'LIKE', "%{$search}%")
                    ->Orwhere('description', 'LIKE', "%{$search}%")
                    ->Orwhere('location', 'LIKE', "%{$search}%")
                    ->Orwhere('number', 'LIKE', "%{$search}%");
            })
            ->get();
        if ($customers) {
            return response()->json(['status' => true, 'details' => $customers]);
        }
    }

    public function get_unrenewed_customers(Request $request)
    {
        $currentDate = Carbon::now()->toDateString(); // Outputs: YYYY-MM-DD

        $customers = Customers::query()
            ->where('expiry','>=',$currentDate)
            ->get();
        if ($customers) {
            return response()->json(['status' => true, 'details' => $customers]);
        }
    }
}
