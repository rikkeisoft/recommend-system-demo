<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'author', 'cover', 'category_id',
        'price', 'description', 'publish_date', 'views',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Relationship with Rate model
     * 
     * @return type
     */
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

}
