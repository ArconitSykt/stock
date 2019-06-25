<?php

namespace App\Http\Controllers;
use App\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        return Users::getUsers();
    }
    public function raw() {
        return Users::getRawUsers();
    }
    public function get($id) {
        return Users::getUsers($id);
    }

    public function create(Request $request)
    {
        return Users::createUser($request);
    }

    public function update(Request $request, Users $user)
    {
        return Users::updateUser($request);
    }

    public function delete(Request $request, Users $user)
    {
        return Users::deleteUser($request);
    }
}
