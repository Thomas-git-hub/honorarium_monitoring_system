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
                            <small class="card-title text-success d-flex align-items-center gap-1"><i class='bx bxs-calendar'></i>August 2, 2024</small>
                        </div>
                        <div class="card-body text-success">
                            <div class="row d-flex align-items-center">
                                <div class="col-md d-flex align-items-center gap-3">
                                    <h1 class="text-success text-center d-flex align-items-center" style="font-size: 48px;">{{$onQueue}}<i class='bx bx-group' style="font-size: 48px;"></i></h1>
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

{{-- <div class="row mt-4 gap-3">
    <div class="col-md">
        <div class="card shadow-none bg-label-success">
        <div class="card-body text-success">
            <h5 class="card-title text-success">Faculty Honorarium has been Added to the Queue</h5>
            <h1 class="text-success">{{$onQueue}}</h1>
        </div>
        </div>
    </div>
</div> --}}

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card mb-5">
            <div class="card-header">
                <p class="text-secondary">Add Entries</p>
            </div>
            <div class="card-body">

                <form id="newEntriesForm">
                    @csrf

                    <div class="mb-3">
                        <label for="flatpickr-human-friendly" class="form-label">Requirements Date Received</label>
                        <input type="text" class="form-control flatpickr-date" placeholder="Month DD, YYYY" id="dateReceived" name="date_of_trans" />
                    </div>

                    {{-- <div class="mb-3">
                        <label for="exampleDataList" class="form-label">Faculty</label>
                        <input class="form-control" list="datalistOptions" id="addEntryName" name="faculty" placeholder="Search by Name/ID Number...">
                        <datalist id="datalistOptions">
                          <option value="San Francisco"></option>
                        </datalist>
                    </div> --}}

                    <div class="mb-3">
                        <label for="facultySelect" class="form-label">Faculty</label>
                        <select class="form-control" id="facultySelect" name="employee_id" style="width: 100%;">
                            <option selected disabled>Search by Name/ID Number...</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="HonoSelect" class="form-label">Honorarium</label>
                        <select id="HonoSelect" class="form-select" name="honorarium_id">
                          <option selected disabled>Select Honorarium</option>
                          {{-- <option value="1">Honorariums for Guest Lectures</option>
                          <option value="2">Research Assistantships (RAs)</option>
                          <option value="3">Teaching Assistantships (TAs)</option> --}}
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <p class="text-secondary">Preview of Items in Queue</p>
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
    </div>
</div>


@include('administration.email_toast')

@endsection



@section('components.specific_page_scripts')
{{-- FORM VALIDATION FOR NEW ENTRIES --}}
<script>
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
                            title: '<div class="row text-success"><i class="bx bxs-badge-alt" style="font-size: 56px;"></i></div><div class="row text-success d-flex justify-content-center">Added to Queue Succesfully!</div>',
                            text: 'Form added to queue.',
                            showClass: {
                                popup: 'animate__animated animate__bounceIn'
                            },
                            customClass: {
                                confirmButton: 'btn btn-success'
                            },
                            buttonsStyling: false
                        }).then(() => {
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
                        alert('Error in submission');
                    }
                });
            } else {
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
                { data: 'faculty', name: 'faculty', title: 'Faculty' },
                { data: 'id_number', name: 'id_number', title: 'ID Number' },
                { data: 'academic_rank', name: 'academic_rank', title: 'Academic Rank' },
                { data: 'college', name: 'college', title: 'College' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'sem', name: 'sem', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Semester Year' },
                { data: 'month.month_name', name: 'month', title: 'Month Of' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                // { data: 'action', name: 'action', title: 'Action' }
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

        $('#facultySelect').on('select2:select', function(e) {
            var selectedOption = $(this).select2('data')[0]; // Get the selected option data
            var facultyName = `${selectedOption.employee_fname} ${selectedOption.employee_lname}`;
            var facultyEmail = selectedOption.email; // Get the email from the selected data
            var facultyId = selectedOption.id; // The ID of the selected faculty

            // Update the hidden input and the To: container
            $('#user_id').val(facultyId);
            $('.card-body .text-dark').html(`<b>To:&nbsp;</b> ${facultyName}&nbsp;<small class="text-secondary" style="font-style: italic;">${facultyEmail}</small>`);
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
            };


            $.ajax({
                type: 'POST',
                url: '{{ route('insertFormData') }}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    if(response.success){
                        $('#spinner').hide();
                        $('#toastSuccess').toast('show');

                        Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });

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

                    }else{
                        $('#spinner').hide();
                        $('#sendingFailed').toast('show');
                    }
                },
                error: function(xhr, status, error) {
                    $('#spinner').hide();
                    $('#sendingFailed').toast('show');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while submitting the form. Please try again.',
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

@endsection