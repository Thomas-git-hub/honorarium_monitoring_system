@extends('components.app')

@section('content')
 {{-- Page Title --}}
 <div class="row">
    <div class="col-md">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="mb-3"><a href="/thesis-out-going" class=""><i class='bx bx-left-arrow-alt text-primary' id="" style="font-size: 2em; cursor: pointer;"></i></a></div>

                <h4 class="d-flex align-items-center"><i class='bx bx-list-ul'  style="font-size: 32px;"></i>Batch Out Going Defenses Transaction Details</h4>
                <div class="row">
                    <div class="col-md">
                        <div class="alert alert-secondary total-transaction">
                            Total Transactions: <b></b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-success office">
                            From: <b></b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-warning date">
                            Received Date: <b></b>
                        </div>
                    </div>
                </div>


                <div class="card shadow-none bg-label-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Tracking Number:</h5>
                        {{-- <h1 class="text-primary">{{$onQueue}}</h1> --}}
                        <h1 class="text-primary tracking"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Deduction and Net Amount Modal--}}
<div class="modal fade" id="addHonorariumAmount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Add Honorarium Amount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="honorariumForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" id="transaction_id" name="transaction_id">
                <div class="row mb-3">
                    <div class="col-md">
                        <h4>Student: &nbsp;<b class="text-primary" id="student"></b></h4>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <div>Defense Date: &nbsp;<b class="text-primary" id="defense_date"></b></div>
                    </div>
                    <div class="col-md mb-2">
                        <div>Defense Time: &nbsp;<b class="text-primary" id="defense_time"></b></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md mb-2">
                        <div>Degree: &nbsp;<b class="text-primary" id="degree"></b></div>
                    </div>
                    <div class="col-md mb-2">
                        <div>Defense: &nbsp;<b class="text-primary" id="defense"></b></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md">
                        <input type="hidden" id="adviser_id" name="adviser_id">
                        <div>Adviser: &nbsp;<b class="text-primary" id="adviser"></b></div>
                        <input id="adviserInputAmount" class="form-control form-control-md mb-2" type="text" name="adviser_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                    <div class="col-md">
                        <input type="hidden" id="chairperson_id" name="chairperson_id">
                        <div>Chairperson: &nbsp;<b class="text-primary" id="chairperson"></b></div>
                        <input id="chairpersonInputAmount" class="form-control form-control-md mb-2" type="text" name="chairperson_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md">
                        <div>Members:</div>
                        <div id="membersList"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md">
                        <input type="hidden" id="recorder_id" name="recorder_id">
                        <div>Recorder: &nbsp;<b class="text-primary" id="recorder"></b></div>
                        <input id="recorderInputAmount" class="form-control form-control-md mb-2" type="text" name="recorder_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Amount</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="col-md mx-auto d-flex justify-content-end mt-4">
    <button type="button" class="btn btn-primary gap-1" id="proceedTransactionButton">Proceed<i class='bx bx-chevrons-right'></i></button>
</div>

{{-- Datatables --}}
<div class="row mt-2">
    <div class="col">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="thesisOpenOutGoingTable" class="table table-borderless table-hover" style="width:100%">
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
    $(function () {
        var tracking_number = {!! json_encode($tracking_number) !!};

        window.showMembersAlert = function(id) {
            $.ajax({
                url: '{{ route("thesis.getMembersByID") }}', // Route to get members by ID
                type: 'GET',
                data: { id: id }, // Return the id to the backend
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                success: function(members) {

                    const membersString = members.map(member => {
                        return `<strong>Member Type:</strong> ${member.member_type}<br><strong>Name:</strong> ${member.first_name} ${member.last_name}`;
                    }).join('<br><br>');

                    Swal.fire({
                        title: 'Member(s)',
                        html: membersString,
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#007bff',
                        footer: 'Viewing members for thesis entry.'
                    });

                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!',
                    });
                }
            });

        };

        // New function to fetch transaction details
        window.fetchTransactionDetails = function(tracking_number) {
            $.ajax({
                url: '{{ route("thesis.fetchTransactionDetails") }}', // New route for fetching transaction details
                type: 'GET',
                data: { tracking_number: tracking_number },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                success: function(response) {

                    const thesisLogs = response.thesisLogs;
                    const TransCount = response.TransCount;
                    const office = response.office;
                    const transactionDetails = response.transactionDetails;
                    const tracking_number = response.tracking_number;


                    $('.office b').text(office ? office.name : 'N/A');
                    $('.tracking').text(tracking_number ? tracking_number : 'N/A');
                    $('.total-transaction b').text(TransCount ? TransCount : '0');
                    $('.date b').text(
                        transactionDetails && transactionDetails.updated_at
                            ? new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).format(new Date(transactionDetails.updated_at))
                            : 'N/A'
                    );

                    // $('.text-primary h1').text(data ? data.tracking_number : 'N/A');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!',
                    });
                }
            });
        };

        // Call the function with the tracking number when the page loads or based on user action
        fetchTransactionDetails(tracking_number); // Assuming tracking_number is available

        // Datatables
        // var thesisOpenOutgoingTable;
        var thesisOpenOutgoingTable = $('#thesisOpenOutGoingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('thesis.open.out.list') }}',
                data: function(d) {
                    d.tracking_number = tracking_number;
                }
            },
            pageLength: 100,
            paging: true,
            dom: '<"top"Bf>rt<"bottom"ip><"clear">',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },

            columns: [
                { data: 'student', name: 'student', title: 'Student' },
                { data: 'defense_date', name: 'defense_date', title: 'Defense Date' },
                { data: 'defense_time', name: 'defense_time', title: 'Defense Time' },
                { data: 'orNumber', name: 'orNumber', title: 'OR' },
                { data: 'degree', name: 'degree', title: 'Degree' },
                { data: 'defense', name: 'defense', title: 'Defense' },
                { data: 'adviser', name: 'adviser', title: 'Adviser' },
                { data: 'chairperson', name: 'chairperson', title: 'Chairperson' },
                { data: 'membersCount', name: 'membersCount', title: 'Members', render: function(data, type, row) {
                    return `<a href="#" onclick="showMembersAlert(${row.id})">${data}</a>`;
                } },
                { data: 'recorder', name: 'recorder', title: 'Recorder' },
                { data: 'date', name: 'date', title: 'Date' },
                @if(Auth::user()->usertype->name === 'Administrator')
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex">
                                <button type="button" class="btn btn-icon me-2 btn-label-success add-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#addHonorariumAmount">
                                    <span class="tf-icons bx bx-show-alt bx-22px"></span>
                                </button>
                            </div>
                        `;
                    }
                }
                @endif
            ],
            buttons: [
                {
                    extend: 'excelHtml5', // 'excel' is not the correct option, use 'excelHtml5'
                    text: 'Export Batch as .xls',
                    className: 'btn btn-primary shadow-none',
                    filename: function() {
                        var trackingNumber = 'Tracking_Number'; // Replace with actual tracking number logic

                        // Get the current date and format it as "Month Name, Day, Year"
                        var date = new Date();
                        var options = { year: 'numeric', month: 'long', day: 'numeric' };
                        var formattedDate = date.toLocaleDateString('en-US', options); // Format: "Month Day, Year" (e.g., "November 20, 2024")

                        return trackingNumber + '_' + formattedDate; // Format: Tracking_Number_Month Day, Year
                    },
                    exportOptions: {
                        columns: ':not(:last-child)' // This excludes the last column (the 'Action' column) from the export
                    }
                }
            ],
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            }
        });

        $('#honorariumForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            let isValid = true;
            $(this).find('input[type="text"]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (isValid) {
                // If valid, proceed with AJAX submission
                $.ajax({
                    url: '{{ route("thesis.submitAmount") }}', // New route for saving honorarium
                    type: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Handle success response
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#addHonorariumAmount').modal('hide'); // Hide modal
                        // Optionally refresh data or perform other actions
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong!',
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error',
                    text: 'Please fill in all fields before submitting.',
                });
            }
        });

        // Replace Bootstrap modal with SweetAlert2
        $('#proceedTransactionButton').off('click').on('click', function() {
            $.ajax({
                url: '{{ route('thesis.check.proceed.cashier') }}',
                method: 'POST',
                data: {
                    batch_id: tracking_number,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'question',
                        html: `
                            <p class="text-success fw-bold fs-4">You are about to send Thesis Transactions to the next Office.</p>
                            <p class="text-muted">"Proceeding with this transaction indicates that every individual has submitted all necessary requirements for their honorarium."</p>
                            ${response.canProceedToCashier ? '<button id="proceedToCashier" class="btn btn-success mt-3">Proceed to Cashier</button>' : ''}
                        `,
                        showCancelButton: true,
                        confirmButtonText: response.canProceedToCashier ? '' : 'Proceed to @if(Auth::user()->usertype->name === "Accounting") Dean @else next Office @endif',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            confirmButton: 'btn btn-primary gap-1',
                            cancelButton: 'btn btn-label-danger'
                        },
                        buttonsStyling: false,
                        showConfirmButton: !response.canProceedToCashier
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: '{{ route('thesis.proceedByTN') }}',
                                        method: 'POST',
                                        data: {
                                            tracking_number: tracking_number,
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
                                                    title: response.message,
                                                    html: `<h4 class="text-success">Tracking Number:<b>${response.batch_id}</b></h4><small class="text-danger">Note: Always attach the tracking number on the documents.</small>`,
                                                    text: response.message,
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = '/thesis-track-and-monitor';
                                                    }
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Something went wrong',
                                                    text: response.message,
                                                });
                                            }
                                            $('#thesisOpenOutGoingTable').DataTable().ajax.reload();
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

        $(document).on('click', '#proceedToCashier', function() {
            $.ajax({
                url: '{{ route('thesis.proceed-to-cashier') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    batch_id: tracking_number,
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
                                    // Redirect to /thesis-out-going' when OK is clicked
                                    window.location.href = '/thesis-out-going';
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

    });

    $(document).on('click', '.add-btn', function() {
        var id = $(this).data('id'); // Get the ID from the button's data attribute

        $.ajax({
            url: '{{ route("thesis.honorarium.data") }}', // Route to fetch honorarium data
            type: 'GET',
            data: { id: id }, // Send the ID to the backend
            success: function(data) {
                // Populate the modal fields with the retrieved data
                $('#transaction_id').val(data.transaction.id);
                $('#adviser_id').val(data.transaction.adviser_id);
                $('#chairperson_id').val(data.transaction.chairperson_id);
                $('#recorder_id').val(data.transaction.recorder_id);
                $('#student').text(data.transaction.student ? data.transaction.student.first_name + ' ' + data.transaction.student.last_name : 'N/A');
                $('#defense_date').text(data.transaction.defense_date || 'N/A');
                $('#defense_time').text(data.transaction.defense_time || 'N/A');
                $('#degree').text(data.transaction.degree ? data.transaction.degree.name : 'N/A');
                $('#defense').text(data.transaction.defense ? data.transaction.defense.name : 'N/A');
                $('#recorder').text(data.transaction.recorder ? data.transaction.recorder.first_name + ' ' + data.transaction.recorder.last_name : 'N/A');
                $('#adviser').text(data.transaction.adviser ? data.transaction.adviser.first_name + ' ' + data.transaction.adviser.last_name : 'N/A');
                $('#chairperson').text(data.transaction.chairperson ? data.transaction.chairperson.first_name + ' ' + data.transaction.chairperson.last_name : 'N/A');

                // Set the amounts in the input fields
                $('#adviserInputAmount').val(data.adviser_amount || '');
                $('#chairpersonInputAmount').val(data.chairperson_amount || '');
                $('#recorderInputAmount').val(data.recorder_amount || '');

                // Display members with input fields for honorarium amounts
                let membersHtml = '';
                data.members.forEach(member => {
                    const memberAmount = data.member_amounts[member.id] || '';
                    membersHtml += `
                        <div>${member.member_type}: &nbsp;<b class="text-primary">${member.first_name} ${member.last_name}</b></div>
                        <input class="form-control form-control-md mb-2 member-input" type="text" name="member_ids[${member.id}]" placeholder="Enter Honorarium Amount" value="${memberAmount}"/>
                    `;
                });
                $('#membersList').html(membersHtml);
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Something went wrong!',
                });
            }
        });
    });
</script>
@endsection
