<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Computer Science',
            'Information Technology',
            'Engineering',
            'Medicine',
            'Psychology',
            'Sociology',
            'Economics',
            'Business Administration',
            'Accounting',
            'Artificial Intelligence',
            'Data Science',
            'Environmental Science',
            'Political Science',
            'Literature',
            'History',
            'Geology'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}
