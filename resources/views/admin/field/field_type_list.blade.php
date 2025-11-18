@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Field Types')

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Field Types</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Field Types</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    <a href="{{ route('admin.create.field.type') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Add Field Type
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="fieldtypeTable">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Field Name</th>
                                <th>Field Value</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($fieldTypes as $key => $type)
                                <tr id="row-{{ $type->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->value }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.field.type.edit', $type->id) }}"
                                            class="btn btn-sm btn-info me-1">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger deleteFieldTypeBtn"
                                            data-id="{{ $type->id }}">
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
            let table = $('#fieldtypeTable').DataTable();
        });
        $(document).on('click', '.deleteFieldTypeBtn', function() {
            let id = $(this).data('id');
            let url = "{{ url('admin/field-type-delete') }}/" + id;

            Swal.fire({
                title: "Are you sure?",
                text: "This field type will be permanently deleted!",
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
