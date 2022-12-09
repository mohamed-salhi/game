<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $timestamps=false;
    public function true_false(){
        return $this->hasMany(TrueFalse::class);
    }
    public function choosee(){
        return $this->hasMany(chooes::class);
    }
}
