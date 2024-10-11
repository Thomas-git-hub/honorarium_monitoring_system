@extends('components.app')

@section('content')

  <!-- Modal -->
  <div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex align-items-center gap-2">
            <i class='bx bx-calendar-event' ></i>
            <span class="h6 mb-0 modal-title">Select Date of Compliance</span>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="border-bottom">
                <div>Faculty: <b>Full Name</b></div>
                <div>College: <b>College</b></div>
                <div>Academic Rank: <b>Full Time</b></div>
            </div>
            <div class="mt-3">
                {{-- <label for="defaultFormControlInput" class="form-label">Select Date of Compliance</label> --}}
                <input type="text" id="modalDatePicker" placeholder="yyyy/mm/dd" class="form-control">
            </div>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Requirements Complied</button>
        </div> --}}
      </div>
    </div>
  </div>

    {{-- <div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="datePickerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="datePickerModalLabel">Select a Date</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <!-- Hidden input for Flatpickr -->
                    <input type="text" id="modalDatePicker" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

<div class="row mt-4 mb-3">
    <div class="col-md">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="mb-3"><a href="/main_on_hold" class=""><i class='bx bx-left-arrow-alt text-primary' id="" style="font-size: 2em; cursor: pointer;"></i></a></div>

                <h4 class="d-flex align-items-center"><i class='bx bx-list-ul'  style="font-size: 32px;"></i>Batch Transaction Details</h4>
                <div class="row">
                    <div class="col-md">
                        <div class="alert alert-danger">
                            On-Hold Transaction: <b>{{$OnHold? $OnHold : 0}}</b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-danger">
                            Transact by: <b>Full Name</b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-danger">
                            Office Of: <b>Office Name</b>
                        </div>
                    </div>
                </div>


                <div class="card shadow-none bg-label-danger">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Tracking Number:</h5>
                        {{-- <h1 class="text-primary">{{$onQueue}}</h1> --}}
                        <h1 class="text-danger">000-0000</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md mx-auto d-flex justify-content-end">
        <button type="button" class="btn btn-primary gap-1 ProceedAcknowledge " id="ProceedAcknowledge">Proceed Transaction<i class='bx bx-chevrons-right'></i></button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card custom-card border border-danger">
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
{{-- <script>
    $(function () {
        var data = [
            {
                date_received: '<p>07/27/2024</p>',
                date_on_hold: '<p class="text-danger">07/27/2024</p>',
                faculty: '<p class="text-primary">John Doe</p>',
                id_number: '<p class="text-primary">1-id-no-2024</p>',
                academic_rank: '<span class="badge bg-label-primary">Associate Professor II</span>',
                college: '<p>College of Arts</p>',
                honorarium: '<p>honorarium here</p>',
                semester: '<p class="text-success">First Semester</p>',
                semester_year: '<p>2024</p>',
                month_of: '<p>July</p>',
                action: '<button type="button" class="btn me-2 btn-primary btn-sm edit-btn gap-1" data-bs-toggle="modal" data-bs-target="#proceed">Proceed<i class="bx bx-chevrons-right"></i></button>',
            },
            // More data...
        ];

        var table = $('#facultyTable').DataTable({
            data: data,
            processing: false,
            serverSide: false,
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            columns: [
                { data: 'date_received', name: 'date_received', title: 'Date Received' },
                { data: 'date_on_hold', name: 'date_on_hold', title: 'Date On Hold' },
                { data: 'faculty', name: 'faculty', title: 'Faculty' },
                { data: 'id_number', name: 'id_number', title: 'ID Number' },
                { data: 'academic_rank', name: 'academic_rank', title: 'Academic Rank' },
                { data: 'college', name: 'college', title: 'College' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'semester_year', name: 'semester_year', title: 'Semester Year' },
                { data: 'month_of', name: 'month_of', title: 'Month Of' },
                { data: 'action', name: 'action', title: 'Action' }
            ],
        });
    });
</script> --}}

<script>
    var data = [
            {
                id: '<p>000-000</p>',
                batch_id: '<p class="text-primary">000-000</p>',
                date_of_trans: 'Oct 10, 2024',
                faculty: '<p class="text-primary">Full Name</p>',
                id_number: '000-00000',
                academic_rank: '<p>Part Timer</p>',
                college: '<p>College of Arts</p>',
                honorarium: '<span class="badge bg-label-primary">Honorarium</span>',
                sem: '<p>First</p>',
                year: '<p>2024</p>',
                month: 'October',
                created_by: '<p>Full Name</p>',
                sent: '3 days ago',
                requirement_status: 'For Compliance',
                complied_on: '<button type="button" id="compliedOn" class="btn btn-sm btn-primary compliedOnBtn"><span class="badge">Select Date</button>',
            },
            // More data...
        ];

        // Initialize DataTable
        var table = $('#facultyTable').DataTable({
            data: data,
            processing: false,
            serverSide: false,
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            columns: [
                { data: 'id', name: 'id', title: 'ID', visible: false },
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
                { data: 'date_of_trans', name: 'date_of_trans', title: 'Date Received' },
                { data: 'faculty', name: 'faculty', title: 'Faculty' },
                { data: 'id_number', name: 'id_number', title: 'ID Number' },
                { data: 'academic_rank', name: 'academic_rank', title: 'Academic Rank' },
                { data: 'college', name: 'college', title: 'College' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'sem', name: 'sem', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Semester Year' },
                { data: 'month', name: 'month', title: 'Month Of' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                { data: 'sent', name: 'sent', title: 'Sent' },
                { data: 'requirement_status', name: 'requirement_status', title: 'Requirements' },
                { data: 'complied_on', name: 'complied_on', title: 'Complied On' },
            ],
            order: [[0, 'desc']], // Sort by the first column by default
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            },
        });




        // Initialize Flatpickr in the modal
        var datePicker = flatpickr("#modalDatePicker", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr) {
                // Update the button's text after selecting a date
                var button = $('#datePickerModal').data('button');
                button.find('span.badge').text(dateStr); // Update the button's text
                $('#datePickerModal').modal('hide'); // Hide the modal
            }
        });

        // Show the modal when compliedOn button is clicked
        $('#facultyTable').on('click', '.compliedOnBtn', function() {
            var button = $(this);
            // Store the clicked button in a data attribute for use in the modal
            $('#datePickerModal').data('button', button).modal('show');
        });

    $('#facultyTable').on('click', '.edit-btn', function() {
    // Get the row data
    var row = $(this).closest('tr');
    var rowData = table.row(row).data();

    var transactionId = rowData.id;
    var date = new Date(rowData.created_at);

    var formattedDate = (date.getMonth() + 1).toString().padStart(2, '0') + '' +
                date.getDate().toString().padStart(2, '0') + '' +
                date.getFullYear();

    console.log(transactionId);
    console.log(formattedDate);

    // Trigger SweetAlert instead of Bootstrap modal
    Swal.fire({
        icon: 'question',
        html: `
            <p class="text-center">"Proceeding with this transaction indicates that the individual has complied with all necessary requirements for their honorarium."</p>
        `,
        showCancelButton: true,
        confirmButtonText: 'Proceed to Next Office',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-primary gap-1',
            cancelButton: 'btn btn-label-danger'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Trigger AJAX call when "Proceed" is confirmed
            $.ajax({
                url: '{{ route('UpdateToProceed') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: transactionId, // Transaction ID
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
                    Swal.close(); // Close the processing alert
                    if(response.success){
                        var batchID = response.batchId;
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaction forwarded successfully.',
                            html: `<h4 class="text-success">Tracking Number: <b>${response.batch_id}</b></h4><small class="text-danger">Note: Always attach the tracking number on the documents.</small>`,
                            text: response.message,
                        }).then(() => {
                            // Reload the page after the success SweetAlert is closed
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oh no!',
                            text: response.message,
                        });
                    }
                    // Reload DataTable after the transaction
                    $('#facultyTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    // Handle error
                    Swal.close(); // Close the processing alert
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



    // Optionally, you can reset the modal content when it's closed
    // $('#proceed').on('hidden.bs.modal', function() {
    //     $(this).find('.modal-body h5').remove();
    // });

</script>


@endsection
