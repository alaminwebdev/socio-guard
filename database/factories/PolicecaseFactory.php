<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Policecase;

$factory->define(Policecase::class, function (Faker $faker) {
    return [
        'title'=>'Policecase-'.$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
