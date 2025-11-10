@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Banner')

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Banner</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Banner</li>
                        <li class="breadcrumb-item active">Edit Banner</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Banner Details</h5>
                    </div>

                    <div class="card-body">
                        <form id="updateBannerForm" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $banner->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Banner Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ $banner->title }}"
                                        required>
                                    <span class="text-danger error-title"></span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Banner Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <span class="text-danger error-image"></span>

                                    @if ($banner->image)
                                        <div class="mt-2">
                                            <img src="{{ asset($banner->image) }}" width="120" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Active" {{ $banner->status == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ $banner->status == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <span class="text-danger error-status"></span>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('admin.banner.list') }}" class="btn btn-secondary">Back</a>

                                <button type="submit" id="saveBtn" class="btn btn-primary">
                                    <span class="btn-text">Update Banner</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#updateBannerForm").on('submit', function(e) {
                e.preventDefault();

                $("#saveBtn").attr("disabled", true);
                $("#saveBtn .btn-text").addClass('d-none');
                $("#saveBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.banner.update') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Banner updated successfully");

                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.banner.list') }}";
                        }, 800);
                    },

                    error: function(xhr) {
                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-title').text(errors.title ?? '');
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
