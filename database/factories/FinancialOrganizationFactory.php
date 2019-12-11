<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FinancialOrganization;
use Faker\Generator as Faker;

$factory->define(FinancialOrganization::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'address' => $faker->address,
    ];
});
