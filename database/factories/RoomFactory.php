<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'no_room' => $faker->numberbetween(01,12),
        'type_id' => $faker->numberBetween(1,4),
        'status' => $faker->randomElement(['available','booked','maintenance']),
    ];
});
