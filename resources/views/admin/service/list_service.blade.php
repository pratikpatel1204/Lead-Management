@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Services')

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Services List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Services</li>
                        <li class="breadcrumb-item active" aria-current="page">Service List</li>
                    </ol>
                </nav>
            </div>

            @can('Create Service')
                <a href="{{ route('admin.create.services') }}" class="btn btn-primary mt-2 mt-md-0">
                    + Add Service
                </a>
            @endcan
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Service List</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="serviceTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $key => $service)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $service->category->title ?? 'N/A' }}</td>
                                    <td>{{ $service->title }}</td>

                                    <td>
                                        @if ($service->image)
                                            <img src="{{ asset($service->image) }}" width="60" height="60"
                                                style="object-fit:cover;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ $service->created_at->format('d M, Y') }}</td>

                                    <td>
                                        @can('Service Edit')
                                            <a href="{{ route('admin.services.edit', $service->id) }}"
                                                class="btn btn-sm btn-info">Edit</a>
                                        @endcan
                                        @can('Service Delete')
                                        <button data-id="{{ $service->id }}"
                                            class="btn btn-sm btn-danger deleteServiceBtn">
                                            Delete
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Services Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#serviceTable').DataTable();
            $(document).on('click', '.deleteServiceBtn', function() {
                let id = $(this).data('id');
        
                Swal.fire({
                    title: "Are you sure?",
                    text: "This service will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
        
                        $.ajax({
                            url: "{{ url('admin/services-delete') }}/" + id,
                            type: "DELETE",
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(res) {
                                if (res.success) {
                                    Swal.fire("Deleted!", "Service deleted successfully!", "success");
                                    table.row(row).remove().draw(false);
                                } else {
                                    Swal.fire("Error", "Something went wrong!", "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Error", "Server error occurred!", "error");
                            }
                        });
        
                    }
                });
        
            });
        
        });
        </script>
        
@endsection
