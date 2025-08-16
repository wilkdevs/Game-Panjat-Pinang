<?php

namespace App\Http\Controllers\Admin\Gift;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SettingModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    function index()
    {
        $title = "Daftar Kategori";

        $list = CategoryModel::where('deleted_at', NULL)->orderBy('created_at')->get();

        $setting_list = SettingModel::where('active', 1)->get();
        foreach ($setting_list as $item) {
            $setting[$item->key] = $item->value;
        }

        return view('/pages/admin/category/index', [
            'setting' => $setting,
            'title' => $title,
            'list' => $list,
        ]);
    }

    function new()
    {
        $title = "Tambah Kategori";

        return view('/pages/admin/category/form', [
            'title' => $title,
        ]);
    }

    function edit($id)
    {
        $title = "Ubah Kategori";

        $detail = CategoryModel::where('id', $id)->first();

        return view('/pages/admin/category/form', [
            'title' => $title,
            'detail' => $detail,
        ]);
    }

    function create(Request $request) {

        $data = $request->all();

        $exists = CategoryModel::where('name', $data['name'])
            ->whereNull('deleted_at')
            ->exists();

        if ($exists) {
            session()->flash('failed', 'Kategori sudah terdaftar!');
            return redirect()->back();
        }

        $data['id'] = Uuid::uuid4()->toString();

        CategoryModel::create($data);

        session()->flash('success', 'Berhasil menambahkan kategori!');

        return redirect('/admin/gift/category/list');
    }

    function update(Request $request) {

        $data = $request->all();

        unset($data['_token']);

        CategoryModel::where('id', $data['id'])->update($data);

        session()->flash('success', 'Successfully changed the category!');

        return redirect('/admin/gift/category/list');
    }

    function changeStatus(Request $request) {

        $data = $request->all();

        $name = CategoryModel::where('id', $data['id'])->first();

        $update = [];

        if ($name->active == 1) {
            $update['active'] = 0;
        } else {
            $update['active'] = 1;
        }

        CategoryModel::where('id', $data['id'])->update($update);
    }

    function delete($id) {

        CategoryModel::where('id', $id)->update([
            'deleted_at' => date("Y-m-d H:i:s")
        ]);

        return redirect('/admin/gift/category/list');
    }

    function deleteAll() {
        CategoryModel::whereNull('deleted_at')->update([
            'deleted_at' => now()
        ]);

        return redirect('/admin/gift/category/list');
    }

    function duplicate($id) {

        $name = CategoryModel::find($id);

        $newName = $name->replicate();

        $newName->id = Uuid::uuid4()->toString();

        $newName->save();

        session()->flash('success', 'Berhasil menduplikat kategori!');

        return redirect('/admin/gift/category/list');
    }
}
