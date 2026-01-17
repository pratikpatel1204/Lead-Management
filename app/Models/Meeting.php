<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'meetings';

    protected $fillable = [
        'form_group_id',
        'meeting_group',
        'emp_id',
        'field_id',
        'label',
        'value',
        'created_at',
        'updated_at',
    ];

    public function formGroup()
    {
        return $this->belongsTo(TemplateData::class, 'form_group_id');
    }
    
    public function scopeEmpScope($query)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super admin'])) {
            $query->where('emp_id', auth()->id());
        }
    } 
    public function lead()
    {
        return $this->hasOne(TemplateData::class, 'form_group_id', 'form_group_id')
            ->where('template_name', 'Lead Master');
    }
}
