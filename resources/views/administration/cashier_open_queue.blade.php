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
                <input type="hidden" id="editRowIndex">
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
                            Total Transactions: <b></b>
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
                        <h1 class="text-primary">000-0000</h1>
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
    $(function () {
        var data = [
            {
                batch_id: '000-0000',
                date_of_trans: 'September 17, 2024',
                faculty: 'John Doe',
                id_number: '0000-0000',
                academic_rank: 'lorem ipsum',
                college: 'lorem ipsum',
                honorarium: 'lorem ipsum',
                sem: 'lorem ipsum',
                year: '2024',
                month: 'July',
                created_by: 'John Doe',
                net_amount: '<a href="#" class="netAmountButton"><span class="badge btn btn-success">Enter Net Amount</span></a>',
            },
            // Add more objects as needed
        ];

        var table = $('#cashierOpenQueueTable').DataTable({
            processing: true,
            serverSide: false, // Set serverSide to false to use local data
            data: data,        // Provide the local data
            pageLength: 10,
            paging: true,      // Enable pagination

            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'Tracking Number' },
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
                { data: 'net_amount', name: 'net_amount', title: 'Net Amount' }
            ],
        });

        // Handle the click event for the netAmountButton
        $('#cashierOpenQueueTable tbody').on('click', '.netAmountButton', function (e) {
            e.preventDefault();
            var $this = $(this); // The button clicked
            var $row = $this.closest('td'); // Get the parent cell

            // Replace the button with an input field
            var inputField = $('<input>', {
                type: 'text',
                class: 'form-control netAmountInput',
                placeholder: 'Enter amount'
            });

            $row.html(inputField);

            // Add validation for the input field
            inputField.on('input', function () {
                var value = $(this).val();
                // Check if the value is a valid number with optional decimal places
                var isValid = /^\d*\.?\d+$/.test(value);
                if (!isValid) {
                    // If invalid, add an error class or message
                    $(this).addClass('is-invalid');
                } else {
                    // If valid, remove the error class
                    $(this).removeClass('is-invalid');
                }
            });

            // Optionally, handle losing focus (blur) to save the value or revert
            inputField.on('blur', function () {
                var value = $(this).val();
                var isValid = /^\d*\.?\d+$/.test(value);
                if (isValid) {
                    // Replace input with a success button showing the entered amount
                    $row.html('<span class="badge btn btn-info">' + value + '</span>');
                } else {
                    // Revert to the original button if invalid
                    $row.html('<a href="#" class="netAmountButton"><span class="badge btn btn-success">Enter Net Amount</span></a>');
                }
            });
        });
    });
</script>

{{-- DATATABLES END--}}



@endsection
