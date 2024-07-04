<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'budget', 'datedeb', 'datefin', 'image_path', 'rapport'];

    public function partenaires()
    {
        return $this->hasMany(User::class);
    }
};
