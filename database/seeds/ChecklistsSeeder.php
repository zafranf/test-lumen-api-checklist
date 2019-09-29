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
            $cl = \App\Checklist::create([
                'description' => $faker->sentence(6),
                'object_domain' => $faker->word,
                'object_id' => rand(1, 10),
                'due' => \Carbon\Carbon::now(),
                'urgency' => rand(1, 5),
                'task_id' => rand(1, 100),
            ]);

            $no_item = rand(5, 10);
            for ($i = 1; $i <= $no_item; $i++) {
                $item = \App\ChecklistItem::create([
                    'description' => $faker->sentence(rand(3, 6)),
                    'due' => \Carbon\Carbon::now(),
                    'urgency' => rand(1, 5),
                    'checklist_id' => $cl->id,
                ]);
            }

            $no_template = rand(5, 10);
            for ($i = 1; $i <= $no_template; $i++) {
                $template = \App\Template::create([
                    'name' => $faker->sentence(rand(3, 6)),
                    'checklist_id' => $cl->id,
                ]);
            }
        }
    }
}
