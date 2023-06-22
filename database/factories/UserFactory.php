<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $jobOptions = ['Student' , 'Business', 'Researcher', 'Author', 'Professional'];
        $genderOptions = ['Male', 'Female'];
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'slug' => $this->faker->unique()->slug(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => $this->faker->phoneNumber(),
            'university' => $this->faker->company(),
            'job' => $this->faker->randomElement($jobOptions),
            'email_verified_at' => Carbon::now(),
            'gender' => $this->faker->randomElement($genderOptions),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {

        return $this->afterCreating(function (User $user) {
            $user->assign($this->faker->randomElement(['reviewer', 'makelar', 'editor']));

            $id_role_reviewer = Role::where('name', 'reviewer')->first()->id;
            $reviewer = UserRole::where('user_id', $user->id)->where('role_id', $id_role_reviewer)->first();

            // if assign reviewer, then add similarity
            if ($reviewer) {

                $random = rand(0, 1);

                if($random == 1) {
                    $user->similarity = $this->faker->numberBetween(71, 75);
                    $user->reviewer_approved_at = Carbon::now();
                } else {
                    $user->similarity = $this->faker->numberBetween(60, 65);
                    $user->reviewer_declined_at = Carbon::now();
                }
                $user->save();

                $sub_category_id = SubCategory::pluck('id')->toArray();

                for ($i = 0; $i < 10; $i++) {
                    $user->subCategories()->attach($this->faker->randomElement($sub_category_id));
                }
            }
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
