<?php

namespace App\Services;

use App\Models\TemplateMaster;

class TemplateMasterService
{
    public function getAllTemplateMaster()
    {
        return TemplateMaster::orderBy('name')->orderBy('field_id')->get()->unique('name')->values();
    }

    public function getTemplateMasterById($id)
    {
        return TemplateMaster::find($id);
    }

    public function getTemplateMasterByField($field)
    {
        return TemplateMaster::where('field_name', $field)->get();
    }
}
