@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create Dropdown')

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Dropdown</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Field Master</li>
                        <li class="breadcrumb-item active">Create Dropdown</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="dropdownForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Select Field <span class="text-danger">*</span></label>
                            <select name="field_id" class="form-select" required>
                                <option value="">Select Field</option>
                                @foreach ($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label d-block">Dropdown Options <span class="text-danger">*</span></label>

                            <div id="optionsWrapper">
                                <div class="row option-row align-items-end mb-2">
                                    <div class="col-md-5">
                                        <input type="text" name="label[]" class="form-control"
                                            placeholder="Enter Option Label" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="value[]" class="form-control"
                                            placeholder="Enter Option Value" required>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-success addOptionBtn"><i
                                                class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.dropdown.list') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <span class="btn-text">Create Dropdown</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Add new option row
            $(document).on('click', '.addOptionBtn', function() {
                let newRow = `
                    <div class="row option-row align-items-end mb-2">
                        <div class="col-md-5">
                            <input type="text" name="label[]" class="form-control" placeholder="Enter Option Label" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="value[]" class="form-control" placeholder="Enter Option Value" required>
                        </div>           
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-success addOptionBtn"><i class="ti ti-plus"></i></button>
                            <button type="button" class="btn btn-danger removeOptionBtn"><i class="ti ti-trash"></i></button>
                        </div>
                    </div>
                    `;

                $('#optionsWrapper').append(newRow);
            });

            // Remove option row
            $(document).on('click', '.removeOptionBtn', function() {
                $(this).closest('.option-row').remove();
            });

        });

        $(document).ready(function() {
            $('#dropdownForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let button = $('#saveBtn');
                let spinner = button.find('.spinner-border');
                let btnText = button.find('.btn-text');

                button.prop('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('Saving...');

                $.ajax({
                    url: "{{ route('admin.dropdown.store') }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Dropdown option created successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        form[0].reset();
                    },
                    error: function(xhr) {
                        let message = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message
                        });
                    },
                    complete: function() {
                        button.prop('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('Create Dropdown');
                    }
                });
            });
        });
    </script>
@endsection
