@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create ' . $name . ' Data')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create {{ $name }} Data</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active">Create {{ $name }} Data</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create {{ $name }} Data</h5>
                    </div>
                    <div class="card-body">
                        <form id="createtemplatedata" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="template_name" value="{{ $name }}">
                            <div class="row my-2">

                                @foreach ($templates as $item)
                                    @php
                                        $field = $item->field;
                                        $label = $field->name ?? '';
                                        $type = $field->type ?? 'text';
                                        $defaultValue = $field->default_value;
                                        $validation = $field->validation;
                                        $validationType = $field->validation_type;
                                        $isRequired = str_contains($validation, 'required');
                                    @endphp
                                    <input type="hidden" name="label_id[]" value="{{ $item->field_id }}">
                                    @if ($type === 'textarea')
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                {{ $label }} @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <textarea name="{{ $item->field_id }}" class="form-control" rows="3" {{ $isRequired ? 'required' : '' }}>{{ $defaultValue }}</textarea>
                                        </div>
                                    @elseif ($type === 'radio')
                                        @php
                                            $options = is_array($field->options)
                                                ? $field->options
                                                : explode(',', $field->options);
                                        @endphp
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                {{ $label }} @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>

                                            <div class="d-flex flex-wrap mt-2">
                                                @foreach ($options as $opt)
                                                    @php $opt = trim($opt); @endphp
                                                    <label class="me-3">
                                                        <input type="radio" name="{{ $item->field_id }}"
                                                            value="{{ $opt }}"
                                                            {{ $defaultValue == $opt ? 'checked' : '' }}
                                                            {{ $isRequired ? 'required' : '' }}>
                                                        {{ $opt }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($type === 'checkbox')
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                <input type="checkbox" name="{{ $item->field_id }}" value="1"
                                                    {{ $defaultValue == 1 ? 'checked' : '' }}
                                                    {{ $isRequired ? 'required' : '' }}>
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @elseif ($type === 'select')
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                {{ $label }} @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <select class="form-select" name="{{ $item->field_id }}"
                                                {{ $isRequired ? 'required' : '' }}>
                                                @foreach ($field->dropdowns as $opt)
                                                    <option value="{{ $opt->value }}"
                                                        {{ $defaultValue == $opt->value ? 'selected' : '' }}>
                                                        {{ $opt->label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @elseif ($type === 'file')
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                {{ $label }} @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="file" name="{{ $item->field_id }}" class="form-control"
                                                {{ $isRequired ? 'required' : '' }} {!! $validationType !!}>
                                        </div>
                                    @else
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                {{ $label }} @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="{{ $type }}" name="{{ $item->field_id }}"
                                                value="{{ $defaultValue }}" class="form-control"
                                                {{ $isRequired ? 'required' : '' }} {!! $validationType !!}>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-success my-3">
                                <span id="btnText">Save</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        $("#createtemplatedata").on("submit", function(e) {
            e.preventDefault();

            $("#submitBtn").prop("disabled", true);
            $("#btnText").addClass("d-none");
            $("#btnLoader").removeClass("d-none");

            let formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.data.store', $name) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {
                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: "Template data created successfully",
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        window.location.href = "{{ route('admin.data.list', $name) }}";
                    }, 1500);
                },

                error: function(xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Please try again."
                    });
                },

                complete: function() {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").removeClass("d-none");
                    $("#btnLoader").addClass("d-none");
                }
            });
        });
    </script>

@endsection
