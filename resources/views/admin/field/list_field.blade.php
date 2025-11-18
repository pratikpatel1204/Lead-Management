@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Fields')

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Fields</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Fields</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2 me-2">
                    <a href="{{ route('admin.create.field') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Add Field
                    </a>
                </div>

                <div class="mb-2 me-2">
                    <a href="{{ route('admin.fields.sample.download') }}" class="btn btn-success d-flex align-items-center">
                        <i class="ti ti-file-download me-2"></i>Download Excel Sample
                    </a>
                </div>

                <div class="mb-2">
                    <button type="button" class="btn btn-info d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#uploadExcelModal">
                        <i class="ti ti-file-upload me-2"></i>Upload Excel
                    </button>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="fieldTable">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Field Name</th>
                                <th>Type</th>
                                <th>Validation</th>
                                <th>Validation Type</th>
                                <th>Default Value</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($fields as $key => $field)
                                <tr id="row-{{ $field->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $field->name }}</td>
                                    <td>{{ $field->type }}</td>
                                    <td>{{ $field->validation }}</td>
                                    <td>{{ $field->validation_type ?? '-' }}</td>
                                    <td>{{ $field->default_value ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.field.edit', $field->id) }}"
                                            class="btn btn-sm btn-info me-1">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger deleteFieldBtn" data-id="{{ $field->id }}">
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
    </div>
    <div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="excelUploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadExcelModalLabel">Upload Excel File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Select Excel File (.xlsx or .csv)</label>
                            <input type="file" class="form-control" name="excel_file" id="excel_file" accept=".xlsx,.csv"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-upload me-1"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
            let table = $('#fieldTable').DataTable();
        });

        $(document).on('click', '.deleteFieldBtn', function() {
            let id = $(this).data('id');
            let url = "{{ url('admin/field-delete') }}/" + id;

            Swal.fire({
                title: "Are you sure?",
                text: "This field will be permanently deleted!",
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
                            if (res.status) {
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
    <script>
        $(document).ready(function() {
            $('#excelUploadForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.fields.bulk.upload') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        toastr.info('Uploading file, please wait...');
                    },
                    success: function(response) {
                        toastr.clear();
                        $('#uploadExcelModal').modal('hide');
                        $('#excelUploadForm')[0].reset();
                        toastr.success(response.message || 'Excel uploaded successfully!');
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    },
                    error: function(xhr) {
                        toastr.clear();
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('Something went wrong while uploading the file.');
                        }
                    }
                });
            });
        });
    </script>

@endsection
