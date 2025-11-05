@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Team List')

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Team Members</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Team</li>
                        <li class="breadcrumb-item active">Team List</li>
                    </ol>
                </nav>
            </div>
            @can('Create Team')
                <a href="{{ route('admin.create.team') }}" class="btn btn-primary mt-2 mt-md-0">
                    + Add Team Member
                </a>
            @endcan
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Team Members</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="teamTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th width="130">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($teams as $key => $team)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                @if ($team->image)
                                                    <img src="{{ asset($team->image) }}" width="60" height="60"
                                                        style="object-fit:cover;border-radius:50%;">
                                                @else
                                                    <img src="{{ asset('default/no-img.jpg') }}" width="60"
                                                        height="60" style="object-fit:cover;border-radius:50%;">
                                                @endif
                                            </td>

                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->designation }}</td>

                                            <td>
                                                @can('Team Edit')
                                                    <a href="{{ route('admin.team.edit', $team->id) }}"
                                                        class="btn btn-sm btn-info">Edit</a>
                                                @endcan
                                                @can('Team Delete')
                                                    <button class="btn btn-sm btn-danger deleteTeamBtn"
                                                        data-id="{{ $team->id }}">
                                                        Delete
                                                    </button>
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
        $(document).ready(function() {

            let table = $('#teamTable').DataTable();

            $(document).on('click', '.deleteTeamBtn', function() {
                let id = $(this).data('id');
                let url = "{{ url('admin/team-delete') }}/" + id;
                let row = $(this).closest('tr');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This team member will be permanently deleted!",
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
                                    table.row(row).remove().draw(false);
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },
                            error: function(xhr) {
                                Swal.fire("Error", "Something went wrong!", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
