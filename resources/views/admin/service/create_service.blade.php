@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create Service')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Create Service</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Services</li>
                    <li class="breadcrumb-item active">Create Service</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Service Details</h5>
                </div>

                <div class="card-body">
                    <form id="serviceForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Service Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-category_id"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Service Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="Enter Service Title">
                            <span class="text-danger error-title"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="summernote" name="description"></textarea>
                            <span class="text-danger error-description"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Service Image</label>
                            <input type="file" name="image" class="form-control">
                            <span class="text-danger error-image"></span>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.services.list') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" id="saveBtn" class="btn btn-primary">
                                <span class="btn-text">Create Service</span>
                                <span class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
$("#serviceForm").on('submit', function(e) {
    e.preventDefault();

    $("#saveBtn").attr("disabled", true);
    $("#saveBtn .btn-text").addClass('d-none');
    $("#saveBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.services.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(res) {
            toastr.success("Service created successfully");
            $("#serviceForm")[0].reset();

            $("#saveBtn").attr("disabled", false);
            $("#saveBtn .btn-text").removeClass('d-none');
            $("#saveBtn .spinner-border").addClass('d-none');
        },

        error: function(xhr) {
            $("#saveBtn").attr("disabled", false);
            $("#saveBtn .btn-text").removeClass('d-none');
            $("#saveBtn .spinner-border").addClass('d-none');

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-category_id').text(errors.category_id ?? '');
                $('.error-title').text(errors.title ?? '');
                $('.error-description').text(errors.description ?? '');
                $('.error-image').text(errors.image ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>
@endsection
