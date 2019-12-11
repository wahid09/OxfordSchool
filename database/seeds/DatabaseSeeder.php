<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\Models\FinancialOrganization::class, 10)->create();
        factory(App\Models\BankAccount::class, 50)->create();
    }
}
