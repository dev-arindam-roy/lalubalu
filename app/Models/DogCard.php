<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogCard extends Model
{
    use HasFactory;

    protected $table = 'dog_cards';
    protected $primaryKey = 'id';

    public function dogBreed() {
        return $this->belongsTo('App\Models\DogBreed', 'dog_breed_id', 'id');
    }
}
