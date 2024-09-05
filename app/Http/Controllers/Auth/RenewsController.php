<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Renews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class RenewsController extends Controller
{
    public function create_renew(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super' && ($request->input('cheked_by_owner') == 'checked' || $request->input('cheked_by_owner') == 'refuised')) {
            return response()->json(['status' => 'no permession']);
        }


        
        $new_service = Renews::create(
            [
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'employee_id' => $emp->id,
                'service_id' => $request->input('service_id'),
                'checked_by_owner' => $request->input('cheked_by_owner'),
                'total' => $request->input('total'),
                'paid' => $request->input('paid'),
                'customer_id' => $request->input('customer_id'),
                'note' => $request->input('note'),
            ]
        );
        return $new_service;
    }

    public function update_renew(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super' && $emp->rank != 'admin') {
            return response()->json(['status' => 'no permession']);
        }

        $renew = Renews::where('id', $id)->first();
        if ($renew) {
            // if ($request->input('total') < $request->input('paid')) {
                $renew->from = $request->input('from');
                $renew->to = $request->input('to');
                $renew->employee_id = $request->input('employee_id');
                $renew->service_id = $request->input('service_id');
                $renew->checked_by_owner = $request->input('checked_by_owner');
                $renew->total = $request->input('total');
                // $renew->paid = $request->input('paid');
                $renew->customer_id = $request->input('customer_id');
                $renew->note = $request->input('note');
                $renew->save();
                return response()->json(['status' => true, 'details' => $renew]);
            // }
        }
    }

    public function delete_renew(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $renew = Renews::where('id', $id);
        if ($renew) {
            $renew->delete();
            // $renew->save();
            return response()->json(['status' => true, 'details' => $renew]);
        }
    }

    public function get_renews_from_to(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        // $renews = Renews::query()
        //     ->whereBetween('created_at', [request('from'), request('to')])
        //     ->get();

        $renews = DB::select(DB::raw("
    SELECT *
    FROM renews
    LEFT JOIN payments ON renews.id = payments.renew_id
"));
        if ($renews) {
            return response()->json(['status' => true, 'details' => $renews]);
        }
        return response()->json(['status' => false, 'details' => 'no pay found']);
    }
}
