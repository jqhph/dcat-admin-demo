<?php

use Dcat\Admin\Models\Administrator;
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
        $faker = \Faker\Factory::create();

        $users = [];
        foreach (range(0, 20) as $v) {
            $users[] = [
                'username'   => $faker->userName,
                'password'   => bcrypt('admin'),
                'name'       => $faker->name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        Administrator::insert($users);
    }
}
