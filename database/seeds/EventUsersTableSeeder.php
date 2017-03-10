<?php

use App\EventUser;
use Illuminate\Database\Seeder;

class EventUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = factory(EventUser::class, 300)->make();

        foreach ($subjects as $subject) {
            repeat:
            try {
                $subject->save();
            } catch (\Illuminate\Database\QueryException $e) {
                if($e->errorInfo[0]==23000) {
                    $subject = factory(EventUser::class)->create();

                    goto repeat;
                }
            }
        }
    }
}
