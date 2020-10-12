<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tenant;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'tenant_name' => $faker->name(),
        'no_KTP' => $faker->unique()->randomNumber(),
        'no_HP' => $faker->unique()->randomNumber(),
        'address' => $faker->address,
        'status' => $faker->randomElement(['active','inactive'])
    ];
});
