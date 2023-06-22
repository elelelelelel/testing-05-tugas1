<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => ' ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0812345678',
            'slug' => 'admin',
            'university' => 'Institut Teknologi Sepuluh Nopember',
            'job' => 'Professional',
            'email_verified_at' => Carbon::now(),
            'gender' => 'Male'
        ]);
        $user->assign('admin');

        $user = User::create([
            'first_name' => 'Reviewer',
            'last_name' => ' ',
            'email' => 'reviewer@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0812345678',
            'slug' => 'reviewer',
            'university' => 'Institut Teknologi Sepuluh Nopember',
            'job' => 'Professional',
            'email_verified_at' => Carbon::now(),
            'gender' => 'Male',
            'similarity' => 75,
            'reviewer_approved_at' => Carbon::now(),
            ]);
        $user->assign('reviewer');

        $id_user_reviewer = $user->id;
        $all_id_sub_category = SubCategory::all()->pluck('id')->toArray();

        // add user_id and all sub_category_id to table user_sub_categories
        foreach ($all_id_sub_category as $id_sub_category) {
            DB::table('user_sub_categories')->insert([
                'user_id' => $id_user_reviewer,
                'sub_category_id' => $id_sub_category
            ]);
        }

        $user = User::create([
            'first_name' => 'Editor',
            'last_name' => ' ',
            'email' => 'editor@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0812345678',
            'slug' => 'editor',
            'university' => 'Institut Teknologi Sepuluh Nopember',
            'job' => 'Professional',
            'email_verified_at' => Carbon::now(),
            'gender' => 'Male'
        ]);
        $user->assign('editor');

        $user = User::create([
            'first_name' => 'Makelar',
            'last_name' => ' ',
            'email' => 'makelar@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0812345678',
            'slug' => 'makelar',
            'university' => 'Institut Teknologi Sepuluh Nopember',
            'job' => 'Professional',
            'email_verified_at' => Carbon::now(),
            'gender' => 'Male'
        ]);
        $user->assign('makelar');
    }
}
