<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadFieldOrder extends Model
{
    protected $table = 'lead_field_orders';

    protected $fillable = [
        'emp_id',
        'template_name',
        'field_name',
        'order_number',
    ];
    public function employee()
    {
        return $this->belongsTo(User::class, 'emp_id');
    }
}
