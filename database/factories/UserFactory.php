<?php

namespace Database\Factories;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = User::class;

    public function definition()
    {
        $email = $this->faker->unique()->safeEmail();   
        return [
            'name' => $this->faker->name(),
            'email' => $email,
            'mobile' => $this->faker->unique()->phoneNumber(),
            'image' => $this->faker->imageUrl(),
            'balance'=>number_format($this->rand_float(20,10000,10000), 2, '.', '') ,
            'currency' => $this->faker->currencyCode(),
            'email_verified_at' => now(),
            'password' => Hash::make($email), // password
            'remember_token' => Str::random(10),
        ];
    }
    function rand_float($startNum,$endNum,$mul)
    {
        if ($startNum>$endNum) return false;
        return mt_rand($startNum*$mul,$endNum*$mul)/$mul;
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
