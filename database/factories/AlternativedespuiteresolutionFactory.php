<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\AlternativeDisputeResolution;

$factory->define(AlternativeDisputeResolution::class, function (Faker $faker) {
    return [
        'title'=>"Alternative Dispute Resolution-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
