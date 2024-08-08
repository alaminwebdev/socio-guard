<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Survivorinitiative;

$factory->define(Survivorinitiative::class, function (Faker $faker) {
    return [
        'title'=>"Survivor initiative-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
