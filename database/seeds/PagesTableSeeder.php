<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Factory::create();
      $pages = Page::all()->pluck('id')->toArray();
      for ($i=0; $i < 100; $i++) {
        \DB::table('users')->insert([
          'name'      => $faker->uuid,
          'email'     => $faker->randomElement($pages)
        ]);
      }

    }
}
