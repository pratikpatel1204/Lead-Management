@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create Testimonial')

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Testimonial</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Testimonial</li>
                        <li class="breadcrumb-item active">Create Testimonial</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Testimonial Details</h5>
                    </div>

                    <div class="card-body">
                        <form id="testimonialForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Enter Name">
                                    <span class="text-danger error-name"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Designation <span class="text-danger">*</span></label>
                                    <input type="text" name="designation" class="form-control" required
                                        placeholder="Enter Designation">
                                    <span class="text-danger error-designation"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Rating <span class="text-danger">*</span></label>
                                    <select name="star" class="form-control">
                                        <option value="5">⭐⭐⭐⭐⭐</option>
                                        <option value="4">⭐⭐⭐⭐</option>
                                        <option value="3">⭐⭐⭐</option>
                                        <option value="2">⭐⭐</option>
                                        <option value="1">⭐</option>
                                    </select>
                                    <span class="text-danger error-star"></span>
                                </div>                        
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Client Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <span class="text-danger error-image"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control" rows="4" required placeholder="Enter Client Message"></textarea>
                                    <span class="text-danger error-message"></span>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.testimonials.list') }}" class="btn btn-secondary">Cancel</a>

                                <button type="submit" id="saveBtn" class="btn btn-primary">
                                    <span class="btn-text">Create Testimonial</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#testimonialForm").on('submit', function(e) {
                e.preventDefault();

                $("#saveBtn").attr("disabled", true);
                $("#saveBtn .btn-text").addClass('d-none');
                $("#saveBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.testimonial.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Testimonial created successfully");
                        $("#testimonialForm")[0].reset();

                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.testimonials.list') }}";
                        }, 800);
                    },

                    error: function(xhr) {
                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-name').text(errors.name ?? '');
                            $('.error-designation').text(errors.designation ?? '');
                            $('.error-star').text(errors.star ?? '');
                            $('.error-message').text(errors.message ?? '');
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
