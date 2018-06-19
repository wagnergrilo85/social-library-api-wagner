<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    protected $table = 'authors';

    protected $fillable = [
        'id',
        'name',
        'nationality',
        'status',
        'created_at',
        'updated_at',
    ];
}
