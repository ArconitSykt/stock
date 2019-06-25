<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class BarcodeController extends Controller
{
    public function show($id)
    {
        return view('barcode', ['data' => $id, 'items' => App\Items::getUserItems($id)]);
    }
}
