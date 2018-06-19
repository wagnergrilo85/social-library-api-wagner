<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected  $fillable = [
        'id',
        'name',
        'fathers_name',
        'mothers_name',
        'cellphone',
        'numberHouse',
        'address',
        'complement',
        'neighborhood',
        'city',
        'internal_code',
        'registry',
        'birthday',
        'status',
    ];

}
