<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Renews;
use App\Models\Services;

class PaymentsController extends Controller
{
    public function create_payment(Request $request, $id)
    {
        $emp = $request->user();

        if ($emp->rank != 'super' && $emp->rank != 'admin') {
            return response()->json(['status' => 'no permession']);
        }
        $renew = Renews::find($id);
        if (($request->input('amount') + $renew['paid']) > $renew['total']) {
            return response()->json(['status' => false, 'details' => 'the amount is too higher then the total please pay as the total']);
        }

        if ($request->input('amount') <= 0) {
            return response()->json(['status' => false, 'details' => 'wrong amount']);
            
        }
        // done checking 
        $payment = Payments::create([
            'amount' => $request->input('amount'),
            'phone_number' => $request->input('phone_number'),
            'description' => $request->input('description'),
            'who' => $request->input('who'),
            'payment_method' => $request->input('payment_method'),
            'employee_id' => $emp->id,
            'renew_id' => $id,
        ]);

        $renew = Renews::where('id', $id)->first();
        $renew->paid += $request->input('amount');
        $renew->save();
        return $payment;
    }

    public function update_payment(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => 'no permession']);
        }

        $payment = Payments::where('id', $id)->first();
        $old_amount = $payment->amount; // 20 /     35 
        // 7 - 20 = -13 
        $current_amount = $request->input('amount') - $old_amount;
        if ($payment) {
            $payment->amount = $request->input('amount');
            $payment->phone_number = $request->input('phone_number');
            $payment->description = $request->input('description');
            $payment->who = $request->input('who');
            $payment->payment_method = $request->input('payment_method');
            $payment->employee_id = $request->input('employee_id');
            $payment->renew_id = $request->input('renew_id');
            $payment->save();
            $renew = Renews::where('id', $request->input('renew_id'))->first();
            $renew->paid += $current_amount;
            $renew->save();
            return response()->json(['status' => true, 'details' => $payment]);
        }
    }

    public function delete_payment(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $payment = Payments::where('id', $id)->first();
        if ($payment) {
            $renew = Renews::where('id', $payment->renew_id)->first();
            if ($renew) {
                $renew->paid -= $payment->amount;
                $renew->save();
                $payment->delete();
            }
            return response()->json(['status' => true, 'details' => $payment]);
        }
    }

    public function get_payment(Request $request, $id)
    {
        // $emp = $request->user();
        // if ($emp->rank != 'super') {
        //     return response()->json(['status' => false,'details'=>'no permission']);
        // }

        $payment = Payments::find($id);
        if ($payment) {
            return response()->json(['status' => true, 'details' => $payment]);
        }
        return response()->json(['status' => false, 'details' => 'no pay found']);
    }

    // get all payment for a spesific renew 
    public function get_payments(Request $request, $id)
    {
        // $emp = $request->user();
        // if ($emp->rank != 'super') {
        //     return response()->json(['status' => false,'details'=>'no permission']);
        // }

        $payment = Payments::query()
            ->where('renew_id', '=', "{$id}")
            ->get();
        $renew = Renews::find($id);
        $service = Services::find($renew['service_id']);
        $customer = Customers::find($renew['customer_id']);
        if ($payment) {
            return response()->json(['status' => true, 'details' => $payment, 'renew' => $renew, 'name' => $customer['name'], 'service' => $service['service']]);
        }
        return response()->json(['status' => false, 'details' => 'no pay found']);
    }
}
