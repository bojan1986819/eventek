<?php

use App\User;
use App\UserMeta;
use Illuminate\Database\Seeder;

class UserMetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = factory(UserMeta::class, 100)->make();

        foreach ($subjects as $subject) {
            repeat:
            try {
                $subject->save();
            } catch (\Illuminate\Database\QueryException $e) {
                if($e->errorInfo[0]==23000) {
                    $subject = factory(UserMeta::class)->create();

                    goto repeat;
                }
            }
        }
    }
}
