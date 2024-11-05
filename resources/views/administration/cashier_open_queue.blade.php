@extends('components.app')

@section('content')

<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="NetForm" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Net Amount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                Full Name:
                            </div>
                            <div class="col-md-8">
                                <b id="faculty"> </b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                Email:
                            </div>
                            <div class="col-md-8">
                                <b id="email">-</b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                Academic Rank:
                            </div>
                            <div class="col-md-8">
                                <b id="position">-</b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                Mother College:
                            </div>
                            <div class="col-md-8">
                                <b id="college">-</b>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-4">
                                Contact Number:
                            </div>
                            <div class="col-md-8">
                                <b id="contact">-</b>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-1">
                                <input type="hidden" id="id" name="id">
                                <label for="defaultFormControlInput" class="form-label text-primary">Total Net Amount</label>
                                <input type="text" class="form-control" id="netAmount" placeholder="₱0.00" aria-describedby="defaultFormControlHelp" />
                                <div id="netAmountHelp" class="form-text text-info">Enter the exact net amount and be sure to double-check the amount entered.</div>
                                <small class="text-danger"  id="netAmountError"  style="display:none;"><i class='bx bx-error-circle'></i> Please enter a valid amount with up to two decimal places.</small>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary addButton" id="addButton">Add Net Amount</button>
                        <button type="button" class="btn btn-label-danger" id="closeB" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- Add this new modal after the existing modal -->
    <div class="modal fade" id="deductionModal" tabindex="-1" aria-labelledby="deductionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deductionModalLabel">Add Deduction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="DeductionForm">
                    <div class="modal-body">
                        <input type="hidden" id="deduction_id" name="deduction_id">
                        <div class="mb-3">
                            <label for="deductionAmount" class="form-label text-primary">Deduction Amount</label>
                            <input type="text" class="form-control" id="deductionAmount" placeholder="₱0.00" />
                            <small class="text-danger" id="deductionAmountError" style="display:none;">
                                <i class='bx bx-error-circle'></i> Please enter a valid amount with up to two decimal places.
                            </small>
                            <div id="netAmountHelp" class="form-text text-info">Enter the exact deduction amount and be sure to double-check the amount entered.</div>

                        </div>
                        <div class="mb-3">
                            <label for="deductionRemarks" class="form-label text-primary">Deduction Remarks</label>
                            <textarea class="form-control" id="deductionRemarks" rows="3"></textarea>
                            <div id="netAmountHelp" class="form-text text-info">Please specify the reason for the deduction.</div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary" id="saveDeductionButton">Save Deduction</button>
                        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{-- <div class="row mt-4">
    <h4 class="card-title text-secondary">In Queue</h4>
</div> --}}

<div class="row mt-2 gap-3">
    <div class="col-md">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row mb-3"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>

                <h4 class="d-flex align-items-center">In-Queue Transaction Details</h4>
                <div class="row">
                    <div class="col-md">
                        <div class="alert alert-secondary">
                            Total Transactions: <b>{{$TransCount}}</b>
                        </div>
                    </div>
                    {{-- <div class="col-md">
                        <div class="alert alert-warning">
                            Received Date: <b>September 16, 2024</b>
                        </div>
                    </div> --}}
                </div>

                <div class="card shadow-none bg-label-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Tracking Number:</h5>
                        {{-- <h1 class="text-primary">{{$onQueue}}</h1> --}}
                        <h1 class="text-primary"> {{$batch_id ? $batch_id :  'No Data Found'}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col">
        <div class="row mb-2">
            <div class="col-md mx-auto d-flex justify-content-end">
                <button type="button" class="btn btn-primary gap-1 d-none" id="proceedTransactionButton">Proceed<i class='bx bx-chevrons-right'></i></button>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md mx-auto d-flex justify-content-end">
                <button class="btn btn-success">Transaction Finished</button>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="cashierOpenQueueTable" class="table table-borderless table-hover" style="width:100%">
                        <tbody class="text-center">
                            <!-- Data will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('components.specific_page_scripts')

{{-- DATATABLES --}}
<script>
    $(document).ready(function() {

        var batchId = {!! json_encode($batch_id) !!};
        var table = $('#cashierOpenQueueTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('cashier_open_queue.open_list') }}',
                data: function(d) {
                    d.batch_id = batchId; // Passing the batch ID as a parameter
                }
            },
            // data: [
            //     {
            //         batch_id: '000-0000',
            //         date_of_trans: 'September 17, 2024',
            //         faculty: 'John Doe',
            //         id_number: '0000-0000',
            //         academic_rank: 'lorem ipsum',
            //         college: 'lorem ipsum',
            //         honorarium: 'lorem ipsum',
            //         sem: 'lorem ipsum',
            //         year: '2024',
            //         month: 'July',
            //         created_by: 'John Doe',
            //         net_amount: '<button type="button" class="btn btn-sm btn-primary" id="" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>',
            //     }
            //     // Add more objects as needed
            // ],
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            columns: [
                { data: 'id', name: 'id', title: 'id', visible: false },
                { data: 'batch_id', name: 'batch_id', title: 'Tracking Number' },
                { data: 'date_of_trans', name: 'date_of_trans', title: 'Date Received' },
                { data: 'faculty', name: 'faculty', title: 'Faculty' },
                { data: 'id_number', name: 'id_number', title: 'ID Number' },
                { data: 'academic_rank', name: 'academic_rank', title: 'Academic Rank' },
                { data: 'college', name: 'college', title: 'College' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'sem', name: 'sem', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Semester Year' },
                { data: 'month.month_name', name: 'month', title: 'Month Of' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                { data: 'contact', name: 'contact', title: 'contact', visible: false },
                { data: 'netAmount', name: 'netAmount', title: 'netAmount', visible: false },
                {
                    data: 'deduction',
                    name: 'deduction',
                    title: 'Deduction',
                    render: function (data, type, row) {
                        var buttonTitle = data ? '₱' + parseFloat(data).toFixed(2) : 'Add';
                        return '<button type="button" class="btn btn-sm btn-warning deduction-btn" data-bs-toggle="modal" data-bs-target="#deductionModal">' + buttonTitle + '</button>';
                    }
                },
                {
                    data: 'net_amount',
                    name: 'net_amount',
                    title: 'Net Amount',
                    render: function (data, type, row) {
                        // Return HTML for buttons (edit, on hold, and add button)
                        var buttonTitle = data ? data : 'Add';
                        // Return the button with either the net_amount or 'Add' as the text
                        var addButton = '<button type="button" class="btn btn-sm btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">' + buttonTitle + '</button>';
                        return '<div class="d-flex flex-row" data-id="' + row.id + '">' + addButton + '</div>';
                    }
                }
            ],
        });

        $('#cashierOpenQueueTable').off('click').on('click', '.add-btn', function() {
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();
            console.log(rowData);

            // // Populate modal fields
            $('#id').val(rowData.id);
            $('#faculty').text(rowData.faculty);
            $('#office').text(rowData.office);
            $('#position').text(rowData.position);
            $('#email').text(rowData.email);
            $('#contact').text(rowData.contact);
            $('#college').text(rowData.college);
            $('#id_num').text(rowData.ee_number);
            $('#netAmount').val(rowData.netAmount);

        });

        // $('#NetForm').on('submit', function(e) {
        //     e.preventDefault(); // Prevent the default form submission

        //     var id = $('#id').val(); // Get the hidden ID value
        //     var netAmount = $('#netAmount').val(); // Get the net amount entered by the user

        //     // Validate the net amount before sending
        //     if (/^\d+(\.\d{1,2})?$/.test(netAmount)) {
        //         $('#netAmountError').hide(); // Hide any previous error message

        //         // Make AJAX request to submit the form data
        //         $.ajax({
        //             url: '{{ route('cashier_open_queue.store') }}',
        //             method: 'POST',          // Use POST method to send data
        //             data: {
        //                 id: id,              // Send the ID
        //                 net_amount: netAmount // Send the net amount
        //             },
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token if using Laravel
        //             },
        //             success: function(response) {
        //                 // Handle success response
        //                 $('#exampleModal').modal('hide'); // Hide the modal
        //                 table.ajax.reload();              // Reload the table to show updated data
        //                 alert('Net amount successfully saved.'); // Show success message
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle error
        //                 console.error(xhr.responseText);
        //                 alert('An error occurred while saving the net amount. Please try again.');
        //             }
        //         });
        //     } else {
        //         // Show error message if validation fails
        //         $('#netAmountError').show();
        //     }
        // });


        // // Function to handle adding the net amount to the table
        // function addNetAmount() {
        //     var netAmount = $('#netAmount').val().trim();
        //     var isValidAmount = /^[0-9]+(\.[0-9]{1,2})?$/.test(netAmount);

        //     if (isValidAmount) {
        //         var formattedAmount = `<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">₱${parseFloat(netAmount).toFixed(2)}</button>`;

        //         // Update the DataTable with the new amount
        //         table.column(11).data().each(function (value, index) {
        //             if (value.includes('Add')) {
        //                 table.cell(index, 11).data(formattedAmount).draw();
        //             }
        //         });

        //         // Close the modal
        //         $('#exampleModal').modal('hide');
        //     } else {
        //         alert('Please enter a valid amount with up to two decimal places.');
        //     }
        // }

        // function addNetAmount() {
        //     var netAmount = $('#netAmount').val().trim();
        //     var isValidAmount = /^[0-9]+(\.[0-9]{1,2})?$/.test(netAmount);

        //     if (isValidAmount) {
        //         // Hide the error message
        //         $('#netAmountError').hide();

        //         // Format the amount and update the DataTable
        //         var formattedAmount = `<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">₱${parseFloat(netAmount).toFixed(2)}</button>`;

        //         // Update the DataTable with the new amount
        //         table.column(11).data().each(function (value, index) {
        //             if (value.includes('Add')) {
        //                 table.cell(index, 11).data(formattedAmount).draw();
        //             }
        //         });

        //         // Close the modal
        //         $('#exampleModal').modal('hide');
        //     } else {
        //         // Show the error message
        //         $('#netAmountError').show();
        //     }
        // }

        // // Hide the error message when the input field is clicked/focused
        // $('#netAmount').on('focus', function() {
        //     // Just hide the error message without resetting the input field
        //     $('#netAmountError').hide();
        // });



        // // Add button click event
        // $('#addButton').on('click', addNetAmount);

        // // Enter key press event in the modal
        // $('#netAmount').on('keypress', function (e) {
        //     if (e.which == 13) { // Enter key pressed
        //         e.preventDefault(); // Prevent the default form submission
        //         addNetAmount(); // Call the addNetAmount function
        //     }
        // });

        // // Close button click event
        // $('#closeButton').on('click', function() {
        //     // Clear the input field
        //     $('#netAmount').val('');

        //     // Reload the page
        //     location.reload();
        // });

        // // Validate input for the #netAmount field to accept only numbers and decimals
        // $('#netAmount').on('input', function () {
        //     var value = $(this).val();
        //     // Remove any invalid characters (letters and special symbols except decimal point)
        //     var validValue = value.replace(/[^0-9.]/g, '');
        //     // Ensure only one decimal point is allowed
        //     var decimalCount = (validValue.match(/\./g) || []).length;
        //     if (decimalCount > 1) {
        //         validValue = validValue.replace(/\.(?=.*\.)/g, '');
        //     }
        //     $(this).val(validValue);
        // });


        // Function to handle adding the net amount to the table
        function addNetAmount() {
            var netAmount = $('#netAmount').val().trim();
            var isValidAmount = /^[0-9]+(\.[0-9]{1,2})?$/.test(netAmount);

            if (isValidAmount) {
                // Hide the error message
                $('#netAmountError').hide();

                // Format the amount for display in the DataTable
                var formattedAmount = `<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">₱${parseFloat(netAmount).toFixed(2)}</button>`;

                // Update the DataTable with the new amount
                table.column(11).data().each(function (value, index) {
                    if (value.includes('Add')) {
                        table.cell(index, 11).data(formattedAmount).draw();
                    }
                });

                // Close the modal
                $('#exampleModal').modal('hide');
            } else {
                // Show the error message
                $('#netAmountError').show();
            }
        }

        // Form submission handler
        $('#NetForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var id = $('#id').val(); // Get the hidden ID value
            var netAmount = $('#netAmount').val().trim(); // Get the net amount entered by the user
            var isValidAmount = /^[0-9]+(\.[0-9]{1,2})?$/.test(netAmount); // Validate the net amount

            if (isValidAmount) {
                $('#netAmountError').hide(); // Hide any previous error message

                // Make AJAX request to submit the form data
                $.ajax({
                    url: '{{ route('cashier_open_queue.store') }}',
                    method: 'POST', // Use POST method to send data
                    data: {
                        id: id, // Send the ID
                        net_amount: netAmount // Send the net amount
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle success response
                        $('#exampleModal').modal('hide');
                        table.ajax.reload();
                        alert('Net amount successfully saved.');
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                        alert('An error occurred while saving the net amount. Please try again.');
                    }
                });
            } else {
                // Show error message if validation fails
                $('#netAmountError').show();
            }
        });

        // Hide the error message when the input field is clicked/focused
        $('#netAmount').on('focus', function() {
            $('#netAmountError').hide();
        });

        // Add button click event to trigger form submission
        $('#addButton').on('click', function() {
            $('#NetForm').submit(); // Trigger form submission
        });

        // Handle Enter key press event in the modal
        $('#netAmount').on('keypress', function(e) {
            if (e.which == 13) { // Enter key pressed
                e.preventDefault(); // Prevent the default form submission
                $('#NetForm').submit(); // Trigger form submission
            }
        });

        // Close button click event to clear the form and reload the page
        $('#closeButton').on('click', function() {
            // Clear the input field
            $('#netAmount').val('');
            // Reload the page
            location.reload();
        });

        // Validate input for the #netAmount field to accept only numbers and decimals
        $('#netAmount').on('input', function() {
            var value = $(this).val();
            // Remove any invalid characters (letters and special symbols except decimal point)
            var validValue = value.replace(/[^0-9.]/g, '');
            // Ensure only one decimal point is allowed
            var decimalCount = (validValue.match(/\./g) || []).length;
            if (decimalCount > 1) {
                validValue = validValue.replace(/\.(?=.*\.)/g, '');
            }
            $(this).val(validValue);
        });

        // Add these handlers after your existing DataTable initialization
        $('#cashierOpenQueueTable').on('click', '.deduction-btn', function() {
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();

            // Populate modal fields
            $('#deduction_id').val(rowData.id);
            $('#deductionAmount').val(rowData.deduction || '');
            $('#deductionRemarks').val(rowData.deduction_remarks || '');
        });

        // Handle deduction form submission
        $('#DeductionForm').on('submit', function(e) {
            e.preventDefault();

            var id = $('#deduction_id').val();
            var amount = $('#deductionAmount').val().trim();
            var remarks = $('#deductionRemarks').val().trim();
            var isValidAmount = /^[0-9]+(\.[0-9]{1,2})?$/.test(amount);

            if (isValidAmount) {
                $('#deductionAmountError').hide();

                $.ajax({
                    url: '{{ route('cashier_open_queue.store_deduction') }}', // You'll need to create this route
                    method: 'POST',
                    data: {
                        id: id,
                        deduction_amount: amount,
                        deduction_remarks: remarks
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deductionModal').modal('hide');
                        table.ajax.reload();
                        alert('Deduction successfully saved.');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred while saving the deduction. Please try again.');
                    }
                });
            } else {
                $('#deductionAmountError').show();
            }
        });

        // Validate deduction amount input
        $('#deductionAmount').on('input', function() {
            var value = $(this).val();
            var validValue = value.replace(/[^0-9.]/g, '');
            var decimalCount = (validValue.match(/\./g) || []).length;
            if (decimalCount > 1) {
                validValue = validValue.replace(/\.(?=.*\.)/g, '');
            }
            $(this).val(validValue);
        });

        // Hide error on focus
        $('#deductionAmount').on('focus', function() {
            $('#deductionAmountError').hide();
        });

    });
</script>
@endsection
