@extends('components.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="proceed" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="text-secondary">Read</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="text-center text-warning"><i class='bx bxs-envelope fs-3'></i></h1>
          <p class="text-center text-warning fw-bold fs-4">You are about to send {{$onQueue}} Honorarium Transactions to next Office.</p>
          <p class="text-center">"Proceeding with this transaction indicates that every individual has submitted all necessary requirements for their honorarium."</p>

          {{-- Note: The ID No. consists of id-number month, day and year --}}
          {{-- <h5 class="text-center text-danger">Transaction Batch ID No. = <b>002-08122024</b></h5> --}}

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
          <button type="button" id="proceed_transaction" class="btn btn-primary gap-1">Proceed to
            @if(Auth::user()->usertype->name === 'Dean')
            Accounting
            @else
            next Office
            @endif
            @if(Auth::user()->usertype->name === 'Dean')
            <i class='bx bx-chevrons-right'></i></button>
            <button type="button" id="proceed_cashier" class="btn btn-warning gap-1">Proceed to Cashier
                <i class='bx bx-chevrons-right'></i></button>
            @endif
        </div>
      </div>
    </div>
</div>
{{-- EDIT MODAL END --}}

<!-- EDIT MODAL START -->
<div class="modal fade" id="editEntryModal" tabindex="-1" aria-labelledby="editEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEntryModalLabel">Edit Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form id="editForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" class="form-control" id="editid" name="id">
                <div class="mb-3">
                    <label for="editDateReceived" class="form-label">Date Received</label>
                    <input type="text" class="form-control" id="editDateReceived" disabled>
                </div>
                <div class="mb-3">
                    <label for="editFaculty" class="form-label">Faculty</label>
                    <input type="text" class="form-control" id="editFaculty" disabled>
                </div>
                <div class="mb-3">
                    <label for="editIdNumber" class="form-label">ID Number</label>
                    <input type="text" class="form-control" id="editIdNumber" disabled>
                </div>
                <div class="mb-3">
                    <label for="editAcademicRank" class="form-label">Academic Rank</label>
                    <input type="text" class="form-control" id="editAcademicRank" disabled>
                </div>
                <div class="mb-3">
                    <label for="editCollege" class="form-label">College</label>
                    <input type="text" class="form-control" id="editCollege" disabled>
                </div>
                <div class="mb-3">
                    <label for="editHonorarium" class="form-label">Honorarium</label>
                    <select type="text" class="form-select"  id="editHonorarium" name="honorarium_id"></select>
                </div>
                <div class="mb-3">
                    <label for="editSemester" class="form-label">Select Semester</label>
                    <select class="form-select" id="editSemester" name="sem">
                        <option value="First Semester">First Semester</option>
                        <option value="Second Semester">Second Semester</option>
                        <option value="Summer Term">Summer Term</option>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="flatpickr-date" class="form-label">Semester Year</label>
                        {{-- <input type="text" class="form-control flatpickr-date" placeholder="YYYY" id="yearPicker" name="year" /> --}}
                        <select id="editSemesterYear" class="form-select" placeholder="YYYY" id="yearPicker" name="year">
                            {{-- <option selected disabled>YYYY</option> --}}
                            @for ($i = date('Y'); $i >= 2012; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    {{-- <label for="editSemesterYear" class="form-label">Semester Year</label>
                    <select type="text" class="form-control" id="editSemesterYear" placeholder="YYYY"></select> --}}
                </div>
                <div class="mb-5">
                    <label for="editMonthOf" class="form-label">For the Month of</label>
                    <select class="form-select" id="editMonthOf" name="month">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <input type="hidden" id="editRowIndex">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
                <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
            </div>
        </form>
        </div>
    </div>
</div>
{{-- EDIT MODAL END --}}

{{-- MESSAGE MODAL START --}}
<!-- Modal -->
<div class="modal fade" id="onHoldMessage" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl" id="onHoldModalDialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title gap-1 d-flex align-items-center" id="backDropModalTitle"><i class='bx bxs-hand'></i>Hold Transaction</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="emailReply">
                <div class="d-flex justify-content-end gap-2">
                    <!-- Spinner -->
                    <div class="spinner-border text-primary" role="status" id="spinner" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <!-- Success Message -->
                    <div class="text-success d-flex flex-row gap-2" id="emailSuccess" style="display: none !important;">
                        <b>Sent</b><i class='bx bx-check-circle fs-3'></i>
                    </div>
                    <!-- Failed Message -->
                    <div class="text-danger d-flex flex-row gap-2" id="emailFailed" style="display: none !important;">
                        <b>Failed</b><i class='bx bx-x-circle fs-3'></i>
                    </div>
                </div>
                <div>
                    <p><b><small>To:</small></b> John Doe Duridut&nbsp;<small style="font-style: italic;">johndoe@bicol-u.edu.ph</small></p>
                </div>
                <div class="mb-4">
                    <label for="defaultInput" class="form-label">Subject</label>
                    <input id="defaultInput" class="form-control" type="text" placeholder="Subject"/>
                </div>
                <div>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Message" style="border: none;"></textarea>
                </div>
                <div class="border-top mt-3">
                    <div class=" d-flex flex-row justify-content-end mt-3 gap-2">
                        <button type="button" class="btn btn-label-danger border-none" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-custom-class="tooltip-danger" title="Discard email" id="removeEmailReply"><i class='bx bxs-trash-alt'></i></button>
                        <button type="button" class="btn btn-primary me-1 mb-1" id="sendButton"><i class='bx bxs-send'>&nbsp;</i>Send</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
{{-- MESSAGE MODAL END --}}

<div class="row mt-4">
    <h4 class="card-title text-secondary">In Queue</h4>
</div>

<div class="row mt-2 gap-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="card shadow-none bg-label-success">
                    <div class="card-header d-flex justify-content-end">
                        <small class="card-title text-success d-flex align-items-center gap-1"><i class='bx bxs-calendar'></i><?php echo date('F j, Y'); ?></small>
                    </div>
                    <div class="card-body text-success">
                        <div class="row d-flex align-items-center">
                            <div class="col-md d-flex align-items-center gap-3">
                                <h1 class="text-success text-center d-flex align-items-center" style="font-size: 48px;">{{$onQueue}}<i class='bx bx-file' style="font-size: 48px;"></i></h1>
                                <h5 class="card-title text-success">Honorarium to Transact</h5>
                            </div>
                        </div>
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
                <button type="button" class="btn btn-primary gap-1" id="proceedTransactionButton">Proceed<i class='bx bx-chevrons-right'></i></button>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="facultyTable" class="table table-borderless table-hover" style="width:100%">
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

{{--FACULTY DATATABLES START --}}
<script>
    $(function () {

        var table = $('#facultyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin_new_entries.list') }}',
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            columns: [
                { data: 'id', name: 'id', title: 'ID', visible: false},
                { data: 'batch_id', name: 'batch_id', title: 'batch_id', visible: false},
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
                { data: 'action', name: 'action', title: 'Action' }
            ],
            order: [[0, 'desc']], // Sort by date_received column by default
            columnDefs: [
                {
                    type: 'date',
                    targets: [0, 1] // Apply date sorting to date_received and date_on_hold columns
                }
            ],
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            }
        });

        // Handle Edit button click
        $('#facultyTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();

            // Populate modal fields
            $('#editid').val(rowData.id);
            $('#editDateReceived').val(rowData.date_of_trans);
            $('#editFaculty').val(rowData.faculty.replace(/<[^>]+>/g, ''));
            $('#editIdNumber').val(rowData.id_number);
            $('#editAcademicRank').val(rowData.academic_rank.replace(/<[^>]+>/g, ''));
            $('#editCollege').val(rowData.college);
            $('#editSemester').val(rowData.sem);
            $('#editSemesterYear').val(rowData.year).change();
            $('#editHonorarium').val(rowData.honorarium_id).change();

            $('#editMonthOf').val(rowData.month.month_number).change(); // Set the month

            //Get Honorarium
            // $('#editHonorarium').select2({
            //     placeholder: 'Select Honorarium',
            //     allowClear: true
            // });
            // $.ajax({
            //     url: '{{ route('getHonorarium') }}',
            //     type: 'GET',
            //     success: function(data) {
            //         var options = [];
            //         data.forEach(function(hono) {
            //             options.push({
            //                 id: hono.id,
            //                 text: hono.name,
            //             });
            //         });

            //         $('#editHonorarium').select2({
            //             data: options
            //         });
            //     },
            //     error: function(xhr, status, error) {
            //         console.error('Error fetching Honorarium:', error);
            //     }
            // });

            $.ajax({
                url: '{{ route('getHonorarium') }}',
                type: 'GET',
                success: function(data) {
                    var select = $('#editHonorarium');
                    data.forEach(function(hono) {
                        var option = $('<option></option>')
                            .val(hono.id)
                            .text(hono.name);
                        select.append(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching Honorarium:', error);
                }
            });

            // // Set the select values
            // $('#editSemester').val(
            //     rowData.semester.includes('First Semester') ? '1' :
            //     rowData.semester.includes('Second Semester') ? '2' :
            //     rowData.semester.includes('Summer Term') ? '3' : ''
            // );

            // $('#editSemesterYear').val(rowData.semester_year);
            // $('#editMonthOf').val(
            //     {
            //         'January': '1', 'February': '2', 'March': '3', 'April': '4',
            //         'May': '5', 'June': '6', 'July': '7', 'August': '8',
            //         'September': '9', 'October': '10', 'November': '11', 'December': '12'
            //     }[rowData.month_of]
            // );
            $('#editRowIndex').val(table.row(row).index());

            // Show modal
            $('#editEntryModal').modal('show');
        });

        // Handle On-Hold button click
        $('#facultyTable').on('click', '.on-hold-btn', function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();

            // var transactionId = rowData.id; // Adjust if necessary

            Swal.fire({
                title: 'Are you sure?',
                text: "The transaction will be put on hold.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin_on_queue.change_to_onhold') }}',
                        type: 'POST',
                        data: {
                            id: rowData.id,
                            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'On-hold!',
                                    response.message,
                                    'success'
                                );
                                // Refresh the DataTable to reflect changes
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while updating the transaction.',
                                'error'
                            );
                        }
                    });
                }
            });
        });


    });
</script>


{{-- SENDING EMAIL FOR SPINNER AND STATUS START --}}
<script>
    $(document).ready(function() {

        // Ensure success and failed messages are hidden on page load
        $('#emailSuccess').hide();
        $('#emailFailed').hide();

        $('#sendButton').on('click', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Show the spinner and hide success and failed messages
            $('#spinner').show();
            $('#emailSuccess').hide();
            $('#emailFailed').hide();

            // Simulate an asynchronous operation (e.g., an AJAX request)
            setTimeout(function() {
                // Hide the spinner
                $('#spinner').hide();

                // Logic to determine success or failure
                const isSuccess = Math.random() > 0.5; // Replace with actual success/failure logic
                if (isSuccess) {
                    $('#emailSuccess').show();
                } else {
                    $('#emailFailed').show();
                }
            }, 2000); // Simulate a 2-second delay for the operation
        });
    });
    </script>
{{-- SENDING EMAIL FOR SPINNER AND STATUS END--}}



{{-- CLEARING AND HIDING OF REPLY EMAIL CARD START--}}
<script>
    $(document).ready(function() {
        // Hide the modal and clear the input fields when the discard button is clicked
        $('#removeEmailReply').on('click', function() {
            $('#onHoldMessage').modal('hide');
            $('#emailReply').find('input[type="text"], textarea').val('');
        });
    });
</script>
{{-- CLEARING AND HIDING OF REPLY EMAIL CARD END--}}

<script>
    $(document).ready(function() {

        // Handle Proceed button click
        // $('#proceed_transaction').off('click').on('click', function() {
        //     $.ajax({
        //         url: '{{ route('admin_on_queue.proceedToBudgetOffice') }}',
        //         method: 'POST',
        //         data: {
        //             _token: $('meta[name="csrf-token"]').attr('content'),
        //         },
        //         success: function(response) {
        //             if(response.success){
        //                 $('#proceed').modal('hide');
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Success',
        //                     text: response.message,
        //                 });
        //             }else{
        //                 $('#proceed').modal('hide');
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Oh no!',
        //                     text: response.message,
        //                 });

        //             }
        //             $('#facultyTable').DataTable().ajax.reload();
        //         },
        //         error: function(xhr) {
        //             // Handle error
        //             $('#proceed').modal('hide');
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Error',
        //                 text: 'There was a problem updating the transactions.',
        //             });
        //         }
        //     });
        // });

        // Replace Bootstrap modal with SweetAlert2
$('#proceedTransactionButton').off('click').on('click', function() {
    Swal.fire({
        // title: 'Read',
        icon: 'question',
        html: `
            <p class="text-success fw-bold fs-4">You are about to send {{$onQueue}} Honorarium Transactions to the next Office.</p>
            <p class="text-muted">"Proceeding with this transaction indicates that every individual has submitted all necessary requirements for their honorarium."</p>
        `,
        showCancelButton: true,
        confirmButtonText: 'Proceed to @if(Auth::user()->usertype->name === "Dean") Accounting @else next Office @endif',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-primary gap-1',
            cancelButton: 'btn btn-label-danger'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX Request to proceed with the transaction
            $.ajax({
                url: '{{ route('admin_on_queue.proceedToBudgetOffice') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processing...',
                        html: '<div class="spinner-border text-primary" role="status"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },

                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaction forwarded Succesfully',
                            html: `<h4 class="text-success"><b>Tracking Number: ${response.batch_id}</b></h4><small class="text-danger">Note: Always attach the tracking number on the documents.</small>`,
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong',
                            text: response.message,
                        });
                    }
                    // Reload DataTable
                    $('#facultyTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem updating the transactions.',
                    });
                }
            });
        }
    });
});


        $('#proceed_cashier').off('click').on('click', function() {
            $.ajax({
                url: '{{ route('admin_on_queue.proceedToCashier') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if(response.success){
                        $('#proceed').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                    }else{
                        $('#proceed').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oh no!',
                            text: response.message,
                        });

                    }
                    $('#facultyTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    // Handle error
                    $('#proceed').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem updating the transactions.',
                    });
                }
            });
        });

        // Handle Save Changes button click
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('admin_on_queue.update') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    $('#editEntryModal').modal('hide');
                    $('#facultyTable').DataTable().ajax.reload();
                } else {
                    var errors = response.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + 'Error').text(value[0]);
                    });
                }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the transaction.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

        });

    });
</script>
@endsection
