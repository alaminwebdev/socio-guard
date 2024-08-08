<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Followup;

$factory->define(Followup::class, function (Faker $faker) {
    return [
        'title'=>"Followup-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
