@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Template')

@section('content')
<div class="content">
    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Edit Template</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Template Master</li>
                    <li class="breadcrumb-item active">Edit Template</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="templateEditForm">
                @csrf
                <input type="hidden" name="name" value="{{ $name }}">

                {{-- Template Name --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Template Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="new_name" value="{{ $name }}">
                </div>

                {{-- Searchable Field Checkbox List --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Select Fields <span class="text-danger">*</span></label>
                    <input type="text" id="fieldSearch" class="form-control mb-2" placeholder="Search field...">

                    <div id="fieldList" class="border rounded p-3 d-flex flex-wrap gap-3"
                        style="max-height: 250px; overflow-y: auto;">
                        @php
                            $selectedIds = $templates->pluck('field_id')->toArray();
                        @endphp

                        @foreach ($fields as $field)
                            <div class="form-check d-flex align-items-center" style="width: 30%;">
                                <input class="form-check-input field-checkbox me-2"
                                    type="checkbox"
                                    name="field_ids[]"
                                    value="{{ $field->id }}"
                                    id="field_{{ $field->id }}"
                                    {{ in_array($field->id, $selectedIds) ? 'checked' : '' }}>
                                <label class="form-check-label" for="field_{{ $field->id }}">
                                    {{ $field->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.template.list') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" id="updateBtn" class="btn btn-primary">
                        <span class="btn-text">Update Template</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    $(document).ready(function() {
        const $fieldList = $('#fieldList');
        const $allFields = $fieldList.children('.form-check').clone();

        // Field search logic
        $('#fieldSearch').on('keyup', function() {
            const value = $(this).val().toLowerCase();

            const matched = [];
            const unmatched = [];

            $allFields.each(function() {
                const text = $(this).text().toLowerCase();
                if (text.includes(value)) {
                    matched.push($(this));
                } else {
                    unmatched.push($(this));
                }
            });

            $fieldList.empty();
            matched.forEach(el => $fieldList.append(el));
            unmatched.forEach(el => $fieldList.append(el));
        });

        // Submit Edit Form
        $('#templateEditForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let button = $('#updateBtn');
            let spinner = button.find('.spinner-border');
            let btnText = button.find('.btn-text');

            button.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('Updating...');

            $.ajax({
                url: "{{ route('admin.template.update') }}",
                method: "POST",
                data: form.serialize(),
                success: function(response) {
                    toastr.clear();
                    if (response.status) {
                        toastr.success(response.message || 'Template updated successfully!');
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.template.list') }}";
                        }, 1500);
                    } else {
                        toastr.error(response.message || 'Something went wrong!');
                    }
                },
                error: function(xhr) {
                    let message = "Something went wrong!";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message);
                },
                complete: function() {
                    button.prop('disabled', false);
                    spinner.addClass('d-none');
                    btnText.text('Update Template');
                }
            });
        });
    });
</script>
@endsection
