<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class presencesController extends Controller
{
   

    public function create(Request $request)
    {
            $branches = Branch::all();
            $presence = Presence::OrderBy("id",'desc')->limit(20)->get();
        if ($request->ajax()){
            return view('paginate',compact('presence','branches'))->render();
        }
        return view('index',compact('presence','branches'));
    }

    public function store(Request $request)
    {


       $validation =Validator::make($request->all(),[
           'employee_id'=>'required|min:6',
           'image'=>'required',
           'status'=>'required',
           'branch_id'=>'required'
       ]);
       if($validation->fails()){
           return response()->json(['status'=>504,'error'=>'حدث خطأ في ادخال البيانات']);
       }
        $exist = Presence::where('employee_id',$request->input('employee_id'))->where('status',$request->input('status'))->whereDate('created_at', Carbon::today())->get()->count();
        if ($exist>0){
            return response()->json(['status'=>504,'error'=>'لقد بالتسجيل مسبقا']);

        }
       $data = $request->input("image");

        $image_64 = $data; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

// find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = time().'.'.$extension;
        \Storage::disk('public')->put($imageName, base64_decode($image));
        $presence = new Presence();
        $presence->employee_id = $request->input('employee_id');
        $presence->status = $request->input('status');
        $presence->image =$imageName;
        $presence->branch_id=$request->input('branch_id');
        $presence->created_at = Carbon::now()->setTimezone('Asia/Gaza');
        $presence->save();
        return response()->json(['status'=>200,'success'=>'حبيتك تنسيت النوم']);

    }
}
