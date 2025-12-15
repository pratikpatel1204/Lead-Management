@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create ' . $field->name . ' Data')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create {{ $field->name }} Data</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active">Create {{ $field->name }} Data</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create {{ $field->name }} Data</h5>
                    </div>
                    <div class="card-body">
                        <form id="createtemplatedata" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{ $field->id }}">
                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Option Label <span class="text-danger">*</span></label>                                    
                                    <input type="text" name="label" class="form-control" placeholder="Enter Option Label">
                                    <p class="text-danger small mt-1 d-none" id="labelError">Please enter Option Label</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Option Value <span class="text-danger">*</span></label>                                    
                                    <input type="text" name="value" class="form-control" placeholder="Enter Option Value">
                                    <p class="text-danger small mt-1 d-none" id="valueError">Please enter Option Value</p>
                                </div>                                
                            </div>
                            <a href="{{ route('admin.dropdown.list', $field->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" id="submitBtn" class="btn btn-success my-3">
                                <span id="btnText">Save</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#createtemplatedata").on("submit", function(e) {
            e.preventDefault();

            let label = $("input[name='label']").val().trim();
            let value = $("input[name='value']").val().trim();

            // Reset previous errors
            $("#labelError").addClass("d-none");
            $("#valueError").addClass("d-none");
            $("input[name='label'], input[name='value']").removeClass("is-invalid");

            let error = false;

            if (label === "") {
                $("#labelError").removeClass("d-none");
                $("input[name='label']").addClass("is-invalid");
                error = true;
            }

            if (value === "") {
                $("#valueError").removeClass("d-none");
                $("input[name='value']").addClass("is-invalid");
                error = true;
            }

            if (error) return; // stop form submission
            
            $("#submitBtn").prop("disabled", true);
            $("#btnText").addClass("d-none");
            $("#btnLoader").removeClass("d-none");

            let formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.dropdown.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {
                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: "Template data created successfully",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#createtemplatedata')[0].reset();
                    // setTimeout(() => {
                    //     window.location.href = "{{ route('admin.dropdown.list', $field->id) }}";
                    // }, 1500);
                },

                error: function(xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Please try again."
                    });
                },

                complete: function() {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").removeClass("d-none");
                    $("#btnLoader").addClass("d-none");
                }
            });
        });
    </script>

@endsection
