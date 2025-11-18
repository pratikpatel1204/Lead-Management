@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create Template Data')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Create Template Data</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Template Data Master</li>
                    <li class="breadcrumb-item active">Create Template Data</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form id="templateForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Template Name <span class="text-danger">*</span></label>

                        <select name="name" id="templateSelect" class="form-control" required>
                            <option value="">-- Select Template --</option>

                            @foreach ($templateNames as $template)
                                <option value="{{ $template->name }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="fieldContainer" class="row"></div>
                <div class="text-end">
                    <a href="{{ route('admin.template.data.list') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn btn-primary">
                        <span class="btn-text">Create Template</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#templateSelect').on('change', function () {
            let name = $(this).val();
            $('#fieldContainer').html(""); // clear area
    
            if (!name) return;
    
            $.ajax({
                url: "{{ route('admin.template.data.get.fields') }}",
                method: "POST",
                data: {
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status && response.fields.length > 0) {

                        let html = '';

                        response.fields.forEach(function (field) {

                            let label = field.field?.name ?? "";
                            let types = field.field?.type ?? "";
                            let defaultValue = field.field?.default_value ?? "";
                            let validations = field.field?.validation ?? "";          // required | min | max …
                            let validationType = field.field?.validation_type ?? "";  // number | string | regex …

                            // Build validation attributes
                            let validationAttrs = "";

                            if (validations) {

                                validations.split('|').forEach(rule => {

                                    let [key, value] = rule.split(':');

                                    switch (key) {
                                        case "required":
                                            validationAttrs += " required ";
                                            break;

                                        case "min":
                                            validationAttrs += ` minlength="${value}" `;
                                            break;

                                        case "max":
                                            validationAttrs += ` maxlength="${value}" `;
                                            break;

                                        case "pattern":
                                            validationAttrs += ` pattern="${value}" `;
                                            break;
                                    }
                                });
                            }

                            // Hidden ID field
                            html += `
                                <input type="hidden" name="label_id[]" value="${field.field.id}">
                            `;

                            // TEXTAREA
                            if (types === "textarea") {
                                html += `
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">${label}</label>
                                        <textarea class="form-control" name="${field.field.id}" placeholder="Enter ${label}" rows="3"
                                            ${validationAttrs}>${defaultValue}</textarea>
                                    </div>
                                `;

                            }

                            // SELECT
                            else if (types === "select") {

                                html += `
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">${label}</label>
                                        <select class="form-control" name="${field.field.id}" ${validationAttrs}>
                                            <option value="">Select ${label}</option>
                                `;

                                if (field.field.dropdowns && field.field.dropdowns.length > 0) {

                                    field.field.dropdowns.forEach(option => {
                                        html += `<option value="${option.value}">${option.label}</option>`;
                                    });

                                } else {

                                    html += `<option value="" disabled>No options available</option>`;
                                }

                                html += `
                                        </select>
                                    </div>
                                `;
                            }

                            // RADIO
                            else if (types === "radio") {

                                html += `
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">${label}</label>
                                        <div class="d-flex gap-3">
                                `;

                                if (field.field.dropdowns && field.field.dropdowns.length > 0) {

                                    field.field.dropdowns.forEach(opt => {

                                        let checked = (opt.value == defaultValue) ? "checked" : "";

                                        html += `
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="${field.field.id}" value="${opt.value}"
                                                    ${checked} ${validationAttrs}>
                                                <label class="form-check-label">${opt.label}</label>
                                            </div>
                                        `;
                                    });

                                } else {
                                    html += `<span class="text-danger">No radio options found</span>`;
                                }

                                html += `</div></div>`;
                            }

                            // CHECKBOX
                            else if (types === "checkbox") {

                                let checked = (defaultValue === "TRUE" || defaultValue === "1") ? "checked" : "";

                                html += `
                                <div class="col-md-6 mb-3">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox"
                                            name="${field.field.id}" value="1"
                                            ${checked} ${validationAttrs}>
                                        <label class="form-check-label">${label}</label>
                                    </div>
                                </div>
                                `;
                            }else if (types === "file") {
                                html += `
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">${label}</label>
                                        <input type="file" class="form-control"
                                            name="${field.field.id}" ${validationAttrs}>
                                    </div>
                                `;
                            }else {

                                html += `
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">${label}</label>
                                        <input type="${types}" class="form-control"
                                            name="${field.field.id}" placeholder="Enter ${label}"
                                            value="${defaultValue}" ${validationAttrs}>
                                    </div>
                                `;
                            }
                        });

                        $("#fieldContainer").html(html);
                    }else {
                        $('#fieldContainer').html(
                            `<div class="col-12 text-muted">No fields found for this template.</div>`
                        );
                    }
                }
            });
        });
    
    });
</script>
<script>
$(document).ready(function() {
    $('#templateForm').on('submit', function(e) {
        e.preventDefault();

        let button = $('#saveBtn');
        let spinner = button.find('.spinner-border');
        let btnText = button.find('.btn-text');

        button.prop('disabled', true);
        spinner.removeClass('d-none');
        btnText.text('Saving...');
        let form = document.getElementById("templateForm");
        let formData = new FormData(form);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('admin.template.data.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false, 
            success: function(response) {
                toastr.clear();

                if (response.status) {
                    toastr.success('Template created successfully!');
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.template.data.list') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error("Something went wrong!");
            },
            complete: function() {
                button.prop('disabled', false);
                spinner.addClass('d-none');
                btnText.text('Create Template');
            }
        });
    });

});
</script>

@endsection
