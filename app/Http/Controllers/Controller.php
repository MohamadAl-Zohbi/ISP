<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // function create_employee($id){
    //     // $employee = Employees::create(
    //     //     ['name'=>'Mohamad','username'=>'test','password'=>'123','rank'=>'super']
    //     // );
    //     return Employees::findOrFail($id);
    // }
}
