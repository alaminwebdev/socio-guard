<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\SelpComingOrFailour;

$factory->define(SelpComingOrFailour::class, function (Faker $faker) {
    return [
        'title'=>"Failour or coming to selp-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
