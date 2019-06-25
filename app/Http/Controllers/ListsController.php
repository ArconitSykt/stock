<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;

class ListsController extends Controller
{
    static public function get($list_name) {
        return App\Lists::getListData($list_name);
    }
}
