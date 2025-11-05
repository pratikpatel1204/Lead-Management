@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Team Member')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Edit Team Member</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Team</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Team Details</h5>
                </div>

                <div class="card-body">

                    <form id="teamForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{ $team->id }}">

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $team->name }}" class="form-control" required>
                            <span class="text-danger error-name"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" value="{{ $team->designation }}" class="form-control" required>
                            <span class="text-danger error-designation"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">

                            @if($team->image)
                                <div class="mt-2">
                                    <img src="{{ asset($team->image) }}" width="80" height="80" style="object-fit:cover;border-radius:50%;">
                                </div>
                            @endif
                            <span class="text-danger error-image"></span>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.team.list') }}" class="btn btn-secondary">Cancel</a>

                            <button type="submit" id="updateBtn" class="btn btn-primary">
                                <span class="btn-text">Update</span>
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
$("#teamForm").on('submit', function(e) {
    e.preventDefault();

    $("#updateBtn").attr("disabled", true);
    $("#updateBtn .btn-text").addClass('d-none');
    $("#updateBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.team.update') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(res) {
            toastr.success("Team member updated successfully");

            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            setTimeout(() => {
                window.location.href = "{{ route('admin.team.list') }}";
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
                $('.error-image').text(errors.image ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>

@endsection
