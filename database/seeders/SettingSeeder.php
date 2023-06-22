<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = ['Punishment', 'Minimal Rating', 'Threshold', 'Threshold Minimal', 'Threshold Maximal'];
        $values = [10, 3, 70, 65, 75];
        foreach ($settings as $i => $setting) {
            $check = Setting::whereSlug(Str::slug($setting))->first();
            if (!$check) {
                Setting::create([
                    'name' => $setting,
                    'slug' => Str::slug($setting),
                    'value' => $values[$i]
                ]);
            }
        }
    }
}
