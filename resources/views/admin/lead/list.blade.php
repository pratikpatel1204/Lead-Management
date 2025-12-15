@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Lead Master')
@section('content')
    <style>
        .offcanvas.offcanvas-end {
            width: 70% !important;
        }
    </style>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Lead Master</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Lead Master</li>
                        <li class="breadcrumb-item active" aria-current="page">Lead List</li>
                    </ol>
                </nav>
            </div>
            <a href="javascript:void(0)" class="btn btn-primary mt-2 mt-md-0" id="openLeadForm">
                <i class="ti ti-plus"></i>
                <span>Lead Master</span>
            </a>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Lead Master</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="datalistTable">
                            <thead>
                                <tr class="bg-light">
                                    <th>#</th>
                                    @if (isset($leadData) && count($leadData) > 0)
                                        @php
                                            $firstGroup = $leadData->first();
                                        @endphp
                                        @foreach ($firstGroup as $item)
                                            <th>{{ $item->field_name }}</th>
                                        @endforeach
                                    @endif
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $row = 1; @endphp
                                @foreach ($leadData as $groupId => $records)
                                    <tr>
                                        <td>{{ $row++ }}</td>
                                        @foreach ($records as $rec)
                                            <td>
                                                @if (Str::endsWith($rec->field_value, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                    <img src="{{ asset($rec->field_value) }}" width="50">
                                                @elseif (Str::endsWith($rec->field_value, 'pdf'))
                                                    <a href="{{ asset($rec->field_value) }}" target="_blank"
                                                        class="btn btn-sm btn-danger">View PDF</a>
                                                @else
                                                    {{ $rec->field_value ?? '-' }}
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="text-center">
                                            <a href="{{ route('admin.lead.mater.edit', $groupId) }}" class="btn btn-info btn-sm text-white me-1">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm deleteDataBtn" data-group="{{$groupId}}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="leadSidebarForm" class="offcanvas offcanvas-end lead-sidebar" tabindex="-1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Lead Master</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="dynamicForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    @foreach ($templates as $t)
                        @php
                            $field = $t->field;
                            $label = $field->name;
                            $name = Str::slug($field->name, '_'); // slug input name
                            $type = $field->type;
                            $isRequired = $field->validation == 'required' ? 'required' : '';
                            $defaultValue = $field->default_value;
                        @endphp
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ $label }} @if ($isRequired)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            {{-- Text / Email / Number --}}
                            @if (in_array($type, ['text', 'email', 'number']))
                                <input type="{{ $type }}" name="{{ $field->id }}" class="form-control"
                                    id="{{ $name }}" {{ $isRequired }}>

                                {{-- Textarea --}}
                            @elseif ($type == 'textarea')
                                <textarea name="{{ $field->id }}" class="form-control" id="{{ $name }}" rows="3"
                                    {{ $isRequired }}></textarea>

                                {{-- Select --}}
                            @elseif ($type == 'select')
                                <select name="{{ $field->id }}" id="{{ $name }}" class="form-select"
                                    {{ $isRequired }}>
                                    <option value="">Select {{ $label }}</option>
                                    @foreach ($field->dropdowns as $opt)
                                        <option value="{{ $opt->value }}">{{ $opt->label }}</option>
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
                                            <input type="radio" name="{{ $field->id }}" id="{{ $name . '_' . $opt }}"
                                                value="{{ $opt }}" {{ $defaultValue == $opt ? 'checked' : '' }}
                                                {{ $isRequired ? 'required' : '' }}>
                                            {{ $opt }}
                                        </label>
                                    @endforeach
                                </div>
                                {{-- File --}}
                            @elseif ($type == 'file')
                                <input type="file" name="{{ $field->id }}" id="{{ $name }}"
                                    class="form-control" {{ $isRequired }}>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <span class="btn-text">Save</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('openLeadForm').addEventListener('click', function() {
            let sidebar = new bootstrap.Offcanvas(document.getElementById('leadSidebarForm'));
            sidebar.show();
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#dynamicForm").on("submit", function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Define submit button
                let btn = $("#saveBtn");

                // Clear previous errors
                $(form).find('.text-danger').remove();
                $(form).find('.is-invalid').removeClass('is-invalid');

                // Button Loader
                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".spinner-border").removeClass("d-none");

                $.ajax({
                    url: "{{ route('admin.lead.mater.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");

                        if (res.status === true) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: res.message,
                            });
                            form.reset();
                        }
                    },
                    error: function(err) {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");

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
                    },

                    complete: function() {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let table = $('#datalistTable').DataTable();
            $(document).on('click', '.deleteDataBtn', function() {

                let groupId = $(this).data('group');        
                let row = $(this).closest('tr');
                Swal.fire({
                    title: "Are you sure?",
                    text: "This form group will be deleted permanently!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('admin.lead.mater.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                group_id: groupId,
                            },

                            success: function(res) {
                                if (res.status) {
                                    Swal.fire("Deleted", res.message, "success");
                                    row.remove();
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },

                            error: function() {
                                Swal.fire("Error", "Something went wrong!", "error");
                            }
                        });

                    }
                });

            });
        });
    </script>

@endsection
