<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Agreements;
use Illuminate\Http\Request;

class AgreementsController extends Controller
{
    public function index() {
        return Agreements::get();
    }

    public function store(Request $request) {
        $attachment = new Agreements;
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $name = uniqid("ricoko_", true);
        if (Storage::putFileAs('/public/agreements/', $file, $name.'.'.$ext)) {
            return $attachment::create([
                'name_file' => $request['name'],
                'path_file' => "storage/agreements/".$name.'.'.$ext,
              ]);
          }

        return response()->json(false);
    }

    public function search(Request $request) {
        return Agreements::search($request);
    }
}
