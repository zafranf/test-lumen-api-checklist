<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class ChecklistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $no = rand(5, 10);
        for ($i = 1; $i <= $no; $i++) {
            $checklist = new \App\Checklist();

        }
    }
}
