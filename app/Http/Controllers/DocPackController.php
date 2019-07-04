<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocPackController extends Controller
{
    public function DocPack(Request $request)
    {
        // return $request;
        return view('trans_report', ['data' => $request]);
    }
}
