<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    use HasFactory;

    protected $table = 'why_choose_us'; // explicitly set table name (optional)

    protected $fillable = [
        'title',
        'short_description',
        'image',
        'list_one',
        'list_two',
        'list_three',
        'list_four',
    ];
}
