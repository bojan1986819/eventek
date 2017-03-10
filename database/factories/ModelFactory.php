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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    $starthour = rand(1,12);
    $endhour = rand(13,23);
    $minsec = rand(1,59);

    return[ //,
        'name' => $faker->name,
        'date' => $faker->dateTimeBetween($startDate = "now", $endDate = "30 days")->format('Y-m-d'),
        'start_time' => $faker->time($starthour.':'.$minsec.':'.$minsec),
        'end_time' => $faker->time($endhour.':'.$minsec.':'.$minsec),
        'location' => $faker->address,
        'description' => $faker->text(250),
        'user_id' => $faker->numberBetween(1,33)
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    repeat:
    $commnr = \App\Comment::count();
    if($commnr < 1) {
        $primid = null;
    } else {
        if (rand(0, 10) < 5) {
            $primid = null;
        } else {
            $primid = \App\Comment::inRandomOrder()->first()->id;
        }
    }

    return[ //,
        'primary_id' => $primid,
        'comment' => $faker->text(200),
        'event_id' => \App\Event::inRandomOrder()->first()->id,
        'user_id' => \App\User::inRandomOrder()->first()->id,
    ];
    goto repeat;

});

$factory->define(App\EventUser::class, function (Faker\Generator $faker) {
    repeat:
    $event_id = \App\Event::inRandomOrder()->first()->id;
    $user_id = \App\User::inRandomOrder()->first()->id;
    if (rand(0, 10) < 5) {
        $role = "subscriber";
    } else {
        $role = "owner";
    }
    if(!App\EventUser::where([['user_id','=', $user_id],['event_id','=',$event_id]])->exists()) {
        return [ //,
            'role' => $role,
            'event_id' => \App\Event::inRandomOrder()->first()->id,
            'user_id' => \App\User::inRandomOrder()->first()->id,
        ];
    } else {
        goto repeat;
    }
});

$factory->define(App\EventMeta::class, function (Faker\Generator $faker){
    repeat:
    $event_id = \App\Event::inRandomOrder()->first()->id;

    if (rand(0, 10) < 5) {
        $key = "type";
        $value = $faker->text(15);
    } else {
        $key = "participants";
        $value = rand(3,25);
    }

    if(!App\EventMeta::where([['event_id','=', $event_id],['key','=',$key]])->exists()){
        return[ //,
            'event_id' => $event_id,
            'key' => $key,
            'value' => $value,
        ];
    } else {
        goto repeat;
    }

});

$factory->define(App\UserMeta::class, function (Faker\Generator $faker){
//    $i = 0;
//    while($i < 200){
//        $data = createUserMeta($faker);
//        $i++;
//        if($data != false){
//            return $data;
//        }
//    }
    repeat:
    $user_id = \App\User::inRandomOrder()->first()->id;

    if (rand(0, 10) < 5) {
        $key = "address";
        $value = $faker->address;
    } else {
        $key = "age";
        $value = rand(16,87);
    }

    if(!App\UserMeta::where([['user_id','=', $user_id],['key','=',$key]])->exists()){
        return[ //,
            'user_id' => $user_id,
            'key' => $key,
            'value' => $value,
        ];
    } else {
        goto repeat;
    }

});

function createUserMeta($faker){
    $user_id = \App\User::inRandomOrder()->first()->id;
    if (rand(0, 10) < 5) {
        $key = "address";
        $value = $faker->address;
    } else {
        $key = "age";
        $value = rand(16,87);
    }


    if(!App\UserMeta::where([ ['user_id','=', $user_id], ['key', '=', $key] ])->exists()){
        return[ //,
            'key' => $key,
            'value' => $value,
            'user_id' => $user_id,
        ];
    }
    else return false;
}
