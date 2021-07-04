<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class presencesController extends Controller
{

    public function create(Request $request)
    {
        $branch_id = $request->cookie('branch_id');

$presence = Http::get('http://globaldentaldata.com/api/filter_attend/global_get_attend',[
    'branch_id'=>$branch_id,
    'date'=>Carbon::today()->format('Y-m-d')
]);
    $presence = json_decode($presence);
        if ($request->ajax()) {
            return view('paginate', compact('presence','branch_id'))->render();
        }

        return view('index', compact('presence', 'branch_id'));
    }

    public function store(Request $request)
    {

           $validator = Validator::make(
                    $request->all(),
                    $this->rules(),
                    $this->messages()
                );
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'data_validator' => $validator->messages()]);
                }

        /*
                   $exist = \Http::get('http://globaldentaldata.com/api/check_exists_emp/'.$request->input('employee_id'));
                   $exist =json_decode($exist);
                   if (!$exist) {
                       return response()->json(['status' => 504, 'error' => 'الرقم الوظيفي غير مسجل لدينا']);
                   }

                   //to check if employee already registerd
                   $duplicate = Presence::where('employee_id', $request->input('employee_id'))->whereDate('created_at', Carbon::today())->get();
                   $count = $duplicate->count();

                   if ($count > 0) {
                       return response()->json(['status' => 504, 'error' => 'لقد قمت بالتسجيل مسبقا']);
                   }*/

        //to check if employee still in work yet

     /*   if ($request->input('status') == "C/Out") {
            $hourNow = Carbon::now()->format('H');
            $test_status = Presence::where('employee_id', $request->input('employee_id'))->where('status', "C/In")->whereDate('created_at', Carbon::today())->first();

            if (is_null($test_status)){
                return response()->json(['status'=>504,'error'=>'لم يتم تسجيل الدخول مسبقا']);
            }
            $come_in =  $test_status->created_at->format('H');;
            if ($request->input('comming_out')){

            }
            else if (($hourNow - $come_in) < 5) {


                    return response()->json(['status' => 505, 'error' => 'لم تتجاوز عدد ساعات الدوام','message'=>'هل انت متأكد؟']);


            }


        }*/

        $data = $request->input("image");
        $image_64 = $data; //your base64 encoded data
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

        // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '.' . $extension;
        Storage::disk('public')->put($imageName, base64_decode($image));

         $status = Http::get('http://globaldentaldata.com/api/store_attend/global_store',[
            'employee_id'=>$request->input('employee_id'),
            'branch_id'=>$request->input('branch_id'),
            'created_at'=>Carbon::now()->setTimezone('Asia/Gaza')->format('Y-m-d H:i:s'),
            'image'=>$imageName,
            'status'=>$request->input('status')
           ]);
         $response = json_decode($status);
        if ($response->status == 200){
            return response()->json(['status' => 200, 'success' => $response->success]);
        }
        else{
            return response()->json(['status' => 504, 'error' => $response->error]);
        }

/*   $presence = new Presence();
        $presence->employee_id = $request->input('employee_id');
        $presence->status = $request->input('status');
        $presence->image = $imageName;
        $presence->branch_id = $request->input('branch_id');
        $presence->created_at = Carbon::now()->setTimezone('Asia/Gaza');
        $presence->save();*/

     //   return response()->json(['status' => 200, 'success' => 'تمت العملية']);
    }

    public function messages()
    {
        return   $messages = [
            'employee_id.required' => 'الرقم الوظيفي مطلوب',
            "employee_id.min" => 'الرقم الوظيفي غير صحيح الرجاءالتأكد من الرقم',
            'status.required' => 'الحالة مطلوبة',
            'required.required' => ' الفرع مطلوب',
            'image.required' => 'تأكد من تشغيل الكاميرا على المتصفح',
            'branch_id.exists'=> 'الجهاز غير مسجل لدينا'
        ];
    }

    public function rules()
    {
        return $rules = [
            'employee_id' => 'required|min:9',
            'status' => 'required',
            'branch_id' => 'exists:branch,id',
            'image' => 'required',
        ];
    }

    public function presencesList(Request $request)
    {
        $branch = \Http::get("http://globaldentaldata.com/api/get_branches");
        $branch_all= collect( json_decode($branch));

        setLocale(LC_ALL , 'ar_EG.UTF-8');
        $precenses=collect();
        $employees = Http::get("http://globaldentaldata.com/api/get_all_employee/global_secret");
        $employees = json_decode($employees);
        if ($request->ajax() ){

            $precenses =  Http::get("http://globaldentaldata.com/api/filter_attend/global_filter_attend",[
                'employee_id'=>$request->input('employee_id'),
                'start_date'=> $request->input("start_date"),
                'end_date'=>$request->input("end_date"),
                'branch_id'=>$request->input("branch_id")
            ]);
        $data['precenses']= json_decode($precenses);

        return view('paginate_list',$data)->render();
        }
        $data['branches']=$branch_all;
        $data['precenses']= $precenses;
        $data['employees']= $employees;
        return view('presences-list', $data);
    }
    public function delete_presences(Request $request){

        $request->validate(['items'=>'required'],[
            'items.required'=>'لم يتم تحديد اي حقل'
        ]);
        $ids = explode(',',$request->input('items'));

        $precenses =  Http::get("http://globaldentaldata.com/api/delete_attend/del_att",[
            'attend_ids'=>$ids,
        ]);
  $precenses= json_decode($precenses);

  if ($precenses->status == 200){
    return response()->json(['status'=>200]);
  }

    }
}
