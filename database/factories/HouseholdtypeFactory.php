<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Householdtype;

$factory->define(Householdtype::class, function (Faker $faker) {
    return [
        'title'=>"Household type-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
