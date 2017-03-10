<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function event_user(){
        return $this->hasMany('App\EventUser');
    }

    public function event_meta(){
        return $this->belongsTo('App\EventMeta');
    }

    public function comment(){
        return $this->hasMany('App\Comment');
    }
}
