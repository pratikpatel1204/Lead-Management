@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Testimonial')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Edit Testimonial</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a></li>
                    <li class="breadcrumb-item">Testimonial</li>
                    <li class="breadcrumb-item active">Edit Testimonial</li>
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
                    <form id="updateTestimonialForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{ $testimonial->id }}">

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $testimonial->name }}" required>
                            <span class="text-danger error-name"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" value="{{ $testimonial->designation }}" required>
                            <span class="text-danger error-designation"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="star" class="form-control">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ $testimonial->star == $i ? 'selected' : '' }}>
                                        {{ str_repeat('⭐', $i) }}
                                    </option>
                                @endfor
                            </select>
                            <span class="text-danger error-star"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="4" required>{{ $testimonial->message }}</textarea>
                            <span class="text-danger error-message"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Client Image</label>
                            <input type="file" name="image" class="form-control">

                            @if($testimonial->image)
                                <img src="{{ asset($testimonial->image) }}" alt="Image" class="mt-2" style="width:100px;">
                            @endif

                            <span class="text-danger error-image"></span>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.testimonials.list') }}" class="btn btn-secondary">Cancel</a>

                            <button type="submit" id="updateBtn" class="btn btn-primary">
                                <span class="btn-text">Update Testimonial</span>
                                <span class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
$("#updateTestimonialForm").on('submit', function(e) {
    e.preventDefault();

    $("#updateBtn").attr("disabled", true);
    $("#updateBtn .btn-text").addClass('d-none');
    $("#updateBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.testimonial.update') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(res) {
            toastr.success(res.message);

            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            setTimeout(() => {
                window.location.href = "{{ route('admin.testimonials.list') }}";
            }, 800);
        },

        error: function(xhr) {
            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-name').text(errors.name ?? '');
                $('.error-designation').text(errors.designation ?? '');
                $('.error-star').text(errors.star ?? '');
                $('.error-message').text(errors.message ?? '');
                $('.error-image').text(errors.image ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>

@endsection
