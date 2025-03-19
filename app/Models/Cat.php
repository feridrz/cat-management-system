<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'gender', 'age', 'mother_id'
    ];

    // Relationship: a cat may have a mother (another cat)
    public function mother()
    {
        return $this->belongsTo(Cat::class, 'mother_id');
    }

    // A cat can have many children (if it’s the mother)
    public function children()
    {
        return $this->hasMany(Cat::class, 'mother_id');
    }

    // Many-to-many relationship for fathers of this cat
    public function fathers()
    {
        return $this->belongsToMany(Cat::class, 'cat_father', 'cat_id', 'father_id');
    }

    // Inverse relationship: a cat can be a father to many cats
    public function fatheredCats()
    {
        return $this->belongsToMany(Cat::class, 'cat_father', 'father_id', 'cat_id');
    }
}
