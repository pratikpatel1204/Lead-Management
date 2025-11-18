<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'validation',
        'validation_type',
        'default_value',
    ];
    public function templateData()
    {
        return $this->hasMany(TemplateData::class, 'field_id');
    }
    public function dropdowns()
    {
        return $this->hasMany(Dropdown::class);
    }
}
