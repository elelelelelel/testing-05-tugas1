<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class WithdrawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $reviewer = User::where('balance', '>', 0)->get();
        $bank_name = ['BCA', 'BNI', 'BRI', 'Mandiri'];
        foreach ($reviewer as $user) {
            $amount = random_int($user->balance / 2, $user->balance);

            User::where('id', $user->id)->update([
                'balance' => $user->balance - $amount
            ]);

            Withdraw::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'behalf' => $user->first_name . ' ' . $user->last_name,
                'bank_name' => $bank_name[random_int(0, 3)],
                'bank_number' => $faker->bankAccountNumber,
                'confirmed_at' => rand(0, 1) ? Carbon::now()->addDays(random_int(6, 12))->addHours(random_int(1, 23))->addMinutes(random_int(1 , 59)) : null,
            ]);
        }

    }
}
