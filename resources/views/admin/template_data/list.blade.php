@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Template Data List')

@section('content')
<div class="content">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Template Data List</h2>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.create.template.data') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus"></i> Create New Form
            </a>

            <a href="#" class="btn btn-success">
                <i class="ti ti-upload"></i> Bulk Upload
            </a>
        </div>
    </div>

    @forelse ($templateData as $templateName => $dataSet)
        <div class="card mb-5 shadow-sm">

            <div class="card-header bg-primary text-white">
                <h4 class="text-white mb-0">{{ $templateName }}</h4>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-light">

                            <!-- Dynamic Header From Template Fields -->
                            @foreach ($dataSet['fields']->take(5) as $fieldName)
                                <th>{{ $fieldName }}</th>
                            @endforeach

                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($dataSet['groups']->take(5) as $groupId => $records)
                            <tr>

                                <!-- Field Values -->
                                @foreach ($dataSet['fields']->take(5) as $fieldId => $fieldName)
                                    @php
                                        $value = $records->firstWhere('field_id', $fieldId)->field_value ?? '-';
                                    @endphp
                                    <td>{{ $value }}</td>
                                @endforeach

                                <!-- Actions -->
                                <td>
                                    <a href="{{ route('admin.template.data.edit' , $groupId) }}" class="btn btn-info btn-sm text-white">
                                        Edit
                                    </a>

                                    <button class="btn btn-danger btn-sm deleteDataBtn" data-id="{{ $groupId }}">
                                        Delete
                                    </button>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    @empty
        <div class="alert alert-info text-center">No Template Data Found</div>
    @endforelse

</div>

<!-- Delete Script -->
<script>
    $(document).on('click', '.deleteDataBtn', function () {

        let id = $(this).data('id');
        let url = "{{ url('admin/template-data-delete') }}/" + id;
        let row = $(this).closest('tr');

        Swal.fire({
            title: "Are you sure?",
            text: "This form group will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        if (res.status) {
                            Swal.fire("Deleted", res.message, "success");
                            row.remove();
                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "Something went wrong!", "error");
                    }
                });

            }
        });

    });
</script>

@endsection
