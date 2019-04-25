<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\GoodImg::class, function (Faker $faker) {
    return [
        'good_id' => array_random(\App\Models\Good::pluck('id')->toArray()),
        'img_url' => $faker->imageUrl()
    ];
});
