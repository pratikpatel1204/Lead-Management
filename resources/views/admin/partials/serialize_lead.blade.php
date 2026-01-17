@php
$savedFields = !empty($fieldsorder) ? array_unique($fieldsorder) : [];
$allFields = $tablefield->pluck('field.name')->toArray();
$remainingFields = array_diff($allFields, $savedFields);
@endphp
<input type="hidden" name="emp_id" id="emp_id" value="{{$emp->id}}">
<ul id="sortableFields" class="list-group mb-3">
    @foreach ($savedFields as $fieldName)
    <li class="list-group-item d-flex align-items-center justify-content-between" data-key="{{ $fieldName }}">
        <div class="d-flex align-items-center gap-2">
            <i class="ti ti-menu-2 text-muted drag-handle"></i>
            <input type="checkbox" class="field-checkbox" value="{{ $fieldName }}" checked>
            <span>{{ $fieldName }}</span>
        </div>
    </li>
    @endforeach
    @foreach ($remainingFields as $fieldName)
    <li class="list-group-item d-flex align-items-center justify-content-between" data-key="{{ $fieldName }}">
        <div class="d-flex align-items-center gap-2">
            <i class="ti ti-menu-2 text-muted drag-handle"></i>
            <input type="checkbox" class="field-checkbox" value="{{ $fieldName }}">
            <span>{{ $fieldName }}</span>
        </div>
    </li>
    @endforeach
</ul>