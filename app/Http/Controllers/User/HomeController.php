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
                $voucher->status = "claimed";

                if (!isset($voucher->gift_id)) {
                    // Get all gifts with a probability greater than 0
                    $giftsWithProbability = GiftModel::with('category')
                        ->where('probability', '>', 0)
                        ->whereNull('deleted_at')
                        ->where('active', 1)
                        ->orderBy('created_at')
                        ->get();

                    // Calculate the total probability of all available gifts
                    $totalProbability = $giftsWithProbability->sum('probability');

                    // If there are no gifts with probability > 0, we can't assign one
                    if ($totalProbability > 0) {
                        // Generate a random number between 0 and the total probability
                        $randomNumber = mt_rand(0, $totalProbability);
                        $cumulativeProbability = 0;
                        $assignedGift = null;

                        // Loop through the gifts to find the winning gift
                        foreach ($giftsWithProbability as $gift) {
                            $cumulativeProbability += $gift->probability;
                            if ($randomNumber <= $cumulativeProbability) {
                                $assignedGift = $gift;
                                break; // Stop the loop once a gift is found
                            }
                        }

                        // If a gift was successfully assigned, link it to the voucher
                        if ($assignedGift) {
                            $voucher->gift_id = $assignedGift->id;
                        }
                    } else {
                        session()->flash('error', 'Kuota hadiah telah habis.');
                        return redirect()->back();
                    }
                }

                $voucher->save();

                $voucher = VoucherModel::with('gift')->find($voucher->id);

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
