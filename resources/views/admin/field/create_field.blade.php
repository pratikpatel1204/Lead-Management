@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create Field')

@section('content')
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Field</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Fields</li>
                        <li class="breadcrumb-item active">Create Field</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form id="fieldForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Field Name"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Type <span class="text-danger">*</span></label>
                            <select name="type" id="fieldType" class="form-select" required>
                                <option value="">Select Type</option>
                                @foreach ($fieldTypes as $type)
                                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Validation <span class="text-danger">*</span></label>
                            <select name="validation" class="form-select" required>
                                <option value="">Select Validation</option>
                                <option value="required">Required</option>
                                <option value="nullable">Nullable</option>
                                <option value="readonly">Readonly</option>
                                <option value="checked">Checked</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Validation Type</label>
                            <select name="validation_type" id="validationType" class="form-select">
                                <option value="">Select Validation Type</option>
                                @foreach ($validationTypes as $validation)
                                    <option value="{{ $validation->rule }}">{{ $validation->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Default Value</label>
                            <input type="text" name="default_value" class="form-control"
                                placeholder="Enter Default Value">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Options</label>
                            <input type="text" name="options" class="form-control" placeholder="Male,Female">
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.field.list') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <span class="btn-text">Create Field</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#fieldForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let button = $('#saveBtn');
                let spinner = button.find('.spinner-border');
                let btnText = button.find('.btn-text');

                button.prop('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('Saving...');

                $.ajax({
                    url: "{{ route('admin.field.store') }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Field created successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        form[0].reset();
                    },
                    error: function(xhr) {
                        let message = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message
                        });
                    },
                    complete: function() {
                        button.prop('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('Create Field');
                    }
                });
            });

        });
    </script>

@endsection
