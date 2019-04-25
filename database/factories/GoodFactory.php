<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Good::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'price' => 99.99,
        'sales_volume' => 99,
        'describe' => $faker->paragraph,
    ];
});
