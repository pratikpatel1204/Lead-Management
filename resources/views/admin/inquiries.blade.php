@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Inquiries')

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Inquiries</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Contacts</li>
                        <li class="breadcrumb-item active">Inquiries</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="inquiryTable" class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquiries as $index => $inquiry)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $inquiry->name ?? 'N/A' }}</td>
                                    <td>{{ $inquiry->email }}</td>
                                    <td>{{ $inquiry->phone ?? '-' }}</td>
                                    <td>{{ $inquiry->subject ?? '-' }}</td>
                                    <td>{{ Str::limit($inquiry->message, 60) }}</td>
                                    <td>{{ $inquiry->created_at->format('d M Y h:i A') }}</td>
                                    <td>
                                        <a href="javascript:void(0);" 
                                           class="btn btn-sm btn-danger deleteInquiryBtn"
                                           data-id="{{ $inquiry->id }}">
                                            <i class="ti ti-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Script -->
    <script>
        $(document).ready(function () {
            // Initialize DataTable (optional)
            $('#inquiryTable').DataTable({
                pageLength: 10,
                order: [[6, "desc"]],
                responsive: true
            });

            // Delete Inquiry
            $(document).on('click', '.deleteInquiryBtn', function () {
                let id = $(this).data('id');
                let url = "{{ url('admin/inquiry-delete') }}/" + id;
                let row = $(this).closest('tr');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This inquiry will be permanently deleted!",
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
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire("Deleted!", res.message, "success");
                                    row.fadeOut(500, function () {
                                        $(this).remove();
                                    });
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
        });
    </script>
@endsection
