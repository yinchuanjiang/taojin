<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Banner::class, function (Faker $faker) {
    return [
        'img_url' => $faker->imageUrl(),
        'status' => \App\Models\Enum\BannerEnum::NORMAL
    ];
});
