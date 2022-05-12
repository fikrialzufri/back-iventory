<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;
use Str;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuanPcs = Satuan::where('slug', 'pcs')->first();
        if (!$satuanPcs) {
            $satuanPcs = new Satuan();
        }
        $satuanPcs->nama = 'Pcs';
        $satuanPcs->slug = Str::slug($satuanPcs->nama);
        $satuanPcs->save();

        $satuanLiter = Satuan::where('slug', 'liter')->first();
        if (!$satuanLiter) {
            $satuanLiter = new Satuan();
        }
        $satuanLiter->nama = 'Liter';
        $satuanLiter->slug = Str::slug($satuanLiter->nama);
        $satuanLiter->save();

        $satuanKg = Satuan::where('slug', 'kg')->first();
        if (!$satuanKg) {
            $satuanKg = new Satuan();
        }
        $satuanKg->nama = 'Kg';
        $satuanKg->slug = Str::slug($satuanKg->nama);
        $satuanKg->save();

        $satuanCm = Satuan::where('slug', 'cm')->first();
        if (!$satuanCm) {
            $satuanCm = new Satuan();
        }
        $satuanCm->nama = 'Cm';
        $satuanCm->slug = Str::slug($satuanCm->nama);
        $satuanCm->save();
    }
}
