<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Userproject;
use App\Usuario;
class Proyecto extends Model
{
     protected $table = 'Project';
     protected $primaryKey = 'pro_id';

     public function usuarios(){
       return $this->belongsToMany(Usuario::class, 'User_project', 'proj_id', 'user_id')->withPivot('user_act');
     }

      public $timestamps = false;
}
