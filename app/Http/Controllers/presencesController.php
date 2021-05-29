<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class presencesController extends Controller
{
    public function create(Request $request)
    {
        if ($request->ajax()){
            $presence = Presence::OrderBy("id",'desc')->limit(20)->get();
            return view('paginate',compact('presence'))->render();
        }
        $presence = Presence::OrderBy("id",'desc')->limit(20)->get();
        return view('index',compact('presence'));
    }

    public function store(Request $request)
    {
       $validation =Validator::make($request->all(),[
           'employee_id'=>'required',
           'image'=>'required',
           'status'=>'required'
       ]);
       if($validation->fails()){
           return response()->json(['status'=>504,'error'=>'حدث خطأ في ادخال البيانات']);
       }
        $data = $request->input("image");

        $image_64 = $data; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

// find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = \Str::random(10).'.'.$extension;
        \Storage::disk('public')->put($imageName, base64_decode($image));

        $presence = new Presence();
        $presence->employee_id = $request->input('employee_id');
        $presence->status = $request->input('status');
        $presence->image = $imageName;
        $presence->branch_id=1;
        $presence->save();
        return response()->json(['status'=>200,'success'=>'حبيتك تنسيت النوم']);

    }
}
