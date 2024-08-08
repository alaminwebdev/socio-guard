<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Judgementstatus;

$factory->define(Judgementstatus::class, function (Faker $faker) {
    return [
        'title'=>"Judgementstatus-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
