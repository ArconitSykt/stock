<?php

namespace App\Http\Controllers;
use App\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index() {
        return Items::getItems();
    }

    public function get($id) {
        return Items::getItem($id);
    }

    public function getUserItems($id) {
        return Items::getUserItems($id);
    }

    public function create(Request $request)
    {
        return Items::createItem($request);
    }

    public function update(Request $request, Items $item)
    {
        return Items::updateItem($request);
    }

    public function delete(Request $request, Items $item)
    {
        return Items::deleteItem($request);
    }
}
