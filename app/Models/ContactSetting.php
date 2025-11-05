<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'map_link',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
    ];
}
