<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soulionlevel extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $timestamps=false;

    public function levell(){
        return $this->hasOne(Level::class);
    }

}
