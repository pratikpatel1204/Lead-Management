@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Dropdown')

@section('content')
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Dropdown</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Field Master</li>
                        <li class="breadcrumb-item active">Edit Dropdown</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form id="dropdownEditForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Select Field <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $field->name }}" disabled>
                            <input type="hidden" name="field_id" value="{{ $field->id }}">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label d-block">Dropdown Options <span class="text-danger">*</span></label>
                        <div id="optionsWrapper">
                            @forelse ($dropdowns as $dropdown)
                                <div class="row option-row align-items-end mb-2">
                                    <div class="col-md-5">
                                        <input type="text" name="label[]" class="form-control"
                                            placeholder="Enter Option Label" value="{{ $dropdown->label }}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="value[]" class="form-control"
                                            placeholder="Enter Option Value" value="{{ $dropdown->value }}" required>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-success addOptionBtn"><i
                                                class="ti ti-plus"></i></button>
                                        <button type="button" class="btn btn-danger removeOptionBtn"><i
                                                class="ti ti-trash"></i></button>
                                    </div>
                                </div>
                            @empty
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
                            @endforelse
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.dropdown.list') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <span class="btn-text">Update Dropdown</span>
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
        </div>`;
                $('#optionsWrapper').append(newRow);
            });

            // Remove option row
            $(document).on('click', '.removeOptionBtn', function() {
                $(this).closest('.option-row').remove();
            });

            // AJAX submit
            $('#dropdownEditForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let button = $('#saveBtn');
                let spinner = button.find('.spinner-border');
                let btnText = button.find('.btn-text');

                button.prop('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('Saving...');

                $.ajax({
                    url: "{{ route('admin.dropdown.update') }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Dropdown updated successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('admin.dropdown.list') }}";
                        });
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
                        btnText.text('Update Dropdown');
                    }
                });
            });

        });
    </script>
@endsection
