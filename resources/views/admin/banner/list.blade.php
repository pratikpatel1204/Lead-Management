@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Banner List')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Banner List</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Banner</li>
                    <li class="breadcrumb-item active" aria-current="page">Banner List</li>
                </ol>
            </nav>
        </div>

        @can('Banner')
        <a href="{{ route('admin.banner.create') }}" class="btn btn-primary mt-2 mt-md-0">
            + Add Banner
        </a>
        @endcan
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Banner List</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="bannerTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Banner Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($banners as $key => $banner)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        @if ($banner->image)
                                            <img src="{{ asset($banner->image) }}" width="60" height="40" style="object-fit:cover;border-radius:5px;">
                                        @else
                                            <img src="{{ asset('default/no-img.jpg') }}" width="60" height="40" style="object-fit:cover;border-radius:5px;">
                                        @endif
                                    </td>

                                    <td>{{ $banner->title }}</td>

                                    <td>
                                        @if ($banner->status == 'Active')
                                            <span class="badge bg-primary">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-sm btn-info">Edit</a>

                                        <button class="btn btn-sm btn-danger deleteBannerBtn" data-id="{{ $banner->id }}">
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
    let table = $('#bannerTable').DataTable();

    $(document).on('click', '.deleteBannerBtn', function() {
        let id = $(this).data('id');
        let url = "{{ url('admin/banners-delete') }}/" + id;
        let row = $(this).closest('tr');

        Swal.fire({
            title: "Are you sure?",
            text: "This banner will be permanently deleted!",
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
