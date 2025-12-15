@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || ' . $field->name . ' Data List')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">{{ $field->name }} - Data List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $field->name }} - Data List</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.create.dropdown', $field->id) }}" class="btn btn-primary mt-2 mt-md-0">
                <i class="ti ti-plus"></i> {{ $field->name }} Data
            </a>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $field->name }} - Data List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="datalistTable">
                            <thead>
                                <tr class="bg-light">
                                    <tr>
                                        <th width="60">#</th>
                                        <th>Field Lable</th>
                                        <th>Field Value</th>
                                        <th width="120" class="text-center">Action</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dropdowns as $item)
                                    <tr> 
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$item->label}}</td>                                       
                                        <td>{{$item->value}}</td>                                                                          
                                        <td class="text-center">
                                            <a href="{{ route('admin.dropdown.edit', ['id' => $item->id]) }}" class="btn btn-info btn-sm text-white me-1">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm deleteDataBtn" data-id="{{ $item->id }}">
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
    </div>
    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
            let table = $('#datalistTable').DataTable();
            $(document).on('click', '.deleteDataBtn', function() {

                let id = $(this).data('id');
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
                            url: "{{ route('admin.dropdown.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
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
