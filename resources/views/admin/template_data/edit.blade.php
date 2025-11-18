@extends('admin.layout.main-layout')
@section('title', 'Edit Template Data')

@section('content')
    <div class="content">

        <h2>Edit Template Data ({{ $templateName }} / Group: {{ $groupId }})</h2>

        <form id="updatetemplatedata" method="POST" enctype="multipart/form-data">           
            <input type="hidden" name="template_name" class="form-control" value="{{ $templateName }}" readonly>
            <input type="hidden" name="group_id" class="form-control" value="{{ $groupId }}" readonly>
            <div class="row border p-2 my-2">
                @foreach ($records as $item)
                    @php
                        $field = $item->field;
                        $type = $field->type;
                        $value = $item->field_value;
                    @endphp
                    @if ($type === 'textarea')
                        <div class="col-md-6 mb-3">
                            <input type="hidden" name="{{ $item->field_id }}" class="form-control" value="{{ $item->field_name }}" readonly>
                            <textarea name="{{ $item->field_id }}" class="form-control" rows="3" {!! $field->validation_type !!}>{{ $value }}</textarea>
                        </div>
                    @elseif($type === 'radio')
                        @php
                            $options = is_array($field->options) ? $field->options : explode(',', $field->options);
                        @endphp
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $field->name }}</label>
                            <div class="d-flex flex-wrap mt-2">
                                @foreach ($options as $opt)
                                    <label class="me-3">
                                        <input type="radio" name="{{ $item->field_id }}" value="{{ trim($opt) }}"
                                            {{ $value == trim($opt) ? 'checked' : '' }}> {{ trim($opt) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @elseif($type === 'checkbox')
                        <div class="col-md-6 mb-3">
                            <input type="checkbox" name="{{ $item->field_id }}" value="1" {{ $value == '1' ? 'checked' : '' }}>
                            <label class="form-label">{{ $field->name }}</label>
                        </div>
                    @elseif($type === 'select')
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $field->name }}</label>
                            <select class="form-select" name="{{ $item->field_id }}">
                                @foreach ($field->dropdowns as $opt)
                                    <option value="{{ $opt->value }}" {{ $value == $opt->value ? 'selected' : '' }}>
                                        {{ $opt->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($type === 'file')
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $item->field_name }}</label>
                            <input type="{{ $type }}" name="{{ $item->field_id }}" class="form-control" {!! $field->validation_type !!}>
                        </div>
                    @else
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $item->field_name }}</label>
                            <input type="{{ $type }}" name="{{ $item->field_id }}" class="form-control" value="{{ $value }}" {!! $field->validation_type !!}>
                        </div>
                    @endif
                @endforeach
            </div>
            <button type="submit" id="submitBtn" class="btn btn-success my-3">
                <span id="btnText">Save Changes</span>
                <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
            </button>
        </form>
    </div>

    <script>
        $(document).on('click', '.remove-row', function() {
            $(this).closest('.row').remove();
        });
        $("#updatetemplatedata").on("submit", function(e) {
            e.preventDefault();

            // SHOW LOADER + DISABLE BUTTON
            $("#submitBtn").prop("disabled", true);
            $("#btnText").addClass("d-none");
            $("#btnLoader").removeClass("d-none");
            
            let form = document.getElementById("updatetemplatedata");
            let formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.template.data.update') }}",
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
                        window.location.href = "{{ route('admin.template.data.list') }}";
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
