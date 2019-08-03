<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->id,
        'name' => $faker->name,
        'slug' => Str::random(32),
        'description' => Str::random(100), // password
        
    ];
});
