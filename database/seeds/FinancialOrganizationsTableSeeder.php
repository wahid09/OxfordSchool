<?php

use Illuminate\Database\Seeder;
//use DB;

class FinancialOrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('financial_organizations')->insert([

                [
                    'name' => 'Sonali Bank',
                ],
                [
                    'name' => 'AB Bank',
                ],

                [
                    'name' => 'Agrani Bank',
                 ],
                 [
                 	'name' => 'Bangladesh Commerce Bank',
                 ],
                 [
                 	'name' => 'Bangladesh Development Bank',
                 ],
                 [
                 	'name' => 'Bank Asia',
                 ],
                 [
                 	'name' => 'BRAC Bank',
                 ],


            ]);
    }
}
