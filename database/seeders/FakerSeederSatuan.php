<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;
use Str;

class FakerSeederSatuan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 500; $i++) {
            $satuan = new Satuan();
            $satuan->nama = $faker->name;
            $satuan->slug = Str::slug($satuan->nama);
            $satuan->save();
        }
    }
}
