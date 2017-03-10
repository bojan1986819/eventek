<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMeta extends Model
{
    public function event(){
        return $this->belongsTo('App\Event');
    }
}
