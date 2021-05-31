<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class presencesController extends Controller
{


    public function create(Request $request)
    {
            $branches = Branch::all();
            $presence = Presence::OrderBy("id",'desc')->limit(20)->get();
        if ($request->ajax()){
            return view('paginate',compact('presence','branches'))->render();
        }
        $user_id = User::first()->branch_id;
        return view('index',compact('presence','branches','user_id'));
    }

    public function store(Request $request)
    {

        $rules = [
            'employee_id' => 'required|min:9',
            'status' => 'required',
            'branch_id' => 'required',
            'image' => 'required',

        ];
        $messages = [
            'employee_id.required' => 'الرقم الوظيفي مطلوب',

            "employee_id.min"=>'الرقم الوظيفي غير صحيح الرجاءالتأكد من الرقم',
            'status.required' => 'الحالة مطلوبة',
            'required.required' => ' الفرع مطلوب',
            'image.required'=>'تأكد من تشغيل الكاميرا على المتصفح'
        ];

        $validator = Validator::make($request->all(),
            $rules
            ,
            $messages
        );
        if($validator->fails()) {
            return response()->json(['status' => false , 'data_validator' => $validator->messages() ]);
        }
        $exist = Employee::where('EMP_ID',$request->input('employee_id'))->get();

        if ($exist->isEmpty()){
            return response()->json(['status'=>504,'error'=>'الرقم الوظيفي غير مسجل لدينا']);
        }

        $duplicate = Presence::where('employee_id',$request->input('employee_id'))->where('status',$request->input('status'))->whereDate('created_at', Carbon::today())->get()->count();
        if ($duplicate>0){
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
        Storage::disk('public')->put($imageName, base64_decode($image));
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
