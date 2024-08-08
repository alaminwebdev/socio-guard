<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Pititioncase;

$factory->define(Pititioncase::class, function (Faker $faker) {
    return [
        'title'=>"Pititioncase-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
