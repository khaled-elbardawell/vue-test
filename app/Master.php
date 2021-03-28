<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    public function detailes(){
        return $this->hasMany(Master::class,"master_id");
    }
}
