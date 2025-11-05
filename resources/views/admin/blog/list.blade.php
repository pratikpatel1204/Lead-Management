@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Blogs')

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Blogs</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Content</li>
                        <li class="breadcrumb-item active">Blogs</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    @can('Create Blogs')
                        <a href="{{ route('admin.create.blog') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="ti ti-circle-plus me-2"></i>Add Blog
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="row justify-content-center">
            @foreach ($blogs as $blog)
                <div class="col-xxl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="img-sec w-100 position-relative mb-3">
                                <img src="{{ asset($blog->image ?? 'assets/img/default-blog.jpg') }}"
                                    class="img-fluid rounded w-100" alt="img">
                                <div class="">
                                    <span
                                        class="trend-tag badge bg-info-transparent fs-10 fw-medium">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                                    <span
                                        class="badge badge-{{ $blog->status == 'Active' ? 'success' : 'danger' }} dot-icon">
                                        <i class="ti ti-point-filled"></i> {{ $blog->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="me-2 d-flex align-items-center"><i
                                            class="ti ti-calendar me-1"></i>{{ $blog->created_at->format('d M Y') }}</span>
                                    @if ($blog->author_name)
                                        <span class="d-flex align-items-center">
                                            <i class="ti ti-user me-1"></i> {{ $blog->author_name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center">
                                    @can('Blogs Edit')
                                        <a href="{{ route('admin.blog.edit', $blog->id) }}" class="link-default me-2"><i
                                                class="ti ti-edit"></i></a>
                                    @endcan
                                    @can('Blogs Delete')
                                        <a href="javascript:void(0);" class="link-default deleteBlogBtn"
                                            data-id="{{ $blog->id }}"><i class="ti ti-trash"></i></a>
                                    @endcan
                                </div>
                            </div>
                            <div class="mb-3">
                                <h4 class="fs-20 fw-medium text-truncate mb-3">{{ $blog->title }}</h4>
                                <h6 class="fs-16 fw-medium text-truncate mb-3">{{ $blog->short_description }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="my-4">
            {{ $blogs->links() }}
        </div>        
    </div>
    <script>
        $(document).on('click', '.deleteBlogBtn', function() {
            let id = $(this).data('id');
            let url = "{{ url('admin/blog-delete') }}/" + id;
            let row = $(this).closest('.col-xxl-4');

            Swal.fire({
                title: "Are you sure?",
                text: "This blog will be permanently deleted!",
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
    </script>
@endsection
