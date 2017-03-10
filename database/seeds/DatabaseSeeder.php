<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(EventMetasTableSeeder::class);
        $this->call(EventUsersTableSeeder::class);
        $this->call(UserMetasTableSeeder::class);
    }
}
