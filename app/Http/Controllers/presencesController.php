<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;

class presencesController extends Controller
{
    public function create()
    {
        return view('welcome');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
        ]);


        $presences = new Presence();
        $presences->branch_id = '1';
        $presences->employee_id = $request->input('employee_id');
        $presences->status = $request->input('status');
        $presences->save();
    }

    
}
