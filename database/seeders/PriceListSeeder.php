<?php

namespace Database\Seeders;

use App\Models\PriceList;
use Illuminate\Database\Seeder;

class PriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices = [1000000, 2000000, 5000000];
        $packages = ['Bronze', 'Silver', 'Gold'];
        $tooltip = ['Review Artikel', 'Review Artikel dan Check Plagiarism', 'Review Artikel ,Check Plagiarism, dan Konsul by Email'];
        foreach ($prices as $i => $price) {
            PriceList::create([
                'price' => $price,
                'package' => $packages[$i],
                'tooltip' => $tooltip[$i],
                'description' => $tooltip[$i]
            ]);
        }
    }
}
