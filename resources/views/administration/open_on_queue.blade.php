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
          {{-- <p class="text-center text-warning fw-bold fs-4">You are about to send {{$onQueue}} Honorarium Transactions to next Office.</p> --}}
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
          </button>
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
    <div class="modal-dialog modal-lg" role="document">
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
                @if(Auth::user()->usertype->name === 'Accounting')

                    <div>
                        <label for="editRemarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="editRemarks" name="remarks" rows="3"></textarea>
                    </div>

                    <input type="hidden" id="editRowIndex">

                @endif

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
                <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
            </div>
        </form>
        </div>
    </div>
</div>
{{-- EDIT MODAL END --}}

<!-- Remarks Modal -->
<div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title d-flex align-items-center text-warning" id="exampleModalLabel"><i class='bx bx-message-square-error'></i>&nbsp;Remarks</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body">
          <div>Updated by: <b class="text-primary" id="remarkUpdatedBy">Long name</b></div>
          <div>Updated last: <b class="text-primary" id="remarkUpdatedLast">Date</b></div>
          <p class="mt-3" id="remarksText">Croissant jelly beans donut apple pie. Caramels bonbon lemon drops. Sesame snaps lemon drops lemon drops liquorice icing bonbon pastry pastry carrot cake. Dragée sweet sweet roll sugar plum.</p>
        </div>
      </div>
    </div>
</div>
<!-- Remarks Modal End-->

<div class="row mt-2 gap-3">
    <div class="col-md">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row mb-3"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>

                <h4 class="d-flex align-items-center">Transaction Details</h4>
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
                        <h1 class="text-primary">{{$batch_id ? $batch_id :  'No Data Found'}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col">
        <div class="row mb-2">
            @if($hasOnHoldStatus)
            @if(Auth::user()->usertype->name !== 'Superadmin')
                <div class="col-md mx-auto d-flex justify-content-end">
                    <button type="button" class="btn btn-danger gap-1" id="onHoldTransactionButton">On Hold<i class='bx bx-chevrons-right'></i></button>
                </div>
                @endif
            @else
                @if(Auth::user()->usertype->name !== 'Superadmin')
                <div class="col-md mx-auto d-flex justify-content-end">
                    <button type="button" class="btn btn-primary gap-1 d-none" id="proceedTransactionButton">Proceed<i class='bx bx-chevrons-right'></i></button>
                </div>
                @endif
            @endif

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

@include('administration.email_toast')

@endsection

@section('components.specific_page_scripts')

{{--FACULTY DATATABLES START --}}
<script>
    $(function () {
        var batchId = {!! json_encode($batch_id) !!};

        var table = $('#facultyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin_on_queue.open_list') }}',
                data: function(d) {
                    d.batch_id = batchId; // Passing the batch ID as a parameter
                }
            },
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            order: [[4, 'desc']],
            columns: [
                { data: 'id', name: 'id', title: 'ID', visible: false},
                { data: 'employee_id', name: 'employee_id', title: 'employee_id', visible: false},
                { data: 'email', name: 'email', title: 'email', visible: false},
                { data: 'batch_id', name: 'batch_id', title: 'Tracking Number'},
                { data: 'date_of_trans', name: 'date_of_trans', title: 'Date Received' },
                { data: 'faculty', name: 'faculty', title: 'Faculty' },
                { data: 'id_number', name: 'id_number', title: 'ID Number' },
                { data: 'academic_rank', name: 'academic_rank', title: 'Academic Rank' },
                { data: 'college', name: 'college', title: 'College' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'status', name: 'status', title: 'Status' },
                { data: 'sem', name: 'sem', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Semester Year' },
                { data: 'month.month_name', name: 'month', title: 'Month Of' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                // New pie_chart column with render set to allow HTML
                @if(Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Administrator' )
                {
                    data: 'remarks',
                    name: 'remarks',
                    title: 'Remarks',
                    render: function(data, type, row) {
                        var remarksButton = '<button type="button" class="btn btn-icon me-2 btn-label-warning remarks-btn" data-bs-toggle="modal" data-bs-target="#remarksModal"><span class="tf-icons bx bx-message-square-error bx-22px"></span></button>';

                        return '<div class="d-flex flex-row" data-id="' + row.id + '">' + remarksButton + '</div>';
                    },
                    orderable: false,  // Disable ordering for this column if needed
                    searchable: false  // Disable searching for this column if needed
                },
                @endif

                { data: 'remark', name: 'remark', title: 'remark', visible: false},
                { data: 'updated_at', name: 'updated_at', title: 'updated_at', visible: false},
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
        $('#facultyTable').off('click').on('click', '.edit-btn', function() {
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

           // Clear previous options from the honorarium select field
            var select = $('#editHonorarium');
            select.empty(); // Clear all previous options

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


            $('#editRowIndex').val(table.row(row).index());

            // Show modal
            $('#editEntryModal').modal('show');
        });


        $('#facultyTable').on('click', '.remarks-btn', function() {
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();
            $('#remarkUpdatedBy').text(rowData.created_by);
            $('#remarkUpdatedLast').text(rowData.updated_at);
            $('#remarksText').text(rowData.remark.replace(/<[^>]+>/g, ''));
        });

        $('#facultyTable').on('click', '.on-hold-btn', function() {
            var userOfficeId = "{{ Auth::user()->office->name }}";
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();
            var facultyName = rowData.faculty;
            var facultyEmail = rowData.email
            var facultyId = rowData.employee_id;
            var transaction_id = rowData.id;

            // Update the hidden input and the To: container
            $('#trans_id').val(transaction_id);
            $('#user_id').val(facultyId);
            $('.card-body .send_to').html(`<b>To:&nbsp;</b> ${facultyName}&nbsp;<small class="text-secondary" style="font-style: italic;">${facultyEmail}</small>`);
            $('#floatingInput').val('Transaction On-Hold');
            $('#emailTextArea').val(`Kindly visit the ${userOfficeId} to submit the missing documents for compliance.`);
        });

        $('#sendButton').on('click', function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();

            var facultyId = $('#user_id').val();
            var subject =  $('#floatingInput').val();
            var trans_id = $('#trans_id').val();

            $.ajax({
                url: '{{ route('admin_on_queue.change_to_onhold') }}',
                type: 'POST',
                data: {
                    id: trans_id,
                    user_id: facultyId,
                    subject : subject,
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processing...',
                        html: '<div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                        title: 'On-hold!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reload the page
                            window.location.href = `/open_on_queue?id=${batchId}`;
                        }
                    });

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
        var batchId = {!! json_encode($batch_id) !!};

        @if(Auth::user()->usertype->name !== 'Administrator')
        $('#proceedTransactionButton').removeClass('d-none');
        @endif

        // Replace Bootstrap modal with SweetAlert2
        $('#proceedTransactionButton').off('click').on('click', function() {
            $.ajax({
                url: '{{ route('check.proceed.cashier') }}',
                method: 'POST',
                data: {
                    batch_id: batchId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'question',
                        html: `
                            <p class="text-success fw-bold fs-4">You are about to send Honorarium Transactions to the next Office.</p>
                            <p class="text-muted">"Proceeding with this transaction indicates that every individual has submitted all necessary requirements for their honorarium."</p>
                            ${response.canProceedToCashier ? '<button id="proceedToCashier" class="btn btn-success mt-3">Proceed to Cashier</button>' : ''}
                        `,
                        showCancelButton: true,
                        confirmButtonText: response.canProceedToCashier ? '' : 'Proceed to @if(Auth::user()->usertype->name === "Dean") Accounting @elseif(Auth::user()->usertype->name === "Accounting") Dean @else next Office @endif',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            confirmButton: 'btn btn-primary gap-1',
                            cancelButton: 'btn btn-label-danger'
                        },
                        buttonsStyling: false,
                        showConfirmButton: !response.canProceedToCashier
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // AJAX request to proceed with the transaction
                                    $.ajax({
                                        url: '{{ route('admin_on_queue.proceed') }}',
                                        method: 'POST',
                                        data: {
                                            batch_id: batchId,
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                        },
                                        beforeSend: function() {
                                            Swal.fire({
                                                title: 'Processing...',
                                                html: '<div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>',
                                                showConfirmButton: false,
                                                allowOutsideClick: false
                                            });
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Transaction forwarded successfully',
                                                    html: `<h4 class="text-success">Tracking Number:<b>${response.batch_id}</b></h4><small class="text-danger">Note: Always attach the tracking number on the documents.</small>`,
                                                    text: response.message,
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = '/history';
                                                    }
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Something went wrong',
                                                    text: response.message,
                                                });
                                            }
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
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem checking the batch status.',
                    });
                }
            });
        });

        $('#onHoldTransactionButton').off('click').on('click', function() {
            $.ajax({
                url: '{{ route('admin_on_queue.on_hold_batch') }}',
                method: 'POST',
                data: {
                    batch_id: batchId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processing...',
                        html: '<div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaction Successfully Placed on Hold',
                                html: `<h4 class="text-success">Tracking Number:<b>${response.batch_id}</b></h4><small class="text-danger">Note: Always attach the tracking number on the documents.</small>`,
                                // text: response.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/main_on_hold';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong',
                                text: response.message,
                            });
                        }
                        $('#facultyTable').DataTable().ajax.reload();

                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem checking the batch status.',
                    });
                },

            });
        });


        $(document).on('click', '#proceedToCashier', function() {
            $.ajax({
                url: '{{ route('admin_on_queue.proceedToCashier') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    batch_id: batchId,
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processing...',
                        html: '<div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    if(response.success){
                        Swal.fire({
                                icon: 'success',
                                title: 'Transaction forwarded successfully',
                                html: `<h4 class="text-success">Tracking Number:<b>${response.batch_id}</b></h4><small class="text-danger">Note: Always attach the tracking number on the documents.</small>`,
                                text: response.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to /history when OK is clicked
                                    window.location.href = '/history';
                                }
                            });
                    } else {
                        Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong',
                                text: response.message,
                            });
                    }
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

                    $('#editRemarks').val('');
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
