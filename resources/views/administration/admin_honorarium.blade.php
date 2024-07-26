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
                                To add an honorarium, please enter the type or title of the honorarium here.
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <form action="/submit-honorarium" method="POST">
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
                        <table id="honorariumTable" class="table table-borderless" style="width:100%">
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

        // Initialize numbering for existing fields on page load
        updateNumbering();
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

        var table = $('#honorariumTable').DataTable({
            data: data,
            columns: [
                { data: 'honorarium', title: 'Honorarium' },
                { data: 'date_added', title: 'Date Added' },
                { data: 'updated_at', title: 'Updated At' },
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
                                    <input type="text" class="form-control" value="${rowData.honorarium.replace(/<.?strong>/g, '')}" id="editHonorarium" />
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

                rowData.honorarium = '<strong>' + newHonorarium + '</strong>';
                rowData.updated_at = updatedDate; // Update the updated_at field
                table.row(row).data(rowData).draw();
            });

            // Handle Cancel button
            $('#cancelBtn').click(function() {
                table.row(row).data(rowData).draw(); // Reset the row to its original state
            });
        });
    });
</script>

@endsection
