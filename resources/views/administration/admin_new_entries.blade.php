@extends('components.app')

@section('content')

<div class="row mt-4 gap-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4 class="card-title text-secondary">Adding Entries</h4>
                </div>

                <div class="row">
                    <div class="card shadow-none bg-label-success">
                        <div class="card-header d-flex justify-content-end">
                            <small class="card-title text-success d-flex align-items-center gap-1"><i class='bx bxs-calendar'></i>{{ date('F j, Y') }}</small>
                        </div>
                        <div class="card-body text-success">
                            <div class="row d-flex align-items-center">
                                <div class="col-md d-flex align-items-center gap-3">
                                    <h1 class="text-success text-center d-flex align-items-center" id="onQueue" style="font-size: 48px;">{{$onQueue}}<i class='bx bx-group' style="font-size: 48px;"></i></h1>
                                    <h5 class="card-title text-success">Faculty Honorarium has been added to the Queue</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md d-flex justify-content-end">
        <button class="btn btn-label-primary btn-sm" id="refresh"><i class='bx bx-refresh' ></i> Refresh</button>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-4">
        <div class="card mb-5">
            <div class="card-header">
                <p class="text-secondary">Add Entries</p>
            </div>
            <div class="card-body">

                <form id="newEntriesForm">
                    @csrf

                    <div class="mb-3">
                        <label for="flatpickr-human-friendly" class="form-label">Requirements Date Received</label>
                        <input type="text" class="form-control flatpickr-date" placeholder="Month DD, YYYY" id="dateReceived" name="date_of_trans"/>
                    </div>

                    <div class="mb-3">
                        <label for="facultySelect" class="form-label">Faculty</label>
                        <select class="form-control" id="facultySelect" name="employee_id" style="width: 100%;">
                            <option selected disabled>Search by Name</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="HonoSelect" class="form-label">Honorarium</label>
                        <select id="HonoSelect" class="form-select" name="honorarium_id">
                          <option selected disabled>Select Honorarium</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="defaultSelect" class="form-label">Select Semester</label>
                        <select id="defaultSelect" class="form-select" name="sem">
                          <option selected disabled>Select Semester</option>
                          <option value="First Semester">First Semester</option>
                          <option value="Second Semester">Second Semester</option>
                          <option value="Summer Term">Summer Term</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="flatpickr-date" class="form-label">Semester Year</label>
                        {{-- <input type="text" class="form-control flatpickr-date" placeholder="YYYY" id="yearPicker" name="year" /> --}}
                        <select id="year" class="form-select" placeholder="YYYY" id="yearPicker" name="year">
                            {{-- <option selected disabled>YYYY</option> --}}
                            @for ($i = date('Y'); $i >= 2012; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="defaultSelect" class="form-label">For the Month of</label>
                        <select id="month" class="form-select" name="month">
                          <option selected disabled>Select Month</option>
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

                    <div class="mb-5">
                        <div class="row">
                            <label for="defaultSelect" class="form-label">Select Whether Requirements submitted by the Faculty are Complete or Incomplete</label>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_complete" id="radioComplete" value="1" />
                                    <label class="form-check-label" for="radioComplete">Complete Requirements</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_complete" id="radioIncomplete" value="0" />
                                    <label class="form-check-label" for="radioIncomplete">Incomplete Requirements</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-6">
                        <div class="col-md-12 d-grid mx-auto" >
                            <button class="btn btn-success gap-1" type="submit" id="addToQueue" style="display:none;"><i class='bx bxs-add-to-queue' ></i>Add to Queue</button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd" id="sendEmailBtn" style="display: none;"><i class='bx bx-reply' >&nbsp;</i>Send Email</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <p class="text-secondary">In Queue Transactions</p>
            </div>
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

        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary w-100" id="GenerateTrackingNum">Generate Tracking Number</button>
        </div>

        <div class="card border border-primary trackingNumDisplay d-none" id="trackingNumDisplay">
            <div class="card-body">
                <div class="row d-flex align-items-center mb-5">
                    <label for="html5-text-input" class="col-md-4 col-form-label fs-6">Tracking Number:</label>
                    <div class="col-md-8">
                      <b class="text-primary" id="batchID">-</b>
                    </div>
                    <small class="text-danger"><b>Note:&nbsp;</b>Always attach the tracking number on the documents.</small>
                </div>
                <div class="row d-flex align-items-center">
                    <label for="html5-text-input" class="col-md-4 col-form-label">Total Transactions:</label>
                    <div class="col-md-8">
                      <b class="text-dark" id="transCount">-</b>
                    </div>
                </div>
                <div class="row d-flex align-items-center">
                    <label for="html5-text-input" class="col-md-4 col-form-label">On-Hold Transactions:</label>
                    <div class="col-md-8">
                      <b class="text-danger" id="holdCount">-</b>
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-3">
                    <label for="html5-text-input" class="col-md-4 col-form-label">Transaction Date:</label>
                    <div class="col-md-8">
                      <small class="text-dark" id="date"><?php echo date('F j, Y'); ?></small>
                    </div>
                </div>
                <div class="">
                    <small class="text-danger">If a batch transaction includes an On-Hold transaction, the entire batch will be placed on hold, including transactions that have complete requirements.</small>
                    <button class="btn btn-primary w-100" id="proceedTransactionButton">Proceed to next office</button>
                </div>

            </div>
        </div>
    </div>
</div>


@include('administration.email_toast')

@endsection



@section('components.specific_page_scripts')
{{-- FORM VALIDATION FOR NEW ENTRIES --}}
<script>

        function getNewEntries() {
            $.ajax({
                url: '{{ route('Getadmin_new_entries') }}',
                method: 'GET',
                success: function(data) {
                    $('#onQueue').text(data.onQueue);

                }
            });
        }
        getNewEntries();

    $(document).ready(function() {
        $('input[name="is_complete"]').change(function() {
            if ($(this).val() === '1') {
                $('#addToQueue').show();
                $('#messageIncomplete').hide();
            } else if ($(this).val() === '0') {
                $('#addToQueue').hide();
                $('#messageIncomplete').show();
            }
        });


        //Save New Entries
        $('#newEntriesForm').on('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            $('#newEntriesForm input, #newEntriesForm select').each(function() {
                if ($(this).val() === '' || $(this).val() === null) {
                    isValid = false;
                }
            });

            if (isValid) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('form.submit') }}',
                    data: $('#newEntriesForm').serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '<div class="row text-success"><i class="bx bxs-badge-alt" style="font-size: 56px;"></i></div><div class="row text-success d-flex justify-content-center">Added to Queue!</div>',
                            // text: '',
                            showClass: {
                                popup: 'animate__animated animate__bounceIn'
                            },
                            customClass: {
                                confirmButton: 'btn btn-success'
                            },
                            buttonsStyling: false
                        }).then(() => {
                            getNewEntries();
                            $('#facultyTable').DataTable().ajax.reload();
                            $('#newEntriesForm input[type="text"]').val('');
                            $('#newEntriesForm input[type="date"]').val('');
                            // $('#defaultSelect select').each(function() {
                            //     $(this).val($(this).find('option[selected]').val());
                            // });
                            $('#month').val('');
                            $('#defaultSelect').val('');
                            $('#newEntriesForm input[type="radio"]').prop('checked', false);
                            $('#facultySelect, #HonoSelect').val(null).trigger('change');
                            // $('#newEntriesForm').off('submit').submit();
                            $('#addToQueue').hide();


                        });
                    },
                    error: function(response) {
                        getNewEntries();

                        alert('Error in submission');
                    }
                });
            } else {
                getNewEntries();

                Swal.fire({
                    icon: 'error',
                    title: 'Fill in the Blanks!',
                    text: 'Please fill all the fields',
                    showClass: {
                        popup: 'animate__animated animate__shakeX'
                    },
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });
            }
        });

        $('#GenerateTrackingNum').on('click', function(e) {
            e.preventDefault();
            let isValid = true;

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin_new_entries.generate_trackingNum') }}',
                    data: $('#newEntriesForm').serialize(),
                    success: function(response) {
                        if(response.success){
                            var batchID = response.batch_id;
                            var onhold_transactions = response.onhold_transactions;
                            var processing_transactions = response.processing_transactions;
                            var date = response.date;

                            $('#GenerateTrackingNum').hide(); // Hide the generate tracking number button
                            $('#trackingNumDisplay').removeClass('d-none');
                            $('#batchID').text(batchID);
                            $('#holdCount').text(onhold_transactions);
                            $('#transCount').text(processing_transactions);
                            console.log(batchID);
                            getNewEntries();


                        }else{
                            var batchID = response.last_batch_id;
                            var onhold_transactions = response.onhold_transactions;
                            var processing_transactions = response.processing_transactions;

                            $('#GenerateTrackingNum').hide(); // Hide the generate tracking number button
                            $('#trackingNumDisplay').removeClass('d-none');
                            $('#batchID').text(batchID);
                            $('#holdCount').text(onhold_transactions);
                            $('#transCount').text(processing_transactions);
                            $('#date').text(date);
                        //     Swal.fire({
                        //     icon: 'error',
                        //     title: 'Error!',
                        //     text: response.message,
                        //     showClass: {
                        //         popup: 'animate__animated animate__bounceIn'
                        //     },
                        //     customClass: {
                        //         confirmButton: 'btn btn-success'
                        //     },
                        //     buttonsStyling: false
                        // })
                        getNewEntries();


                        }
                    },
                    error: function(response) {
                        getNewEntries();

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                            showClass: {
                                popup: 'animate__animated animate__bounceIn'
                            },
                            customClass: {
                                confirmButton: 'btn btn-success'
                            },
                            buttonsStyling: false
                        })
                    }
                });
        });

        $('#proceedTransactionButton').off('click').on('click', function() {
            $.ajax({
                url: '{{ route('admin_on_queue.proceedToBudgetOffice') }}',
                method: 'POST',
                data: {
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
                            title: 'Transaction Completed',
                            text: response.message,
                        }).then(function() {
                            // Reload the entire page when the "OK" button is clicked
                            location.reload();
                        });

                        getNewEntries();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong',
                            text: response.message,
                        });

                        getNewEntries();
                    }

                    // Reload DataTable
                    $('#facultyTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    getNewEntries();

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem updating the transactions.',
                    });
                }
            });
        });
    });



</script>
{{-- ADDING NEW ENTRIES END --}}


{{-- DATE PICKER START --}}
<script>
    var flatpickrDate = document.querySelector(".flatpickr-date");
    var year = $('#year').val();

    flatpickrDate.flatpickr({
    monthSelectorType: "static"
    });

</script>
{{-- DATE PICKER END --}}


{{-- DATATABLES --}}
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
                { data: 'date_of_trans', name: 'date_of_trans', title: 'Date Received' },
                // { data: 'faculty', name: 'faculty', title: 'Faculty' },
                {
                    data: 'faculty',
                    name: 'faculty',
                    title: 'Faculty',
                    render: function(data, type, row) {
                        return '<span class="text-primary">' + data + '</span>';
                    }
                },
                { data: 'id_number', name: 'id_number', title: 'ID Number' },
                { data: 'academic_rank', name: 'academic_rank', title: 'Academic Rank' },
                { data: 'college', name: 'college', title: 'College' },
                // { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                {
                    data: 'honorarium',
                    name: 'honorarium',
                    title: 'Honorarium',
                    render: function(data, type, row) {
                        return '<span class="badge rounded-pill bg-warning">' + data + '</span>';
                    }
                },
                { data: 'sem', name: 'sem', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Semester Year' },
                { data: 'month.month_name', name: 'month', title: 'Month Of' },
                // { data: 'status', name: 'status', title: 'Status' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                { data: 'status', name: 'status', title: 'Status' },
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
            $('#editDateReceived').val(rowData.date_received);
            $('#editFaculty').val(rowData.faculty.replace(/<[^>]+>/g, ''));
            $('#editIdNumber').val(rowData.id_number.replace(/<[^>]+>/g, ''));
            $('#editAcademicRank').val(rowData.academic_rank.replace(/<[^>]+>/g, ''));
            $('#editCollege').val(rowData.college);
            $('#editHonorarium').val(rowData.honorarium);

            // Set the select values
            $('#editSemester').val(
                rowData.semester.includes('First Semester') ? '1' :
                rowData.semester.includes('Second Semester') ? '2' :
                rowData.semester.includes('Summer Term') ? '3' : ''
            );

            $('#editSemesterYear').val(rowData.semester_year);
            $('#editMonthOf').val(
                {
                    'January': '1', 'February': '2', 'March': '3', 'April': '4',
                    'May': '5', 'June': '6', 'July': '7', 'August': '8',
                    'September': '9', 'October': '10', 'November': '11', 'December': '12'
                }[rowData.month_of]
            );
            $('#editRowIndex').val(table.row(row).index());

            // Show modal
            $('#editEntryModal').modal('show');
        });

        $('#floatingInput').val('Transaction On-Hold');
        $('#emailTextArea').val('Kindly visit the Administration Office to submit the missing documents for compliance.');

        $('#facultySelect').on('select2:select', function(e) {
            var userOfficeId = "{{ Auth::user()->office->name }}";
            var selectedOption = $(this).select2('data')[0]; // Get the selected option data
            var facultyName = `${selectedOption.employee_fname} ${selectedOption.employee_lname}`;
            var facultyEmail = selectedOption.email; // Get the email from the selected data
            var facultyId = selectedOption.id; // The ID of the selected faculty

            // Update the hidden input and the To: container
            $('#user_id').val(facultyId);
            $('.card-body .send_to').html(`<b>To:&nbsp;</b> ${facultyName}&nbsp;<small class="text-secondary" style="font-style: italic;">${facultyEmail}</small>`);
            $('#floatingInput').val('Transaction On-Hold');
            $('#emailTextArea').val(`Kindly visit the ${userOfficeId} Office to submit the missing documents for compliance.`);
        });

        $('#facultySelect').select2({
            placeholder: 'Search by Name/ID Number...',
            allowClear: true,
            ajax: {
                url: '{{ route('getUser') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(data) {
                    var options = [];
                    var searchTerm = $('#facultySelect').data('select2').dropdown.$search.val();

                    data.forEach(function(user) {
                        options.push({
                            id: user.id,
                            employee_fname: user.employee_fname,
                            employee_lname: user.employee_lname,
                            employee_no: user.employee_no,
                            email: user.email,
                            text: `${user.employee_fname} ${user.employee_lname}`,
                        });
                    });

                    return {
                        results: options
                    };
                },
                cache: true
            }
        });

        //Get Honorarium
        $.ajax({
            url: '{{ route('getHonorarium') }}',
            type: 'GET',
            success: function(data) {
                var select = $('#HonoSelect');
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

          // Handle Delete button click
          $('#facultyTable').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();

            // var transactionId = rowData.id; // Adjust if necessary

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin_new_entries.destroy') }}',
                        type: 'POST',
                        data: {
                            id: rowData.id,
                            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                                // Refresh the DataTable to reflect changes
                                getNewEntries();
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
                                'An error occurred',
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
        // $('#emailSuccess').hide();
        // $('#emailFailed').hide();

        $('#toastSuccess').show();
        $('#sendingFailed').show();


        $('#sendButton').on('click', function(event) {
            event.preventDefault();
            $('#spinner').show();

            var formData = {
                user_id: $('#user_id').val(),
                subject: $('#floatingInput').val(),
                message: $('#emailTextArea').val(),
                date_of_trans: $('#dateReceived').val(),
                employee_id: $('#facultySelect').val(),
                honorarium_id: $('#HonoSelect').val(),
                sem: $('#defaultSelect').val(),
                year: $('#year').val(),
                month: $('#month').val(),
                is_complete: $('#radioIncomplete').val(),
                documentation: $('input[name="documentation[]"]:checked').map(function() {
                    return $(this).val();
                }).get(),
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('insertFormData') }}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#spinner').hide();

                    if (response.success) {
                        $('#toastSuccess').toast('show');

                        Swal.fire({
                            icon: 'success',
                            title: 'Sent!',
                            text: response.message,
                        }).then(function() {
                            // This will reload the page once the "OK" button is clicked
                            location.reload();
                        });

                        $('#facultyTable').DataTable().ajax.reload();
                        $('#newEntriesForm input[type="text"]').val('');
                        $('#newEntriesForm input[type="date"]').val('');
                        $('#month').val('');
                        $('#defaultSelect').val('');
                        $('#newEntriesForm input[type="radio"]').prop('checked', false);
                        $('#facultySelect, #HonoSelect').val(null).trigger('change');

                    } else {
                        $('#sendingFailed').toast('show');
                    }
                },
                error: function(xhr, status, error) {
                    $('#spinner').hide();
                    $('#sendingFailed').toast('show');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Occurred During Form Submission',
                        text: 'Please ensure all fields are filled out correctly and none are left blank',
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

    });
</script>
{{-- SENDING EMAIL FOR SPINNER AND STATUS END--}}



{{-- CLEARING AND HIDING OF REPLY EMAIL CARD START--}}
<script>
    $(document).ready(function() {
        // Show the send email card, hide add to queue button, and scroll to send email when radioIncomplete is clicked
        $('#radioIncomplete').on('click', function() {
            $('#sendEmail').show();


            $('#label').show();
            $('#addToQueue').hide();

            // $('html, body').animate({
            //     // scrollTop: $("#sendEmail").offset().top
            // }, 10); // Adjust the duration as needed
        });


        // // Hide the send email card and show add to queue button when radioComplete is clicked
        $('#radioComplete').on('click', function() {
            $('#sendEmail').hide();
            $('#label').hide();
            $('#addToQueue').show();
        });

        // // Clear fields, hide email card, and reset the toggle when discard button is clicked
        $('#removeEmailReply').on('click', function() {
            $('#sendEmail').hide();
            $('#sendEmail').find('input[type="text"], textarea').val('');
            $('#addToQueue').hide();
            $('#label').hide();
            $('#spinner').hide();
            $('#emailSuccess').hide();
            $('#emailFailed').hide();
            $('input[name="is_complete"]').prop('checked', false);
        });

        // // Hide the send email card when send button is clicked
        // $('#sendButton').on('click', function() {
        //     $('#sendEmail').hide();
        // });
    });
</script>
{{-- CLEARING AND HIDING OF REPLY EMAIL CARD END--}}

<script>
    $('#radioIncomplete').on('click', function() {
        // Show the addToQueue button
        $('#sendEmailBtn').show();
    });

    $('#radioComplete').on('click', function() {
        // Show the addToQueue button
        $('#sendEmailBtn').hide();
        $('#addToQueue').show();
    });
</script>

<script>
    $(document).ready(function() {
        $('#refresh').click(function() {
            location.reload(); // Reloads the current page
        });
    });
</script>


@endsection
