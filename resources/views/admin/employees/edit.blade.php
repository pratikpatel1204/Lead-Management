@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Employee')

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Employee</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active">Edit Employee</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Update Employee</h5>
                    </div>

                    <div class="card-body">
                        <form id="employeeEditForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $employee->id }}">

                            <div class="mb-3">
                                <label class="form-label">Employee Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ $employee->name }}" class="form-control"
                                    required>
                                <span class="text-danger error-name"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ $employee->email }}" class="form-control"
                                    required>
                                <span class="text-danger error-email"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @if ($employee->roles->first()->name == $role->name) selected @endif>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-role"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password">
                                <span class="text-danger error-password"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                                <span class="text-danger error-profile_image"></span>

                                @if ($employee->profile_image)
                                    <img src="{{ asset($employee->profile_image) }}" width="80" class="mt-2 rounded">
                                @endif
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.employee.list') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" id="updateBtn" class="btn btn-primary">
                                    <span class="btn-text">Update Employee</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#employeeEditForm").on('submit', function(e) {
                e.preventDefault();

                $("#updateBtn").attr("disabled", true);
                $("#updateBtn .btn-text").addClass('d-none');
                $("#updateBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.employee.update') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Employee updated successfully");

                        $("#updateBtn").attr("disabled", false);
                        $("#updateBtn .btn-text").removeClass('d-none');
                        $("#updateBtn .spinner-border").addClass('d-none');

                        setTimeout(() => {
                            window.location.href = "{{ route('admin.employee.list') }}";
                        }, 1000);
                    },

                    error: function(xhr) {

                        $("#updateBtn").attr("disabled", false);
                        $("#updateBtn .btn-text").removeClass('d-none');
                        $("#updateBtn .spinner-border").addClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-name').text(errors.name ?? '');
                            $('.error-email').text(errors.email ?? '');
                            $('.error-role').text(errors.role ?? '');
                            $('.error-profile_image').text(errors.profile_image ?? '');
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });
        </script>

    @endsection
