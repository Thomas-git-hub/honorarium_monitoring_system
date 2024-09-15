@extends('components.app')

@section('content')

<!-- PROCEED MODAL START -->
<!-- Modal -->
<div class="modal fade" id="proceed" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="text-secondary">Read</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="text-center text-danger">!</h1>
          <p class="text-center">"Proceeding with this transaction indicates that the individual has submitted all necessary requirements for their honorarium."</p>
          {{-- <h5 class="text-center text-danger">Transaction ID No. = <b>002-08122024</b></h5> --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
          <button type="button" id="proceed_transaction" class="btn btn-primary gap-1">Proceed to Next Office<i class='bx bx-chevrons-right'></i></button>
        </div>
      </div>
    </div>
</div>
{{-- MODAL END --}}


<div class="row mt-4">
    <h4 class="card-title text-secondary">On Hold</h4>
</div>

<div class="row mt-4 gap-3">
    <div class="col-md">
        <div class="card shadow-none bg-label-danger">
            <div class="card-body text-danger">
                <h5 class="card-title text-danger">On Hold Transactions</h5>
                <h1 class="text-danger">{{$OnHold? $OnHold : 0}}</h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
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
    var table = $('#facultyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('on_hold_status') }}',
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

    // $('#facultyTable').on('click', '.edit-btn', function() {
    //     // Get the rowdata.id from the data-id attribute

    //     var row = $(this).closest('tr');
    //     var rowData = table.row(row).data();

    //     var transactionId = rowData.id;
    //     var date = new Date(rowData.created_at);

    //     var formattedDate = (date.getMonth() + 1).toString().padStart(2, '0') + '' +
    //                 date.getDate().toString().padStart(2, '0') + '' +
    //                 date.getFullYear();

    //     console.log(transactionId);
    //     console.log(formattedDate);


    //      // Handle Proceed button click
    //      $('#proceed_transaction').off('click').on('click', function() {
    //         $.ajax({
    //             url: '{{ route('UpdateToProceed') }}',
    //             method: 'POST',
    //             data: {
    //                 _token: $('meta[name="csrf-token"]').attr('content'),
    //                 id:transactionId,
    //             },
    //             success: function(response) {
    //                 if(response.success){
    //                     $('#proceed').modal('hide');
    //                     Swal.fire({
    //                         icon: 'success',
    //                         title: 'Success',
    //                         text: response.message,
    //                     });
    //                 }else{
    //                     $('#proceed').modal('hide');
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Oh no!',
    //                         text: response.message,
    //                     });

    //                 }
    //                 $('#facultyTable').DataTable().ajax.reload();
    //             },
    //             error: function(xhr) {
    //                 // Handle error
    //                 $('#proceed').modal('hide');
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error',
    //                     text: 'There was a problem updating the transactions.',
    //                 });
    //             }
    //         });
    //     });



    //     // Update the modal content (if needed)
    //     // $('#proceed .modal-body').append('<h5 class="text-center text-danger">Transaction ID No. = <b>' + '00' + transactionId + '-' + formattedDate + '</b></h5>');

    //     // You can also update other parts of the modal, if necessary
    //     // For example, if you want to set a hidden input field with the transaction ID:
    //     // $('#proceed').find('input[name="transaction_id"]').val(transactionId);
    // });

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
            <p class="text-center">"Proceeding with this transaction indicates that the individual has submitted all necessary requirements for their honorarium."</p>
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
                        html: '<div class="spinner-border text-primary" role="status"></div>',
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
