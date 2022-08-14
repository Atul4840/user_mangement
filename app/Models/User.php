<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
          'email',
          'name',
          'date_of_join',
          'date_of_leaving',
          'image',
    ];

}
