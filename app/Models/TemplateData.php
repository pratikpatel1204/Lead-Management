<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateData extends Model
{
    protected $table = 'template_data';

    protected $fillable = [
        'form_group_id',
        'template_name',
        'emp_id',
        'field_id',
        'field_name',
        'field_value',
        'created_at',
        'updated_at',
    ];
    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
    public function scopeEmpScope($query, $alias = null)
    {
        if (!auth()->check()) {
            return $query;
        }

        if (!in_array(auth()->user()->role, ['admin', 'super admin'])) {
            $column = $alias ? "{$alias}.emp_id" : "{$this->getTable()}.emp_id";
            $query->where($column, auth()->id());
        }

        return $query;
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'emp_id');
    }
}
