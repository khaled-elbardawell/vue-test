<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detailed extends Model
{
    protected $fillable = ['ar','en','master_id','id'];

    public function master(){
        return  $this->belongsTo(Master::class,"master_id");
    }
}
