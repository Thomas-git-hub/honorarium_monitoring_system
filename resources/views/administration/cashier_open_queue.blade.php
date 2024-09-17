@extends('components.app')

@section('content')

<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Net Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            Full Name:
                        </div>
                        <div class="col-md-8">
                            <b>John Doe</b>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            Email:
                        </div>
                        <div class="col-md-8">
                            <b>lorem@bicol-u.edu.ph</b>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            Academic Rank:
                        </div>
                        <div class="col-md-8">
                            <b>Lorem Ipsum</b>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            Mother College:
                        </div>
                        <div class="col-md-8">
                            <b>College of Ipsum</b>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-4">
                            Contact Number:
                        </div>
                        <div class="col-md-8">
                            <b>09156748573</b>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-1">
                            <label for="defaultFormControlInput" class="form-label text-primary">Total Net Amount</label>
                            <input type="text" class="form-control" id="netAmount" placeholder="₱" aria-describedby="defaultFormControlHelp" />
                            <div id="netAmountHelp" class="form-text text-danger">Enter the exact net amount and be sure to double-check the amount entered.</div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addButton">Add Net Amount</button>
                    <button type="button" class="btn btn-label-danger" id="closeB" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
{{-- <script>
    $(document).ready(function() {
        var table = $('#cashierOpenQueueTable').DataTable({
            processing: true,
            serverSide: false,
            data: [
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
                    net_amount: '<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>',
                }
                // Add more objects as needed
            ],
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
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

        $('#exampleModal').on('hidden.bs.modal', function () {
            var netAmount = $('#netAmount').val().trim();
            var isValidAmount = /^[0-9]+(\.[0-9]{1,2})?$/.test(netAmount);

            if (isValidAmount) {
                var formattedAmount = `<b>₱${parseFloat(netAmount).toFixed(2)}</b>`;

                // Update the DataTable with the new amount
                table.column(11).data().each(function (value, index) {
                    if (value.includes('Add')) {
                        table.cell(index, 11).data(formattedAmount).draw();
                    }
                });
            } else {
                alert('Please enter a valid amount with up to two decimal places.');
            }
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        var table = $('#cashierOpenQueueTable').DataTable({
            processing: true,
            serverSide: false,
            data: [
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
                    net_amount: '<button type="button" class="btn btn-sm btn-primary" id="" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>',
                }
                // Add more objects as needed
            ],
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
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

        // Function to handle adding the net amount to the table
        function addNetAmount() {
            var netAmount = $('#netAmount').val().trim();
            var isValidAmount = /^[0-9]+(\.[0-9]{1,2})?$/.test(netAmount);

            if (isValidAmount) {
                var formattedAmount = `<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">₱${parseFloat(netAmount).toFixed(2)}</button>`;

                // Update the DataTable with the new amount
                table.column(11).data().each(function (value, index) {
                    if (value.includes('Add')) {
                        table.cell(index, 11).data(formattedAmount).draw();
                    }
                });

                // Close the modal
                $('#exampleModal').modal('hide');
            } else {
                alert('Please enter a valid amount with up to two decimal places.');
            }
        }

        // Add button click event
        $('#addButton').on('click', addNetAmount);

        // Enter key press event in the modal
        $('#netAmount').on('keypress', function (e) {
            if (e.which == 13) { // Enter key pressed
                e.preventDefault(); // Prevent the default form submission
                addNetAmount(); // Call the addNetAmount function
            }
        });

        // Close button click event
        $('#closeButton').on('click', function() {
            // Clear the input field
            $('#netAmount').val('');

            // Reload the page
            location.reload();
        });

        // Validate input for the #netAmount field to accept only numbers and decimals
        $('#netAmount').on('input', function () {
            var value = $(this).val();
            // Remove any invalid characters (letters and special symbols except decimal point)
            var validValue = value.replace(/[^0-9.]/g, '');
            // Ensure only one decimal point is allowed
            var decimalCount = (validValue.match(/\./g) || []).length;
            if (decimalCount > 1) {
                validValue = validValue.replace(/\.(?=.*\.)/g, '');
            }
            $(this).val(validValue);
        });
    });
</script>




@endsection
