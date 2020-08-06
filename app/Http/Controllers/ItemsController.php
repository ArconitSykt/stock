<?php

namespace App\Http\Controllers;
use App\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

    public function getHystoryItem($id) {
        return Items::getHystoryItem($id);
    }

    public function selectYear($id) {
        return Items::selectYear($id);
    }

    public function itemsFilter($id) {
        return Items::getItemsFiltering($id);
    }

    public function ulpoad_import_file(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $name = uniqid("import_excel_");
        if (Storage::putFileAs('/public/import_items/', $file, $name.'.'.$ext)) {
            return response()->json($name.'.'.$ext);
          }

        return response()->json(false);
    }
    
    public function import(Request $request) {
        return Items::import($request->link,$request->id);
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