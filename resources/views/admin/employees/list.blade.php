@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Employee List')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Employee List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active" aria-current="page">Employee List</li>
                    </ol>
                </nav>
            </div>
            @can('Create Employee')
                <a href="{{ route('admin.create.employee') }}" class="btn btn-primary mt-2 mt-md-0">
                    + Add Employee
                </a>
            @endcan
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Role List</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered" id="empTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th width="120">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($employees as $key => $emp)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if ($emp->profile_image)
                                                    <img src="{{ asset($emp->profile_image) }}" width="40"
                                                        height="40" style="border-radius:50%;">
                                                @else
                                                    <img src="{{ asset('default/no-img.jpg') }}" width="40"
                                                        height="40" style="border-radius:50%;">
                                                @endif
                                            </td>
                                            <td>{{ $emp->name }}</td>
                                            <td>{{ $emp->email }}</td>
                                            <td>
                                                @foreach ($emp->roles as $role)
                                                    <span class="badge bg-success">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if (!$emp->hasRole('super admin'))
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox"
                                                            role="switch" data-id="{{ $emp->id }}"
                                                            {{ $emp->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label status-text">
                                                            {{ $emp->status == 1 ? 'Active' : 'Inactive' }}
                                                        </label>
                                                    </div>
                                                @else
                                                    @if ($emp->status == 1)
                                                        <span class="badge bg-primary">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @can('Edit Employee')
                                                    @if (!$emp->hasRole('super admin'))
                                                        <a href="{{ route('admin.employee.edit', $emp->id) }}"
                                                            class="btn btn-sm btn-info">Edit</a>
                                                    @endif
                                                @endcan
                                                @can('Delete Employee')
                                                    @if (!$emp->hasRole('super admin'))
                                                        <button class="btn btn-sm btn-danger deleteEmployeeBtn"
                                                            data-id="{{ $emp->id }}">
                                                            Delete
                                                        </button>
                                                    @endif
                                                @endcan

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
        $(document).on('change', '.status-toggle', function() {

            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;
            var label = $(this).closest('.form-check').find('.status-text');

            $.ajax({
                url: "{{ route('admin.employee.update.status') }}",
                method: "POST",
                data: {
                    id: id,
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    if (response.success) {
                        // Update label text
                        label.text(status == 1 ? 'Active' : 'Inactive');

                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error("Server error occurred!");
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            let table = $('#empTable').DataTable();

            $(document).on('click', '.deleteEmployeeBtn', function() {
                let id = $(this).data('id');
                let url = "{{ url('admin/employee-delete') }}/" + id;
                let row = $(this).closest('tr'); // Get table row

                Swal.fire({
                    title: "Are you sure?",
                    text: "This employee will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire("Deleted!", res.message, "success");

                                    // ✅ Remove row without reloading page
                                    table.row(row).remove().draw(false);
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },
                            error: function(xhr) {
                                let message = "Something went wrong!";

                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                Swal.fire("Error", message, "error");
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
