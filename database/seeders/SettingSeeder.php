<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('setting')->truncate();

        DB::table('setting')->insert([
            [
                'id' => '0',
                'key' => 'websiteName',
                'title' => 'Website Name',
                'value' => 'Panjang Pinang - Brand123',
                'default_value' => null,
                'type' => 'text',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-21 05:57:54',
            ],
            [
                'id' => '31',
                'key' => 'logoImage',
                'title' => 'Logo Brand',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-21 08:41:54',
            ],
            [
                'id' => '32',
                'key' => 'faviconImage',
                'title' => 'Favicon Image ',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-21 08:42:02',
            ],
            [
                'id' => '41',
                'key' => 'backgroundImage',
                'title' => 'Gambar Latar Utama',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:34:39',
            ],
            [
                'id' => '43',
                'key' => 'previewGameImage',
                'title' => 'Gambar Pratinjau Game',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:34:39',
            ],
            [
                'id' => '44',
                'key' => 'previewGameGif',
                'title' => 'GIF Pratinjau Game',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:34:39',
            ],
            [
                'id' => '45',
                'key' => 'backgroundImageGame',
                'title' => 'Gambar Latar Game',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:34:39',
            ],
            [
                'id' => '46',
                'key' => 'spinWheelImage',
                'title' => 'Gambar Roda Gantungan Hadiah',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:34:39',
            ],
            [
                'id' => '47',
                'key' => 'giftImage',
                'title' => 'Gambar Hadiah',
                'value' => null,
                'default_value' => null,
                'type' => 'image',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:34:39',
            ],
            [
                'id' => '51',
                'key' => 'adminLink',
                'title' => 'Link Admin',
                'value' => null,
                'default_value' => "https://wa.me/6287790900101",
                'type' => 'text',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:54:11',
            ],
            [
                'id' => '52',
                'key' => 'terms',
                'title' => 'Syarat dan Ketentuan',
                'value' => null,
                'default_value' => "<p>1. Event ini berlaku untuk semua member BRAND123 </p><p>2. Minimal Deposit untuk Klaim Promo ini adalah Rp 50.000</p><p>3. Member WAJIB melakukan Deposit dalam Event ini adalah Rp 50.000 , Rp 250.000 , atau Rp 500.000 </p><p>Untuk mendapatkan 1 TIKET (TIDAK BERLAKU KELIPATAN)</p><p>Contoh : Jika Deposit sebesar Rp 300.000, maka hanya mendapatkan 1 TIKET saja untuk Claim Event ini</p><p> </p><p>4. Maksimal Claim TIKET adalah 2x Per - ID dalam Sehari </p><p>5. Untuk mendapatkan TIKET member WAJIB memainkan saldo TURNOVER x1 dari Nilai Deposit</p><p>6. Untuk Claim Event ini member harus bermain di GAME SLOT, dan tidak untuk permainan SPACEMAN, CLASSIC SLOT, CASINO, SPORTSBOOK, dan GGSOFT</p><p>7. Wajib JOIN &amp; SHARE Screenshot History Deposit Terbaru ke Semua Grup Official BRAND123 dengan menggunakan</p><p>CAPTION : PANJAT CUAN KEMERDEKAAN BRAND123</p><p> </p><p>8. TIKET tidak di berikan secara Otomatis, WAJIB Claim melalui LIVECHAT RESMI BRAND123 dengan Mengirimkan Semua Bukti Share </p><p>9. TIKET HANYA BERLAKU SAMPAI JAM 23:50 WIB, JIKA TIKET TIDAK TERPAKAI MAKA TIKET TERSEBUT DI NYATAKAN HANGUS</p><p>10. EVENT INI TIDAK DAPAT DI GABUNGKAN DENGAN EVENT ATAUPUN BONUS LAIN NYA </p><p>11. DILARANG melakukan WITHDRAW sebelum BONUS di bagikan, Jika melakukan WITHDRAW maka BONUS di anggap HANGUS </p><p>12. Syarat Dan Ketentuan Promo Ini Dapat Berubah Sewaktu - Waktu serta Segala Keputusan BRAND123 adalah MUTLAK dan Tidak Dapat Di Ganggu Gugat</p>",
                'type' => 'quill',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:54:11',
            ],
            [
                'id' => '53',
                'key' => 'termsHeadColors',
                'title' => 'Warna Latar S&K',
                'value' => json_encode(["#ff0000","#ffffff"]),
                'default_value' => json_encode(["#ff0000","#ffffff"]),
                'type' => 'gradientColor',
                'active' => 1,
                'created_at' => '2025-07-22 07:55:50',
                'updated_at' => '2025-07-26 04:54:11',
            ],
        ]);
    }
}
