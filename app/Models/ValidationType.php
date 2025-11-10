<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidationType extends Model
{
    use HasFactory;

    protected $table = 'validations_type';

    protected $fillable = [
        'name',
        'rule',
    ];
}
