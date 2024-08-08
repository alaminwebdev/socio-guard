<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Civilcase;

$factory->define(Civilcase::class, function (Faker $faker) {
    return [
        'title'=>'Civilcase-'.$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
