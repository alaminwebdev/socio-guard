<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model\Bracprogramname;

$factory->define(Bracprogramname::class, function (Faker $faker) {
    return [
        'title'=>"Brac program name-".$faker->name,
        'status'=>$faker->randomElement([0,1])
    ];
});
