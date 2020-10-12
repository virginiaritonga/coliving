<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Type;
use Faker\Generator as Faker;

$factory->define(Type::class, function (Faker $faker) {
    return [
        'type_name' => $faker->sentence(1),
        'rent_price'=> $faker->numberBetween(1000000,5000000),
        'capacity' => $faker->numberBetween(1,4),
    ];
});
