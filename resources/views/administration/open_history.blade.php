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
            <h1 class="text-center text-success"><i class='bx bxs-badge-check fs-3' ></i></h1>
            <p class="text-center text-success fw-bold fs-4">Transaction Acknowledged!</p>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
          <a href="/admin_on_queue" class="btn btn-primary gap-1">Open In Queue Table<i class='bx bx-chevrons-right'></i></a>
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
            <div class="modal-body">
                <form id="editForm">
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
                        <select type="text" class="form-control" id="editHonorarium" name="honorarium_id"></select>
                    </div>
                    <div class="mb-3">
                        <label for="editSemester" class="form-label">Select Semester</label>
                        <select class="form-select" id="editSemester">
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
                        <select class="form-select" id="editMonthOf">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
            </div>
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

<div class="row">
    <div class="col-md">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row mb-3"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>

                <h4 class="d-flex align-items-center"><i class='bx bx-list-ul'  style="font-size: 32px;"></i>Batch Transaction Details</h4>
                <div class="row">
                    <div class="col-md">
                        <div class="alert alert-danger">
                            Batch ID Number: <b>{{$batch_id}}</b>
                        </div>
                    </div>
                </div>


                <div class="card shadow-none bg-label-secondary">
                    <div class="card-body">
                        <h5 class="card-title text-secondary">Total Number of Transactions</h5>
                        {{-- <h1 class="text-primary">{{$onQueue}}</h1> --}}
                        <h1 class="text-secondary">{{$TransCount}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col">
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
        var batchId = {!! json_encode($batch_id) !!};
        // var data = [
        //     {
        //         date_received: '<p>07/26/2024</p>',
        //         faculty: '<p class="text-primary">John Doe</p>',
        //         id_number: '<p class="text-primary">1-id-no-2024</p>',
        //         academic_rank: '<span class="badge bg-label-primary">Associate Professor II</span>',
        //         college: '<p>College of Arts</p>',
        //         honorarium: '<p>honorarium here</p>',
        //         semester: '<p class="text-success">First Semester</p>',
        //         semester_year: '<p>2024</p>',
        //         month_of: '<p>July</p>',
        //         action: '<div class="d-flex flex-row"> <button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button><button type="button" class="btn btn-icon me-2 btn-label-danger on-hold-btn" data-bs-toggle="modal" data-bs-target="#onHoldMessage"><span class="tf-icons bx bxs-hand bx-18px"></span></button> </div>',
        //     },
        //     // More data...
        // ];

        var table = $('#facultyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('OpenHistoryList') }}',
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
            $('#editDateReceived').val(rowData.date_of_trans);
            $('#editFaculty').val(rowData.faculty.replace(/<[^>]+>/g, ''));
            $('#editIdNumber').val(rowData.id_number.replace(/<[^>]+>/g, ''));
            $('#editAcademicRank').val(rowData.academic_rank.replace(/<[^>]+>/g, ''));
            $('#editCollege').val(rowData.college);
            $('#editSemester').val(rowData.sem);
            $('#editSemesterYear').val(rowData.year).change();
            $('#editHonorarium').val(rowData.honorarium_id).change();

            $('#editMonthOf').val(rowData.month.month_number).change(); // Set the month

            //Get Honorarium
            $('#editHonorarium').select2({
                placeholder: 'Select Honorarium',
                allowClear: true
            });
            $.ajax({
                url: '{{ route('getHonorarium') }}',
                type: 'GET',
                success: function(data) {
                    var options = [];
                    data.forEach(function(hono) {
                        options.push({
                            id: hono.id,
                            text: hono.name,
                        });
                    });

                    $('#editHonorarium').select2({
                        data: options
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

        // Handle Save Changes button click
        $('#saveChanges').on('click', function() {
            var rowIndex = $('#editRowIndex').val();
            var row = table.row(rowIndex);

            // Update row data
            var updatedData = {
                date_received: $('#editDateReceived').val(),
                faculty: '<strong class="text-primary">' + $('#editFaculty').val() + '</strong>',
                id_number: '<p class="text-primary">' + $('#editIdNumber').val() + '</p>',
                academic_rank: '<span class="badge bg-label-primary">' + $('#editAcademicRank').val() + '</span>',
                college: $('#editCollege').val(),
                honorarium: $('#editHonorarium').val(),
                semester: '<p class="text-success">' +
                    ($('#editSemester').val() == '1' ? 'First Semester' :
                    ($('#editSemester').val() == '2' ? 'Second Semester' : 'Summer Term')) +
                    '</p>',
                semester_year: $('#editSemesterYear').val(),
                month_of: Object.keys({
                    '0': 'January', '1': 'February', '2': 'March', '3': 'April',
                    '4': 'May', '5': 'June', '6': 'July', '7': 'August',
                    '8': 'September', '9': 'October', '10': 'November', '11': 'December'
                })[$('#editMonthOf').val()],
                action: '<div class="d-flex flex-row"> <button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button><button type="button" class="btn btn-icon me-2 btn-label-danger on-hold-btn"><span class="tf-icons bx bxs-hand bx-18px"></span></button> </div>'
            };

            // Update DataTable
            row.data(updatedData).draw();

            // Hide modal
            $('#editEntryModal').modal('hide');
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

        $('#proceed_transaction').on('click', function() {
        $.ajax({
            url: '{{ route('admin_on_queue.proceedToBudgetOffice') }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),  // Ensure CSRF token is included
            },
            success: function(response) {
                // Handle success (e.g., show a success message using SweetAlert)
                if(response.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                }else{
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
@endsection
