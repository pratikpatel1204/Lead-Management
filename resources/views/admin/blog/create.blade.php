@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create Blog')

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Blog</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Blogs</li>
                        <li class="breadcrumb-item active">Create Blog</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Blog Details</h5>
                    </div>

                    <div class="card-body">
                        <form id="blogForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-category_id"></span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Blog Title"
                                        required>
                                    <span class="text-danger error-title"></span>
                                </div>                                

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="3" placeholder="Enter Short Description"></textarea>
                                    <span class="text-danger error-short_description"></span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="summernote"></textarea>
                                    <span class="text-danger error-description"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Blog Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <span class="text-danger error-image"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Author Name</label>
                                    <input type="text" name="author_name" class="form-control"
                                        placeholder="Enter Author Name">
                                    <span class="text-danger error-author_name"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Active" selected>Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <span class="text-danger error-status"></span>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('admin.blog.list') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" id="saveBtn" class="btn btn-primary">
                                    <span class="btn-text">Create Blog</span>
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
        $("#blogForm").on('submit', function(e) {
            e.preventDefault();

            $("#saveBtn").attr("disabled", true);
            $("#saveBtn .btn-text").addClass('d-none');
            $("#saveBtn .spinner-border").removeClass('d-none');

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.blog.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function(res) {
                    toastr.success("Blog created successfully");
                    $("#blogForm")[0].reset();
                    $("#saveBtn").attr("disabled", false);
                    $("#saveBtn .btn-text").removeClass('d-none');
                    $("#saveBtn .spinner-border").addClass('d-none');
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.blog.list') }}";
                    }, 800);
                },

                error: function(xhr) {
                    $("#saveBtn").attr("disabled", false);
                    $("#saveBtn .btn-text").removeClass('d-none');
                    $("#saveBtn .spinner-border").addClass('d-none');

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('.error-category_id').text(errors.category_id ?? '');
                        $('.error-title').text(errors.title ?? '');
                        $('.error-author_name').text(errors.author_name ?? '');
                        $('.error-short_description').text(errors.short_description ?? '');
                        $('.error-description').text(errors.description ?? '');
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
