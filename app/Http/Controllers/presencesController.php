<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class presencesController extends Controller
{
    public function create()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $data = $request->input("image");

        $image_64 = $data; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

// find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = \Str::random(10).'.'.$extension;

        \Storage::disk('public')->put($imageName, base64_decode($image));
    }
}
