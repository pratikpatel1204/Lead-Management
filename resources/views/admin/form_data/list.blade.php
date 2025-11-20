@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || ' . $name . ' Data List')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">{{ $name }} - Data List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $name }} - Data List</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.data.create', $name) }}" class="btn btn-primary mt-2 mt-md-0">
                <i class="ti ti-plus"></i> {{ $name }} Data
            </a>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $name }} - Data List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="datalistTable">
                            <thead>
                                <tr class="bg-light">
                                    @if (isset($templates) && count($templates) > 0)
                                        @php
                                            $firstGroup = $templates->first();
                                        @endphp
                                        @foreach ($firstGroup as $item)
                                            <th>{{ $item->field_name }}</th>
                                        @endforeach
                                    @endif
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($templates as $groupId => $records)
                                    <tr>
                                        @foreach ($records as $rec)
                                            <td>{{ $rec->field_value ?? '-' }}</td>
                                        @endforeach
                                        <td class="text-center">
                                            <a href="{{ route('admin.data.edit', ['name' => $item->template_name, 'groupid' => $groupId]) }}"
                                                class="btn btn-info btn-sm text-white me-1">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm deleteDataBtn"
                                                data-group="{{ $groupId }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="50" class="text-center">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
            let table = $('#datalistTable').DataTable();
            $(document).on('click', '.deleteDataBtn', function() {

                let groupId = $(this).data('group');
                let templateName = $(this).data('name');
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
                            url: "{{ route('admin.data.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                group_id: groupId,
                                template_name: templateName
                            },

                            success: function(res) {
                                if (res.status) {
                                    Swal.fire("Deleted", res.message, "success");
                                    row.remove();
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
        });
    </script>

@endsection
