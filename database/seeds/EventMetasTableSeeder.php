<?php

use App\EventMeta;
use Illuminate\Database\Seeder;

class EventMetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = factory(EventMeta::class, 100)->make();

        foreach ($subjects as $subject) {
            repeat:
            try {
                $subject->save();
            } catch (\Illuminate\Database\QueryException $e) {
                if($e->errorInfo[0]==23000) {
                    $subject = factory(EventMeta::class)->create();

                    goto repeat;
                }
            }
        }
    }
}
