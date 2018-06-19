<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'id',
        'title',
        'subject',
        'description',
        'pages',
        'isbn',
        'barcode',
        'edition',
        'status',
        'releaseDate',
        'author_id',
        'category_id',
    ];

    // FK
    public function author(){
        return $this->hasOne('\App\Author');
    }

    // FK
    public function category(){
        return $this->hasOne('\App\Category');
    }

}
