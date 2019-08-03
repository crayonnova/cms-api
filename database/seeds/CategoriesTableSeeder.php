<?php

use Illuminate\Database\Seeder;

use Faker\Factory;
use App\Category;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
      for ($i=0; $i < 10; $i++) {
        \DB::table('categories')->insert([
          'user_id'      => randomString(2),
          'email'      => $faker->unique()->safeEmail,
          'email_verified'      => Str::Boolean(),
          'email_verified_at'   => $faker->dateTime(),
          'password'   => bcrypt('secret'),
          'remember_token'   => Str::random(10)
        ]);
      }
        
    }
}
