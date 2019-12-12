<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BankAccount;
use App\Models\FinancialOrganization;
use Faker\Generator as Faker;

$factory->define(BankAccount::class, function (Faker $faker) {
	$organizationId = FinancialOrganization::pluck('id')->toArray();
    return [
        'financialorganization_id' => $faker->randomElement($organizationId),
        'account_name' => $faker->name,
        'account_no'   => $faker->creditCardNumber,
        'branch'       => $faker->word,
        'swift_code'   => $faker->numberBetween(100, 1000),
        'route_no'     => $faker->numberBetween(1, 100),
     ];
});
