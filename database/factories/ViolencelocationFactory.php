<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\ViolenceLocation;

$factory->define(ViolenceLocation::class, function (Faker $faker) {
    return [
        'title'=>"Violence location-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
