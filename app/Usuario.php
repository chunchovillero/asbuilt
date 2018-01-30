<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
	 protected $table = 'User';
     protected $primaryKey = 'user_id';
     public $timestamps = false;
     protected $fillable = ['nombre', 'apellido', 'email'];
}

