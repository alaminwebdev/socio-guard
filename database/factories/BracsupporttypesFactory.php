<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Bracsupporttypes;

$factory->define(Bracsupporttypes::class, function (Faker $faker) {
    return [
        'title'=>"Brac support type-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
