<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
     public function index(Request $request)
    {
        return view('permission.index');
    }

    public function update($id)
    {
        return view('permission.update')->with('id',$id);
    }
}
