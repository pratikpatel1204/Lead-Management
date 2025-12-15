@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit ' . $templateName . ' Data')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit {{ $templateName }} Data</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active">Edit {{ $templateName }} Data</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit {{ $templateName }} Data</h5>
                    </div>
                    <div class="card-body">
                        <form id="editdaynamicform" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="form_group_id" value="{{ $formGroupId }}">
                            <div class="row">
                                @foreach ($leadData as $t)
                                    @php
                                        $field = $t->field;
                                        $label = $field->name;
                                        $name = $field->id;
                                        $slug = Str::slug($field->name, '_');
                                        $type = $field->type;
                                        $isRequired = $field->validation == 'required';
                                        $value = old($name, $t->field_value);
                                    @endphp
                                    <div class="col-4 mb-3">
                                        <label class="form-label">{{ $label }}@if ($isRequired)<span class="text-danger">*</span>@endif</label>
                                        {{-- Text / Email / Number --}}
                                        @if (in_array($type, ['text', 'email', 'number']))
                                            <input type="{{ $type }}" name="{{ $name }}"
                                                id="{{ $slug }}" class="form-control" value="{{ $value }}"
                                                {{ $isRequired ? 'required' : '' }}>

                                            {{-- Textarea --}}
                                        @elseif ($type == 'textarea')
                                            <textarea name="{{ $name }}" id="{{ $slug }}" class="form-control" rows="3"
                                                {{ $isRequired ? 'required' : '' }}>{{ $value }}</textarea>

                                            {{-- Select --}}
                                        @elseif ($type == 'select')
                                            <select name="{{ $name }}" id="{{ $slug }}"
                                                class="form-select" {{ $isRequired ? 'required' : '' }}>
                                                <option value="">Select {{ $label }}</option>
                                                @foreach ($field->dropdowns as $opt)
                                                    <option value="{{ $opt->value }}"
                                                        {{ $value == $opt->value ? 'selected' : '' }}>
                                                        {{ $opt->label }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            {{-- Radio --}}
                                        @elseif ($type == 'radio')
                                            @php
                                                $options = is_array($field->options)
                                                    ? $field->options
                                                    : explode(',', $field->options);
                                            @endphp
                                            <div class="d-flex flex-wrap mt-2">
                                                @foreach ($options as $opt)
                                                    @php $opt = trim($opt); @endphp
                                                    <label class="me-3">
                                                        <input type="radio" name="{{ $name }}"
                                                            value="{{ $opt }}"
                                                            {{ $value == $opt ? 'checked' : '' }}
                                                            {{ $isRequired ? 'required' : '' }}>
                                                        {{ $opt }}
                                                    </label>
                                                @endforeach
                                            </div>

                                            {{-- File --}}
                                        @elseif ($type == 'file')
                                            <input type="file" name="{{ $name }}" id="{{ $slug }}"
                                                class="form-control" {{ $isRequired ? 'required' : '' }}>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="saveBtn">
                                    <span class="btn-text">Update</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
        
            $("#editdaynamicform").on("submit", function (e) {
                e.preventDefault();
        
                // Loader ON
                $("#submitBtn").prop("disabled", true);
                $("#btnText").addClass("d-none");
                $("#btnLoader").removeClass("d-none");
        
                let formData = new FormData(this);
        
                $.ajax({
                    url: "{{ route('admin.lead.mater.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
        
                    success: function (response) {
                        $("#submitBtn").prop("disabled", false);
                        $("#btnText").removeClass("d-none");
                        $("#btnLoader").addClass("d-none");
        
                        Swal.fire({
                            icon: "success",
                            title: "Updated!",
                            text: "Template Data updated successfully!",
                            timer: 1500,
                            showConfirmButton: false
                        });
        
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.lead.mater') }}";
                        }, 1500);
                    },
                    error: function(err) {
                        $("#submitBtn").prop("disabled", false);
                        $("#btnText").removeClass("d-none");
                        $("#btnLoader").addClass("d-none");

                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;

                            $.each(errors, function(key, messages) {
                                let input = $('#' + key);

                                input.next('.text-danger').remove();
                                input.after('<span class="text-danger small">' +
                                    messages[0] + '</span>');
                                input.addClass('is-invalid');
                            });

                            // Scroll to first error field
                            let firstKey = Object.keys(errors)[0];
                            let firstInput = $('#' + firstKey);

                            if (firstInput.length) {
                                $('html, body').animate({
                                    scrollTop: firstInput.offset().top - 100
                                }, 400);
                            }

                            return;
                        }

                        Swal.fire("Error", "Something went wrong!", "error");
                    }                   
                });
            });
        
        });
    </script>    
@endsection
