<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    public static function getItems() {
        return DB::table('items')
        ->join('list_status_item', 'list_status_item.id_status','=','items.status_item')
        ->join('users', 'users.id_user','=','items.current_user_item')
        ->select('items.*', 'list_status_item.name_status', 'users.name_user')
        ->get();
    }

    public static function getUserItems($id) {
        return DB::table('items')
        ->join('list_status_item', 'list_status_item.id_status','=','items.status_item')
        ->select('items.*', 'list_status_item.name_status')
        ->where('items.current_user_item', $id)
        ->get();
    }

    public static function getItem($id) {
        return response()->json(DB::table('items')
        ->where('id_item', $id)
        ->first());
    }

    public static function updateItem($req) {
        DB::table('items_hystory')->insert(
            [
                'current_user_hystory' => $req->current_user_item??1,
                'reason_hystory' => $req->reason_for_move??"",
                'id_item_hystory' => $req->id_item??1,
                'item_status_hystory' => $req->status_item??1,
                
            ]
        );
        return DB::table('items')
            ->where('id_item', $req->id_item)
            ->update([
                'caption_item' => $req->caption_item??"",
                'reg_num_item' => $req->reg_num_item??"",
                'ser_num_item' => $req->ser_num_item??"",
                'num_agrement_item' => $req->num_agrement_item,
                'date_agrement_item' => $req->date_agrement_item,
                'notation_item' => $req->notation_item,
                'accounting_item' => $req->accounting_item??"",
                'comment_item' => $req->comment_item??"",
                'current_user_item' => $req->current_user_item??1,
                'status_item' => $req->status_item??1,
                'depreciation_item' => $req->depreciation_item??0,
                'buy_date_item' => $req->buy_date_item,
                'guarantee_date_item' => $req->guarantee_date_item,
            ]);
    }

    public static function createItem($req) {
        try {
            DB::table('items')->insert(
                [
                    'caption_item' => $req->caption_item,
                    'reg_num_item' => $req->reg_num_item,
                    'ser_num_item' => $req->ser_num_item??"",
                    'num_agrement_item' => $req->num_agrement_item,
                    'date_agrement_item' => $req->date_agrement_item,
                    'notation_item' => $req->notation_item,
                    'accounting_item' => $req->accounting_item??"",
                    'buy_date_item' => $req->buy_date_item,
                    'guarantee_date_item' => $req->guarantee_date_item,
                    'comment_item' => $req->comment_item??"",
                    'current_user_item' => $req->current_user_item??1,
                    'status_item' => $req->status_item??1,
                    'depreciation_item' => $req->depreciation_item??0,
                ]
            );
            return "success create item";
        } catch (\Throwable $th) {
            return "error: ".$th;
        }
    }
    public static function deleteItem($req) {
        try {
            return DB::table('items')
            ->where('id_item', $req->id_item)
            ->update([
                'current_user_item' => -1
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public static function getHystoryItem($id) {
        return DB::table('items_hystory')
        ->join('users', 'users.id_user','=','items_hystory.current_user_hystory')
        ->join('list_status_item', 'list_status_item.id_status','=','items_hystory.item_status_hystory')
        ->select('items_hystory.*', 'list_status_item.name_status', 'users.name_user')
        ->where('items_hystory.id_item_hystory', $id)
        ->orderBy('id_hystory', 'desc')
        ->get();
    }
}