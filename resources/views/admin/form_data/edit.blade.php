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
                        <form id="updatetemplatedata" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="template_name" class="form-control" value="{{ $templateName }}"
                                readonly>
                            <input type="hidden" name="group_id" class="form-control" value="{{ $groupId }}" readonly>
                            <div class="row p-2 my-2">
                                @foreach ($records as $item)
                                    @php
                                        $field = $item->field;
                                        $label = $field->name ?? '';
                                        $type = $field->type ?? 'text';
                                        $value = $item->field_value;
                                        $validation = $field->validation;
                                        $validationType = $field->validation_type;
                                        $isRequired = str_contains($validation, 'required');
                                    @endphp
                                    @if ($type === 'textarea')
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                {{ $label }} @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <textarea name="{{ $item->field_id }}" class="form-control" rows="3" {{ $isRequired ? 'required' : '' }}>{{ $value }}</textarea>
                                        </div>
                                    @elseif ($type === 'radio')
                                        @php
                                            $options = is_array($field->options) ? $field->options : explode(',', $field->options);
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"> {{ $label }} 
                                                @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <div class="d-flex flex-wrap mt-2">
                                                @foreach ($options as $opt)
                                                    @php $opt = trim($opt); @endphp
                                                    <label class="me-3">
                                                        <input type="radio" name="{{ $item->field_id }}"
                                                            value="{{ $opt }}"
                                                            {{ $value == $opt ? 'checked' : '' }}
                                                            {{ $isRequired ? 'required' : '' }}>
                                                        {{ $opt }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($type === 'checkbox')
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                <input type="checkbox" name="{{ $item->field_id }}" value="1"
                                                    {{ $value == 1 ? 'checked' : '' }}
                                                    {{ $isRequired ? 'required' : '' }}>
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @elseif ($type === 'select')
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ $label }} 
                                                @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <select class="form-select" name="{{ $item->field_id }}"
                                                {{ $isRequired ? 'required' : '' }}>
                                                @foreach ($field->dropdowns as $opt)
                                                    <option value="{{ $opt->value }}"
                                                        {{ $value == $opt->value ? 'selected' : '' }}>
                                                        {{ $opt->label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>       
                                    @elseif ($type === 'file')
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"> {{ $label }} 
                                                @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="file" name="{{ $item->field_id }}" class="form-control" {{ $isRequired ? 'required' : '' }} {!! $validationType !!}>
                                        </div>                                                                                             
                                    @else
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"> {{ $label }} 
                                                @if ($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="{{ $type }}" name="{{ $item->field_id }}" value="{{ $value }}" class="form-control"
                                                {{ $isRequired ? 'required' : '' }} {!! $validationType !!}>
                                        </div>
                                    @endif                                       
                                @endforeach
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-success my-3">
                                <span id="btnText">Save Changes</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.remove-row', function() {
            $(this).closest('.row').remove();
        });
        $("#updatetemplatedata").on("submit", function(e) {
            e.preventDefault();

            // SHOW LOADER + DISABLE BUTTON
            $("#submitBtn").prop("disabled", true);
            $("#btnText").addClass("d-none");
            $("#btnLoader").removeClass("d-none");

            let form = document.getElementById("updatetemplatedata");
            let formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.data.update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {
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

                    setTimeout(function() {
                        window.location.href = "{{ route('admin.data.list', $templateName) }}";
                    }, 1500);
                },

                error: function(xhr) {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").removeClass("d-none");
                    $("#btnLoader").addClass("d-none");

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Something went wrong. Please try again."
                    });

                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
