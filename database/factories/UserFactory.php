<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\Dcat\Admin\Models\Administrator::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->userName.Str::random(4),
        'name' => $faker->name,
        'avatar' => null,
        'remember_token' => null,
        'password' => '$2y$10$WdZ.V.KuwbgQI6Nl.ODz..aSV0sS2FwUYPKKbrFzwum8WpGrA7OYO', // password
        'created_at' => now(),
    ];
});
