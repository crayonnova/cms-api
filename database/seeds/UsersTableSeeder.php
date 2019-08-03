<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Factory::create();
      $users = User::all()->pluck('id')->toArray();
      for ($i=0; $i < 10; $i++) {
        \DB::table('users')->insert([
          'name'      => Str::random(10),
          'email'      => $faker->unique()->safeEmail,
          'email_verified'      => Str::Boolean(),
          'email_verified_at'   => $faker->dateTime(),
          'password'   => bcrypt('secret'),
          'remember_token'   => Str::random(10)

          
        ]);
      }

    }
}
