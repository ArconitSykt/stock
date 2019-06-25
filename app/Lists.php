<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    public static function getListData($name_list) {
        return DB::table($name_list)
        ->get();
    }
}
