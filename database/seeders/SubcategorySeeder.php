<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            'Mathematics' => ['Algebra', 'Geometry', 'Calculus'],
            'Physics' => ['Mechanics', 'Thermodynamics', 'Electromagnetism'],
            'Chemistry' => ['Organic Chemistry', 'Inorganic Chemistry', 'Physical Chemistry'],
            'Biology' => ['Botany', 'Zoology', 'Microbiology'],
            'Computer Science' => ['Programming', 'Data Structures', 'Algorithms'],
            'Information Technology' => ['Database Management', 'Network Administration', 'Web Development'],
            'Engineering' => ['Civil Engineering', 'Electrical Engineering', 'Mechanical Engineering'],
            'Medicine' => ['Internal Medicine', 'Surgery', 'Pediatrics'],
            'Psychology' => ['Cognitive Psychology', 'Developmental Psychology', 'Abnormal Psychology'],
            'Sociology' => ['Social Stratification', 'Cultural Sociology', 'Sociological Theory'],
            'Economics' => ['Microeconomics', 'Macroeconomics', 'International Economics'],
            'Business Administration' => ['Marketing', 'Finance', 'Human Resources'],
            'Accounting' => ['Financial Accounting', 'Managerial Accounting', 'Auditing'],
            'Artificial Intelligence' => ['Machine Learning', 'Natural Language Processing', 'Computer Vision'],
            'Data Science' => ['Data Analysis', 'Data Visualization', 'Big Data'],
            'Environmental Science' => ['Ecology', 'Environmental Chemistry', 'Climate Science'],
            'Political Science' => ['Political Theory', 'Comparative Politics', 'International Relations'],
            'Literature' => ['Poetry', 'Fiction', 'Drama'],
            'History' => ['Ancient History', 'World History', 'Modern History'],
            'Geology' => ['Mineralogy', 'Petrology', 'Geophysics']
        ];

        $subCategoryCount = 0;

        foreach ($subcategories as $categoryName => $subCategoryNames) {
            $category = Category::where('name', $categoryName)->first();

            if (!$category) {
                continue;
            }

            foreach ($subCategoryNames as $subCategoryName) {
                SubCategory::create([
                    'category_id' => $category->id,
                    'name' => $subCategoryName,
                    'slug' => Str::slug($subCategoryName)
                ]);

                $subCategoryCount++;

                if ($subCategoryCount >= 60) {
                    break 2;
                }
            }
        }
    }
}
