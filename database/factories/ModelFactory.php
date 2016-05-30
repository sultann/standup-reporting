<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Report::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 10),
        'task_done' => $faker->text(500),
        'blocker' => $faker->text(250),
        'blocker_status' => $faker->numberBetween(0,1),
        'can_update' => $faker->numberBetween(0,1),
        'created_at'    => $faker->dateTimeBetween('-3 days', 'now')
    ];
});