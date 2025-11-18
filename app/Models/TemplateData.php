<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateData extends Model
{
    protected $table = 'template_data';

    protected $fillable = [
        'form_group_id',
        'template_name',
        'field_id',
        'field_name',
        'field_value',
    ];
    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
}
