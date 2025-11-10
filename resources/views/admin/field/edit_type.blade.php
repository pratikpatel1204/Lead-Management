@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Field Type')

@section('content')
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Field Type</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Field Type</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form id="editFieldTypeForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="id" value="{{ $fieldType->id }}">
                        <!-- Field Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ $fieldType->name }}" placeholder="Enter Field Name" required>
                            <span class="text-danger error-name"></span>
                        </div>

                        <!-- Field Value -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Value <span class="text-danger">*</span></label>
                            <input type="text" name="value" class="form-control" 
                                   value="{{ $fieldType->value }}" placeholder="Enter Field Value" required>
                            <span class="text-danger error-value"></span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end">
                        <a href="{{ route('admin.field.type.list') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="updateBtn" class="btn btn-primary">
                            <span class="btn-text">Update Field Type</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        $(document).ready(function() {
            $("#editFieldTypeForm").on('submit', function(e) {
                e.preventDefault();

                // Disable button and show loader
                $("#updateBtn").attr("disabled", true);
                $("#updateBtn .btn-text").addClass('d-none');
                $("#updateBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.field.type.update', $fieldType->id) }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Field Type updated successfully");

                        // Reset button state
                        $("#updateBtn").attr("disabled", false);
                        $("#updateBtn .btn-text").removeClass('d-none');
                        $("#updateBtn .spinner-border").addClass('d-none');

                        // Redirect after short delay
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.field.type.list') }}";
                        }, 800);
                    },

                    error: function(xhr) {
                        // Reset button state
                        $("#updateBtn").attr("disabled", false);
                        $("#updateBtn .btn-text").removeClass('d-none');
                        $("#updateBtn .spinner-border").addClass('d-none');

                        // Validation errors
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-name').text(errors.name ?? '');
                            $('.error-value').text(errors.value ?? '');
                            $('.error-status').text(errors.status ?? '');
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });
        });
    </script>
@endsection
