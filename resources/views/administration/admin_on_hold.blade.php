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
                <div>Faculty: <b id="faculty">-</b></div>
                <div>College: <b id="college">-</b></div>
                <div>Academic Rank: <b id="rank">-</b></div>
            </div>
            <div class="mt-3">
                <input type="hidden" id="id" name="id" placeholder="" class="form-control">
                <input type="text" id="modalDatePicker" placeholder="yyyy/mm/dd" class="form-control">
            </div>
        </div>

      </div>
    </div>
  </div>


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
                            Transact by: <b>{{$OnHoldData->createdBy->first_name. ' ' .$OnHoldData->createdBy->middle_name. ' ' .$OnHoldData->createdBy->last_name}}</b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-danger">
                            Office Of: <b>{{$office->name}}</b>
                        </div>
                    </div>
                </div>


                <div class="card shadow-none bg-label-danger">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Tracking Number:</h5>
                        {{-- <h1 class="text-primary">{{$onQueue}}</h1> --}}
                        <h1 class="text-danger">{{$OnHoldData->batch_id ?? '000-0000'}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@if(Auth::user()->office_id === $OnHoldData->createdBy->office_id)

<div class="row mb-3">
    <div class="col-md mx-auto d-flex justify-content-end">
        <button type="button" class="btn btn-primary gap-1 ProceedAcknowledge " id="ProceedAcknowledge">Proceed Transaction<i class='bx bx-chevrons-right'></i></button>
    </div>
</div>

@endif

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

<script>

    var batchId = {!! json_encode($OnHoldData->batch_id) !!};
    var User = {!! json_encode(Auth::user()) !!};
    // Initialize DataTable
    var table = $('#facultyTable').DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        ajax: {
            url: '{{ route('on_hold_status') }}',
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
            { data: 'id', name: 'id', title: 'ID', visible: false },
            { data: 'created_by_office', name: 'created_by_office', title: 'created_by_office', visible: false },
            { data: 'batch_id', name: 'batch_id', title: 'TN' },
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
            { data: 'sent', name: 'sent', title: 'Sent' },
            { data: 'requirement_status', name: 'requirement_status', title: 'Requirements' },
            @if(Auth::user()->office_id === $OnHoldData->createdBy->office_id)

            {
                data: 'complied_on',
                name: 'complied_on',
                title: 'Complied On',
                render: function (data, type, row) {
                    var buttonTitle = data ? data : 'Select Date';

                    // Check if current user’s office matches the transaction office and the status is 'Processing'
                    var isDisabled = ( row.status === 'Processing') ? 'disabled' : '';

                    // Generate the button, disabling it if the conditions are met
                    var addButton = '<button type="button" id="compliedOn" class="btn btn-sm btn-primary compliedOnBtn" ' + isDisabled + '><span class="badge">' + buttonTitle + '</button>';

                    return '<div class="d-flex flex-row" data-id="' + row.id + '">' + addButton + '</div>';
                }
            }
            @else
                { data: 'complied_on', name: 'complied_on', title: 'Complied On' },

            @endif

        ],
        order: [[0, 'desc']], // Sort by the first column by default
        createdRow: function(row, data) {
            $(row).addClass('unopened');
        },
    });

    var datePicker = flatpickr("#modalDatePicker", {
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr) {
            // Update the button's text after selecting a date
            var transactionId = $('#id').val();
            console.log(transactionId);
            var button = $('#datePickerModal').data('button');
            button.find('span.badge').text(dateStr); // Update the button's text
            $('#datePickerModal').modal('hide'); // Hide the modal

            // AJAX request to update the complied_on field
            $.ajax({
                url: "{{ route('update.complied.on') }}",  // Route to handle update
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",   // CSRF token for security
                    id: transactionId,  // ID of the transaction
                    complied_on: dateStr            // Selected date
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        table.ajax.reload();
                    } else {
                        alert("Failed to update the date. Please try again.");
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("An error occurred. Please try again.");
                }
            });
        }
    });

    // Show the modal when compliedOn button is clicked
    $('#facultyTable').on('click', '.compliedOnBtn', function() {
        var button = $(this);
        var row = $(this).closest('tr');
        var rowData = table.row(row).data();
        console.log(rowData);

            $('#id').val(rowData.id);
            $('#faculty').text(rowData.faculty);
            $('#office').text(rowData.office);
            $('#position').text(rowData.position);
            $('#email').text(rowData.email);
            $('#contact').text(rowData.contact);
            $('#college').text(rowData.college);
            $('#id_num').text(rowData.ee_number);
            $('#netAmount').val(rowData.netAmount);

        $('#datePickerModal').data('button', button).modal('show');
    });

    $('#ProceedAcknowledge').off('click').on('click', function() {
        $.ajax({
            url: '{{ route('proceed_on_hold') }}',
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
                        title: 'Success',
                        text: response.message,
                    });
                    $('#facultyTable').DataTable().ajax.reload();
                    // $('#proceed').modal('show');
                    // @if(Auth::user()->usertype->name === 'Cashiers')
                    // window.location.href = `/cashier_in_queue`;
                    // @else
                    // window.location.href = `/admin_on_queue`;
                    // @endif

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oh no!',
                        text: response.message,
                    });
                    $('#facultyTable').DataTable().ajax.reload();
                    // $('#proceed').modal('hide');
                }


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



    // Optionally, you can reset the modal content when it's closed
    // $('#proceed').on('hidden.bs.modal', function() {
    //     $(this).find('.modal-body h5').remove();
    // });

</script>


@endsection
