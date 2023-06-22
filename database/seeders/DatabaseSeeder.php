<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\SubCategory;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->call(RoleSeeder::class);
            $this->call(PriceListSeeder::class);
            $this->call(AdminBankSeeder::class);
            $this->call(SettingSeeder::class);

            $this->call(CategorySeeder::class);
            $this->call(SubcategorySeeder::class);
            $this->call(UserSeeder::class);
            UserFactory::times(1000)->create();
            $this->call(OrderSeeder::class);
            $this->call(WithdrawSeeder::class);
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
