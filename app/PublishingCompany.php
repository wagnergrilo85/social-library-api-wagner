<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublishingCompany extends Model
{
    protected $fillable = [
        'id',
        'name',
        'website',
        'email',
        'address',
        'status',
    ];
}
