<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function create_service(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => 'no permession']);
        }

        $new_service = Services::create(
            [
                'service' => $request->input('service'),
                'price' => $request->input('price'),
                'package' => $request->input('package'),
                'description' => $request->input('description'),
            ]
        );

        if ($new_service) {
            return $new_service;
        }
        return response()->json(['status' => false, 'details' => 'service can not be added']);
    }

    public function show_all_services(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $services = Services::all();
        if ($services) {
            return response()->json(['status' => true, 'details' => $services]);
        }
    }

    public function update_service(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => 'no permession']);
        }

        $service = Services::where('id', $id)->first();
        if ($service) {
            $service->service = $request->input('service');
            $service->price = $request->input('price');
            $service->package = $request->input('package');
            $service->description = $request->input('description');
            $service->save();
            return response()->json(['status' => true, 'details' => $service]);
        }
    }
    public function get_service(Request $request, $id)
    {
        // $emp = $request->user();
        // if ($emp->rank != 'super') {
        //     return response()->json(['status' => false, 'details' => 'no permission']);
        // }

        $service = Services::find($id);
        if ($service) {
            return response()->json(['status' => true, 'details' => $service]);
        }
        return response()->json(['status' => false, 'details' => 'no service found']);
    }

    public function get_services_renews_from_to(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $from = request('from');
        $to = request('to');
        // $renews = Renews::query()
        //     ->whereBetween('created_at', [request('from'), request('to')])
        //     ->get();

        $renews = DB::select(DB::raw("  
        SELECT COUNT(service) as count,service from renews,services WHERE services.id = renews.service_id AND renews.checked_by_owner = 'checked' AND renews.created_at BETWEEN '$from' AND '$to' GROUP BY service
"));
        if ($renews) {
            return response()->json(['status' => true, 'details' => $renews]);
        }
        return response()->json(['status' => false, 'details' => 'no result']);
    }
}
