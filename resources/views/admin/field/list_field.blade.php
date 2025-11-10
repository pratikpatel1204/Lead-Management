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
            <div class="mb-2">
                <a href="{{ route('admin.create.field') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="ti ti-circle-plus me-2"></i>Add Field
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
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
                        @forelse ($fields as $key => $field)
                            <tr id="row-{{ $field->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $field->name }}</td>
                                <td>{{ $field->type }}</td>
                                <td>{{ $field->validation }}</td>
                                <td>{{ $field->validation_type ?? '-' }}</td>
                                <td>{{ $field->default_value ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.field.edit', $field->id) }}" class="btn btn-sm btn-info me-1">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger deleteFieldBtn" data-id="{{ $field->id }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No Fields Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Table -->

</div>

<!-- Delete Script -->
<script>
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
@endsection
