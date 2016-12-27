<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'book_id', 'point',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Relationship with Book model
     * 
     * @return type
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
