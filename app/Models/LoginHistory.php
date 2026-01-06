<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'country',
        'city',
        'device',
        'browser',
        'os',
        'logged_in_at',
        'logged_out_at',
    ];

    protected $dates = [
        'logged_in_at',
        'logged_out_at',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
