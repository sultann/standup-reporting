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
//$factory->define(App\User::class, function (Faker\Generator $faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->safeEmail,
//        'password' => bcrypt('123456'),
//        'remember_token' => str_random(10),
//    ];
//});


$factory->define(App\Report::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 80),
        'task_done' => $faker->text(500),
        'created_at'    => $faker->unique()->dateTimeBetween('-5 days', 'now')
    ];
});

$factory->define(App\Blocker::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 80),
        'blocker' => $faker->text(250),
        'status' => $faker->numberBetween(0,1)
    ];
});



