<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Moneyrecover;

$factory->define(Moneyrecover::class, function (Faker $faker) {
    return [
        'title'=>"Courte case moneyrecover-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
