@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Category')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Edit Category</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Categories</li>
                    <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Category Details</h5>
                </div>

                <div class="card-body">
                    <form id="categoryEditForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{ $category->id }}">

                        <div class="mb-3">
                            <label class="form-label">Category Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ $category->title }}" required>
                            <span class="text-danger error-title"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description <span class="text-danger">*</span></label>
                            <textarea name="short_description" class="form-control" rows="3" required>{{ $category->short_description }}</textarea>
                            <span class="text-danger error-short_description"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Image</label><br>
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" width="80" height="60" style="object-fit:cover;border-radius:5px;">
                            @else
                                <img src="{{ asset('default/no-img.jpg') }}" width="80" height="60" style="object-fit:cover;border-radius:5px;">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="image" class="form-control">
                            <span class="text-danger error-image"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ $category->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $category->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <span class="text-danger error-status"></span>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.services.categories.list') }}" class="btn btn-secondary">Cancel</a>

                            <button type="submit" id="updateBtn" class="btn btn-primary">
                                <span class="btn-text">Update Category</span>
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
$("#categoryEditForm").on('submit', function(e) {
    e.preventDefault();

    $("#updateBtn").attr("disabled", true);
    $("#updateBtn .btn-text").addClass('d-none');
    $("#updateBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);
    let id = $("input[name=id]").val();

    $.ajax({
        url: "{{ route('admin.services.categories.update') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(res) {
            toastr.success("Category updated successfully");

            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            setTimeout(() => {
                window.location.href = "{{ route('admin.services.categories.list') }}";
            }, 800);
        },

        error: function(xhr) {
            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-title').text(errors.title ?? '');
                $('.error-short_description').text(errors.short_description ?? '');
                $('.error-image').text(errors.image ?? '');
                $('.error-status').text(errors.status ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>
@endsection
