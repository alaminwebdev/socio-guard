<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Adrmoneyrecover;

$factory->define(Adrmoneyrecover::class, function (Faker $faker) {
    return [
        'title'=>"ADR Money recover-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
