<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Selpzone;

$factory->define(Selpzone::class, function (Faker $faker) {
    return [
        'title'=>"Selpzone-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
