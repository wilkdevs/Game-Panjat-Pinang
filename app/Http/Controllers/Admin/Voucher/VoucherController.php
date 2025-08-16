<?php

namespace App\Http\Controllers\Admin\Voucher;

use App\Http\Controllers\Controller;
use App\Models\VoucherModel;
use App\Models\GiftModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{

    function index()
    {
        $title = "Daftar Voucher";

        $query = VoucherModel::with('gift')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC');

        $setting_list = SettingModel::where('active', 1)->get();
        foreach ($setting_list as $item) {
            $setting[$item->key] = $item->value;
        }

        $gifts = GiftModel::whereNull('deleted_at')->orderBy('created_at')->get();

        return view('/pages/admin/voucher/index', [
            'setting' => $setting,
            'title' => $title,
            'gifts' => $gifts,
            'list' => $query->paginate(20)->withQueryString(),
        ]);
    }

    function new()
    {
        $title = "Tambah Voucher";

        $gifts = GiftModel::where('deleted_at', NULL)->orderBy('created_at')->get();

        return view('/pages/admin/voucher/form', [
            'title' => $title,
            'gifts' => $gifts,
        ]);
    }

    function edit($id)
    {
        $title = "Ubah Voucher";

        $detail = VoucherModel::where('id', $id)->first();

        $gifts = GiftModel::whereNull('deleted_at')->orderBy('created_at')->get();

        return view('/pages/admin/voucher/form', [
            'title' => $title,
            'detail' => $detail,
            'gifts' => $gifts,
        ]);
    }

    function create(Request $request) {

        $data = $request->all();

        $bulk = intval(isset($data['bulk']) ? $data['bulk'] : "1");

        for ($i = 0; $i < $bulk; $i++) {
            $voucher = $data;
            $voucher['id'] = Uuid::uuid4()->toString();
            $voucher['code'] = $this->generate_unique_voucher_code();
            VoucherModel::create($voucher);
        }

        session()->flash('success', 'Berhasil menambahkan voucher!');

        return redirect('/admin/voucher/list');
    }

    function update(Request $request) {

        $data = $request->all();

        unset($data['_token']);

        VoucherModel::where('id', $data['id'])->update($data);

        session()->flash('success', 'Berhasil mengubah voucher!');

        return redirect('/admin/voucher/list');
    }

    function changeStatus(Request $request) {

        $data = $request->all();

        $name = VoucherModel::where('id', $data['id'])->first();

        $update = [];

        if ($name->active == 1) {
            $update['active'] = 0;
        } else {
            $update['active'] = 1;
        }

        VoucherModel::where('id', $data['id'])->update($update);
    }

    function delete($id) {

        VoucherModel::where('id', $id)->update([
            'deleted_at' => date("Y-m-d H:i:s")
        ]);

        return redirect('/admin/voucher/list');
    }

    function deleteAll() {
        VoucherModel::whereNull('deleted_at')->update([
            'deleted_at' => now()
        ]);

        return redirect('/admin/voucher/list');
    }

    function duplicate($id) {

        $name = VoucherModel::find($id);

        $newName = $name->replicate();

        $newName->id = Uuid::uuid4()->toString();

        $newName->save();

        session()->flash('success', 'Berhasil menduplikat voucher!');

        return redirect('/admin/voucher/list');
    }

    function generate_unique_voucher_code() {
        $maxAttempts = 10; // Maximum number of attempts to generate a unique code
        $codeLength = 6;   // Length of the voucher code

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $code = substr(md5(uniqid(mt_rand(), true)), 0, $codeLength);

            // Check if the code already exists in the database
            $codeExists = VoucherModel::where('code', $code)->exists();

            if (!$codeExists) {
                return $code;
            }
        }

        // If we reach this point, we couldn't generate a unique code after the maximum attempts
        throw new Exception("Unable to generate a unique voucher code.");
    }

}
