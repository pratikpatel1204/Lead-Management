@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit ' . $dropdown->field->name . ' Data')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit {{ $dropdown->field->name }} Data</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active">Edit {{ $dropdown->field->name }} Data</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit {{ $dropdown->field->name }} Data</h5>
                    </div>
                    <div class="card-body">
                        <form id="updatetemplatedata" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" class="form-control" value="{{ $dropdown->id }}">

                            <div class="row my-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Option Label <span class="text-danger">*</span></label>
                                    <input type="text" name="label" class="form-control" placeholder="Enter Option Label" value="{{ $dropdown->label }}">
                                    <p class="text-danger small mt-1 d-none" id="labelError">Please enter Option Label.</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Option Value <span class="text-danger">*</span></label>
                                    <input type="text" name="value" class="form-control" placeholder="Enter Option Value" value="{{ $dropdown->value }}">
                                    <p class="text-danger small mt-1 d-none" id="valueError">Please enter Option Value.</p>
                                </div>
                            </div>

                            <button type="submit" id="submitBtn" class="btn btn-success my-3">
                                <span id="btnText">Save Changes</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#updatetemplatedata").on("submit", function(e) {
            e.preventDefault();

            let label = $("input[name='label']").val().trim();
            let value = $("input[name='value']").val().trim();

            // Frontend validation
            let hasError = false;

            (label === "") ? ($("#labelError").removeClass("d-none"), hasError = true) : $("#labelError").addClass("d-none");
            (value === "") ? ($("#valueError").removeClass("d-none"), hasError = true) : $("#valueError").addClass("d-none");

            if (hasError) return; // stop submit if required fields missing

            // Activate loader + disable button
            $("#submitBtn").prop("disabled", true);
            $("#btnText").addClass("d-none");
            $("#btnLoader").removeClass("d-none");

            let form = document.getElementById("updatetemplatedata");
            let formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.dropdown.update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").removeClass("d-none");
                    $("#btnLoader").addClass("d-none");

                    Swal.fire({
                        icon: "success",
                        title: "Updated!",
                        text: "Template Data updated successfully!",
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(function() {
                        window.location.href = "{{ route('admin.dropdown.list', $dropdown->field->id) }}";
                    }, 1500);
                },

                error: function(xhr) {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").removeClass("d-none");
                    $("#btnLoader").addClass("d-none");

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Something went wrong. Please try again."
                    });

                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
