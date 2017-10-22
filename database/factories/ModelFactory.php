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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'avatar' => function() use($faker) {
            $url = $faker->imageUrl(300, 300);
            $image = file_get_contents($url);
            return "data:image/jpg;base64,".base64_encode($image);
        },
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'preview' => function() use($faker) {
            $url = $faker->imageUrl();
            $image = file_get_contents($url);
            return "data:image/jpg;base64,".base64_encode($image);
        },
        'title' => $faker->sentence(6),
        'text' => $faker->text(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Collection::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(10),
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
    ];
});
