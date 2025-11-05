@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Testimonial List')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Testimonial List</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Testimonial</li>
                    <li class="breadcrumb-item active" aria-current="page">Testimonial List</li>
                </ol>
            </nav>
        </div>

        @can('Testimonial')
        <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary mt-2 mt-md-0">
            + Add Testimonial
        </a>
        @endcan
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Testimonial List</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="testimonialTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Rating</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($testimonials as $key => $testimonial)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        @if ($testimonial->image)
                                            <img src="{{ asset($testimonial->image) }}" width="60" height="60" style="object-fit:cover;border-radius:5px;">
                                        @else
                                            <img src="{{ asset('default/no-img.jpg') }}" width="60" height="60" style="object-fit:cover;border-radius:5px;">
                                        @endif
                                    </td>

                                    <td>{{ $testimonial->name }}</td>
                                    <td>{{ $testimonial->designation }}</td>
                                    <td>{{ $testimonial->star }} ⭐</td>

                                    <td>
                                        <a href="{{ route('admin.testimonial.edit', $testimonial->id) }}" class="btn btn-sm btn-info">Edit</a>

                                        <button class="btn btn-sm btn-danger deleteTestimonialBtn" data-id="{{ $testimonial->id }}">
                                            Delete
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
</div>

<script>
$(document).ready(function() {
    let table = $('#testimonialTable').DataTable();

    $(document).on('click', '.deleteTestimonialBtn', function() {
        let id = $(this).data('id');
        let url = "{{ url('admin/testimonial-delete') }}/" + id;
        let row = $(this).closest('tr');

        Swal.fire({
            title: "Are you sure?",
            text: "This testimonial will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        if (res.status) {
                            Swal.fire("Deleted!", res.message, "success");
                            table.row(row).remove().draw(false);
                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    },
                    error: function(xhr) {
                        Swal.fire("Error", "Something went wrong!", "error");
                    }
                });
            }
        });
    });
});
</script>

@endsection
