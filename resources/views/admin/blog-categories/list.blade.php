@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Blog Categories List')

@section('content')
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Blog Categories List</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Blog</li>
                    <li class="breadcrumb-item active" aria-current="page">Blog Categories</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-primary mt-2 mt-md-0">
            + Add Category
        </a>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Blog Categories</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="blogCategoryTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->name }}</td>

                                    <td>
                                        @if ($category->status == 'Active')
                                            <span class="badge bg-primary">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        
                                        <button class="btn btn-sm btn-danger deleteCategoryBtn" data-id="{{ $category->id }}">
                                            Delete
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
</div>


<script>
$(document).ready(function() {
    let table = $('#blogCategoryTable').DataTable();

    $(document).on('click', '.deleteCategoryBtn', function() {
        let id = $(this).data('id');
        let url = "{{ url('admin/blog-categories-delete') }}/" + id;
        let row = $(this).closest('tr');

        Swal.fire({
            title: "Are you sure?",
            text: "This category and all related blogs will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire("Deleted!", res.message, "success");
                            table.row(row).remove().draw(false);
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
