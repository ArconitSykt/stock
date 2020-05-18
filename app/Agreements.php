<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Agreements extends Model
{
    public $timestamps = false;
    protected $fillable = ['name_file', 'path_file'];


    public static function get() {
        return DB::table('agreements')
        ->orderBy('id_file', 'desc')
        ->get();
    }
    
    public static function search($req) {
        return DB::table('items')
        ->join('users', 'users.id_user','=','items.current_user_item')
        ->select('items.*', 'users.name_user')
        ->where('items.num_agrement_item', $req->num_agreement == null ? "~": $req->num_agreement)
        ->orWhere('items.date_agrement_item', $req->date_agreement == null ? "1" : $req->date_agreement)
        ->get();
    }
}