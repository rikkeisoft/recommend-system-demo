<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relationship with Book model
     * 
     * @return type
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

}
