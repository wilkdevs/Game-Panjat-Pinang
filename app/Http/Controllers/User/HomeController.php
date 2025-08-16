<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MetatagModel;
use App\Models\SettingModel;
use App\Models\VoucherModel;
use App\Models\GiftModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    function index()
    {
        $title = "Selamat Datang di " . env('APP_NAME');

        $code = request('code');
        $voucher = null;
        $gifts = null;

        if ($code) {

            $voucher = VoucherModel::with('gift')->where('code', $code)->where('status', 'pending')->first();

            if ($voucher) {

                // $voucher->status = "claimed";

                if (!isset($voucher->gift_id)) {

                    $giftsWithProbability = GiftModel::with('category')
                        ->whereNull('deleted_at')
                        ->where('active', 1)
                        ->orderBy('created_at')
                        ->get();

                    foreach ($giftsWithProbability as $key => $item) {

                        $probability =  $item->probability;

                        for ($i = 0; $i < $probability; $i++) {
                            $options[] = $key;
                        }
                    }

                    $indexChoosen = $options[rand(0, (count($options) - 1))];

                    $gift_choosen = $giftsWithProbability[$indexChoosen];

                    $voucher->gift_id = $gift_choosen->id;
                }

                $voucher->save();

                $voucher = VoucherModel::with('gift')->find($voucher->id);

                $voucher->load('gift');

                session()->flash('success', 'Berhasil klaim hadiah!');
            } else {
                session()->flash('error', 'Kode voucher tidak ditemukan \n atau sudah digunakan.');
                return redirect()->back();
            }
        }

        $metatag = MetatagModel::where('id', 1)->first();
        $setting_list = SettingModel::all();

        foreach ($setting_list as $item) {
            if (($item['type'] == "image" || $item['type'] == "audio") && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }
            $settings[$item->key] = $item->value;
            $settings[$item->key . "Default"] = $item->default_value;
        }

        // Fetch all active and non-deleted gifts once from the database.
        $gifts = GiftModel::with('category')
            ->whereNull('deleted_at')
            ->where('active', 1)
            ->orderBy('created_at')
            ->get();

        // Create the grouped collection from the $gifts variable.
        $giftsGroupedCategory = $gifts->groupBy('category.name');

        $voucher->load('gift');

        dd($voucher->gift()->image);

        return view('/pages/user/index', [
            'title' => $title,
            'metatag' => $metatag,
            'giftsGroupedCategory' => $giftsGroupedCategory,
            'gifts' => $gifts,
            'voucher' => $voucher,
            'settings' => $settings
        ]);
    }
}
