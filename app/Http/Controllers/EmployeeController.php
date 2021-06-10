<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $result = \Http::get("http://globaldentaldata.com/api/get_branches");
      $result= collect( json_decode($result));

        $branches = $result->all();
        $current_branch = $request->cookie('branch_id');
        $employees  = Employee::OrderBy('id', 'desc')->limit(10)->get();
        if ($request->ajax()) {
            return view('employee.paginate', compact('employees', 'branches'))->render();
        }
        return view('employee.index', compact('employees', 'branches','current_branch'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'EMP_ID' => 'required|min:9',
            'EMP_NAME' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 504, 'error' => 'حدث خطأ في ادخال البيانات']);
        }
        $exist = Employee::where('EMP_ID', $request->input('EMP_ID'))->get()->count();
        if ($exist > 0) {
            return response()->json(['status' => 504, 'error' => 'موظف موجود :)']);
        }

        $emp = new Employee();
        $emp->EMP_ID = $request->input('EMP_ID');
        $emp->EMP_NAME = $request->input('EMP_NAME');
        $emp->save();
        return response()->json(['status' => 200, 'success' => 'تمت العملية بنجاح']);
    }


    public function storeBranchToUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'branch_id' => 'required|',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 504, 'error' => 'حدث خطأ في ادخال البيانات']);
        }
        $branch_id = $request->input('branch_id');
        $response = new Response('branch id');
        $response->withCookie(cookie('branch_id', $branch_id,1051200));

        return  $response;
    }
}
