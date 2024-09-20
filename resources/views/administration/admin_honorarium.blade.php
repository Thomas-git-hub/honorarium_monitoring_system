@extends('components.app')

@section('content')

    <div class="row mt-4">
        <h4 class="card-title text-secondary">Honorarium</h4>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-none border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div id="defaultFormControlHelp" class="form-text">
                                To add an honorarium, kindly provide the type or title of the honorarium in the field provided below.
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <form id="honorariumForm">
                                @csrf
                                <div id="honorariumFieldsContainer">
                                    <!-- Form fields will be added here -->
                                </div>
                                <div class="d-flex justify-content-between mt-3" id="buttonsContainer">
                                    <button type="button" class="btn btn-label-primary gap-1" id="addHonorariumField">
                                        <span class="tf-icons bx bxs-plus-circle bx-22px"></span>Add Honorarium
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="saveHonorarium" style="display: none;">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="honorariumTable" class="table table-borderless table-hover" style="width:100%">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('components.specific_page_scripts')

<script>
    $(document).ready(function() {
        let counter = 1; // Initialize counter

        // Function to update numbering for all honorarium entries
        function updateNumbering() {
            let i = 1;
            $('.honorarium-entry').each(function() {
                $(this).find('.pe-3 span').text(i);
                i++;
            });
            // Reset counter to the next number after the last entry
            counter = i;
        }

        // Add new honorarium input field
        $('#addHonorariumField').click(function() {
            var newField = `
            <div class="d-flex align-items-center mb-3 honorarium-entry">
                <div class="pe-3">
                    <span class="fw-bold text-primary">${counter}.</span>
                </div>
                <div class="form-floating flex-grow-1">
                    <input type="text" name="honorarium[]" class="form-control" placeholder="Enter Honorarium" aria-describedby="floatingInputHelp" required />
                    <label>Honorarium</label>
                </div>
                <button type="button" class="btn btn-icon btn-label-danger btn-lg ms-2 removeHonorariumField">
                    <span class="tf-icons bx bxs-minus-circle bx-22px"></span>
                </button>
            </div>`;

            // Insert new input field before the buttons container
            $('#honorariumFieldsContainer').append(newField);
            $('#saveHonorarium').show();

            // Increment the counter
            counter++;
        });

        // Remove honorarium input field
        $(document).on('click', '.removeHonorariumField', function() {
            $(this).closest('.honorarium-entry').remove();

            // Hide save button if no honorarium-entry divs remain
            if ($('.honorarium-entry').length === 0) {
                $('#saveHonorarium').hide();
            }

            // Update numbering for remaining fields
            updateNumbering();
        });

        // Function to check for duplicate values in all honorarium fields
        function hasDuplicates() {
            let values = [];
            let hasDuplicates = false;

            $('input[name="honorarium[]"]').each(function() {
                let val = $(this).val().trim(); // Get the value and trim spaces
                if (val !== "") {
                    if (values.includes(val)) {
                        hasDuplicates = true;
                        return false; // Exit loop early if duplicate is found
                    }
                    values.push(val);
                }
            });

            return hasDuplicates;
        }

        // Initialize numbering for existing fields on page load
        updateNumbering();

        // Form submission with duplicate check
        $('#honorariumForm').on('submit', function(e) {
            e.preventDefault();

            // Check for duplicate values before submitting the form
            if (hasDuplicates()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Error',
                    text: 'You have entered duplicate values. Please ensure all values are unique.',
                    showConfirmButton: true,
                });
                return; // Prevent form submission
            }

            // Proceed with AJAX submission if no duplicates
            $.ajax({
                url: '{{ route('admin_honorarium.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: true,
                        });
                        $('#honorariumFieldsContainer').empty();
                        $('#saveHonorarium').hide();
                        updateNumbering();
                        // Optionally, reload the DataTable or append the new data
                        $('#honorariumTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Laravel validation error
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';

                        $.each(errors, function(key, value) {
                            errorMessages += value[0] + '<br>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            showConfirmButton: true,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while saving the honorarium.',
                            showConfirmButton: true,
                        });
                    }
                }
            });
        });
    });

</script>


<script>
    $(document).ready(function() {
        var data = [
            {
                honorarium: '<strong>Honorariums for Guest Lectures</strong>',
                date_added: 'July 24, 2024',
                updated_at: 'July 25, 2024',
                action: '<button type="button" class="btn btn-icon btn-label-success me-2 edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>'
            },
            {
                honorarium: '<strong>Teaching Assistantships (TAs)</strong>',
                date_added: 'July 24, 2024',
                updated_at: 'July 25, 2024',
                action: '<button type="button" class="btn btn-icon btn-label-success me-2 edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>'
            },
            {
                honorarium: '<strong>Research Assistantships (RAs)</strong>',
                date_added: 'July 24, 2024',
                updated_at: 'July 25, 2024',
                action: '<button type="button" class="btn btn-icon btn-label-success me-2 edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>'
            }
        ];

        var table

        table = $('#honorariumTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin_honorarium.list') }}',
            columns: [
                { data: 'name', title: 'Honorarium' },
                { data: 'status', title: 'Status' },
                { data: 'created_at', title: 'Date Added' },
                { data: 'updated_at', title: 'Updated Last' },
                { data: 'action', title: 'Action' }
            ]
        });


        // Event delegation for edit buttons
        $('#honorariumTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();

            // Show input fields for editing
            var editForm = `<div class="d-flex flex-row align-items-center gap-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="${rowData.name}" id="editHonorarium" />
                                     <div class="invalid-feedback" id="nameError"></div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-icon me-2 btn-label-success btn-sm" id="saveBtn"><i class='bx bxs-check-circle'></i></button>
                                    <button type="button" class="btn btn-icon me-2 btn-danger btn-sm" id="cancelBtn"><i class='bx bxs-x-circle'></i></button>
                                </div>
                            </div>`;

            $(row).find('td').eq(0).html(editForm); // Replace the honorarium cell with the edit form
            $(row).find('td').eq(3).html(''); // Remove the action button for now

            // Handle Save button
            $('#saveBtn').click(function() {
            var newHonorarium = $('#editHonorarium').val();
            var now = new Date();
            var updatedDate = now.toLocaleDateString(); // Get the current date in locale format

            $.ajax({
                    url: '{{ route('admin_honorarium.update', '') }}/' + rowData.id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: newHonorarium
                    },
                    success: function(response) {
                        if(response.success){
                                Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: true,
                            });
                            rowData.name = newHonorarium;
                            rowData.updated_at = updatedDate; // Update the updated_at field
                            table.row(row).data(rowData).draw();
                        }


                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.name) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: errors.name[0],
                                showConfirmButton: true,
                            });
                        }else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while updating the honorarium.',
                                showConfirmButton: true,
                            });
                        }
                    }
                });
            });

            // Handle Cancel button
            $('#cancelBtn').click(function() {
                table.row(row).data(rowData).draw(); // Reset the row to its original state
            });
        });



    });
</script>

@endsection
