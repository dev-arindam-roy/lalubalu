<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogVaccination extends Model
{
    use HasFactory;

    protected $table = 'dog_vaccination';
    protected $primaryKey = 'id';
}
