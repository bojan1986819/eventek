<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comment::class, 200)->create();

        for($i=0;$i<200;$i++){
            if (rand(0, 10) < 5) {
                $primid = null;
            } else {
                $primid = \App\Comment::inRandomOrder()->first()->id;
            }

            Comment::inRandomOrder()->first()->update(['primary_id'=>$primid]);

        }
    }
}
