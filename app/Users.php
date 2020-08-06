<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public static function getUsers() {
        $users =  DB::table('users')->where('parent_user', 0)->orderBy('type_user', 'asc')->orderBy('name_user', 'asc')->get();
        $users = Users::getChild($users);
        return $users;
    }

    public static function getRawUsers() {
        return DB::table('users')->get();
    }

    public static function getChild($users) {
        foreach ($users as $key => $value) {
            $child = DB::table('users')->where('parent_user', $value->id_user)->orderBy('type_user', 'asc')->orderBy('name_user', 'asc')->get();
            $count = count($child);
            if(count($child) > 0) {
                $count--;
                $users[$key]->children = $child;
                Users::getChild($child);
            }
        }
        return $users;
    }

    public static function getUser($id) {
        return DB::table('users')
        ->where('id_user', $id)
        ->get();
    }

    public static function updateUser($req) {
        return DB::table('users')
            ->where('id_user', $req->id_user)
            ->update([
                'name_user' => $req->name_user??"",
                'type_user' => $req->type_user??"",
                'requisites_user' => $req->requisites_user??"",
                'parent_user' => $req->parent_user??0,
            ]);
    }

    public static function createUser($req) {
        try {
            DB::table('users')
            ->insert([
                'name_user' => $req->name_user,
                'type_user' => $req->type_user??"",
                'requisites_user' => $req->requisites_user??"",
                'parent_user' => $req->parent_user??0,
            ]);
            return "success";
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public static function deleteUser($req) {
        try {
            return DB::table('users')
            ->where('id_user', $req->id_user)
            ->update([
                'parent_user' => -1
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}