@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Validation Types')

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Validation Types</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Validation Types</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    <a href="{{ route('admin.create.validation') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Add Validation Type
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="ValidationTable">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Validation Name</th>
                                <th>Validation Rule</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($validationTypes as $key => $validation)
                                <tr id="row-{{ $validation->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $validation->name }}</td>
                                    <td>{{ $validation->rule }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.validation.edit', $validation->id) }}"
                                            class="btn btn-sm btn-info me-1">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger deleteValidationTypeBtn"
                                            data-id="{{ $validation->id }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>                        
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Table -->

    </div>

    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
            let table = $('#ValidationTable').DataTable();
        });
        $(document).on('click', '.deleteValidationTypeBtn', function() {
            let id = $(this).data('id');
            let url = "{{ url('admin/validation-delete') }}/" + id;

            Swal.fire({
                title: "Are you sure?",
                text: "This validation type will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire("Deleted!", res.message, "success");
                                $("#row-" + id).remove();
                            } else {
                                Swal.fire("Error", res.message, "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "Something went wrong!", "error");
                        }
                    });
                }
            });
        });
    </script>
@endsection
