@extends('components.app')

@section('content')

<div class="row mt-4">
    <div class="col">
        <div class="row d-flex flex-column justify-content-start">
            <h4 class="card-title">Track and Monitor Honorarium</h4>
        </div>
    </div>
</div>

<div class="col-md mt-4">
    {{-- <h6 class="text-muted">Offices</h6> --}}
    <div class="nav-align-top mb-6">
        <ul class="nav nav-pills nav-fill d-flex flex-nowrap overflow-auto mb-3 gap-2" id="ul-scroll" role="tablist">
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="btn-label-primary text-primary nav-link office-btn" data-route="{{ route('faculty.bugs') }}" role="tab" aria-selected="true">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-home bx-sm me-1_5 align-text-bottom"></i>
                        BUGS Admin
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$adminCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="btn-label-secondary text-secondary nav-link office-btn" data-route="{{ route('faculty.budget-office') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-coin bx-sm me-1_5 align-text-bottom"></i>
                        Budget Office
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$budgtCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-success text-success nav-link office-btn" data-route="{{ route('faculty.dean_office') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-graduation bx-sm me-1_5 align-text-bottom"></i>
                        Deans Office
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$deanCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-danger text-danger nav-link office-btn" data-route="{{ route('faculty.accounting') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-calculator bx-sm me-1_5 align-text-bottom"></i>
                        Accounting
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$acctCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-warning text-warning nav-link office-btn" data-route="{{ route('faculty.dean_office_two') }}" role="tab">
                    <span class="d-none d-sm-block"><i class="tf-icons bx bxs-graduation bx-sm me-1_5 align-text-bottom"></i>
                        Deans Office
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$deanCountTwo ?? 0}}</span>
                    </span>
                    <i class="bx bxs-graduation bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-info text-info nav-link office-btn" data-route="{{ route('faculty.cashier') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-credit-card-alt bx-sm me-1_5 align-text-bottom"></i>
                        Cashier
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$cashCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-dark text-dark nav-link office-btn" data-route="{{ route('faculty.honorarium_released') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-bank bx-sm me-1_5 align-text-bottom"></i>
                        Releasing
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$releaseCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-administration" role="tabpanel">
                <p class="text-secondary" id="office-title"></p>
                <div class="table-responsive">
                    <table id="transactionStatusTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
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




{{-- .|.(^-^).|. --}}




@section('components.specific_page_scripts')

<script>

    $(function () {
        var user_id = {!! json_encode($user->employee_id) !!}; // Retrieve user ID
        console.log(user_id);

        var table = $('#transactionStatusTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('faculty.bugs') }}', // Default URL for the first load
                data: function(d) {
                    d.user_id = user_id; // Send user ID in request
                }
            },
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search...",
                emptyTable: "No data found for this office."
            },
            columns: [
                { data: 'id', name: 'id', title: 'ID', visible: false },
                { data: 'batch_id', name: 'batch_id', title: 'Trans Batch ID No.' },
                { data: 'date_received', name: 'date_received', title: 'Date Received' },
                { data: 'transaction_date', name: 'transaction_date', title: 'Transaction Date' },
                {
                    data: 'honorarium',
                    name: 'honorarium',
                    title: 'Honorarium',
                    render: function(data) {
                        return '<span class="badge rounded-pill bg-warning">' + data + '</span>';
                    }
                },
                { data: 'month.month_name', name: 'month', title: 'Month Of' },
                { data: 'sem', name: 'sem', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Year' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            }
        });

        // Handle button clicks for dynamic routes
        $('.office-btn').on('click', function(e) {
            e.preventDefault();
            var route = $(this).data('route'); // Get the route from the clicked button
            var officeTitle = $(this).text(); // Get the button text for the title display

            // Update the DataTable AJAX URL dynamically based on the clicked button
            table.ajax.url(route).load();

            // Update the office title
            $('#office-title').text(officeTitle);
        });

        // Automatically trigger the first button click to load the default route
        $('.office-btn').first().trigger('click');
    });
</script>


{{-- <script>


    var table = $('#administrationTrackingTable').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 100,
        paging: false, // Disable pagination
        dom: '<"top"f>rt<"bottom"ip>',
        language: {
            search: "", // Remove the default search label
            searchPlaceholder: "Search..." // Set the placeholder text
        },
        data: sampleData,
        columns: [
            { data: 'batch_id', name: 'batch_id', title: 'TN' },
            { data: 'recieve', name: 'recieve', title: 'Recieved' },
            { data: 'transact', name: 'transact', title: 'Transact' },
            { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
            { data: 'month_of', name: 'month_of' , title: 'Month Of' },
            { data: 'semester', name: 'semester', title: 'Semester' },
            { data: 'year', name: 'year', title: 'Year' },
            { data: 'status', name: 'status', title: 'Status' },
        ],
    });


    // BUdGET OFFICE TRACKING TABLE
        var table = $('#budgetTrackingTable').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 100,
            paging: false, // Disable pagination
            dom: '<"top"f>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            data: sampleData,
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
                { data: 'recieve', name: 'recieve', title: 'Recieved' },
                { data: 'transact', name: 'transact', title: 'Transact' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'month_of', name: 'month_of' , title: 'Month Of' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Year' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
        });


        // DEAN OFFICE 1 TRACKING TABLE
        var table = $('#dean1TrackingTable').DataTable({
                    processing: true,
            serverSide: false,
            pageLength: 100,
            paging: false, // Disable pagination
            dom: '<"top"f>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            data: sampleData,
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
                { data: 'recieve', name: 'recieve', title: 'Recieved' },
                { data: 'transact', name: 'transact', title: 'Transact' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'month_of', name: 'month_of' , title: 'Month Of' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Year' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
        });

        // ACCOUNTING TRACKING TABLE
        var table = $('#accountingTrackingTable').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 100,
            paging: false, // Disable pagination
            dom: '<"top"f>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            data: sampleData,
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
                { data: 'recieve', name: 'recieve', title: 'Recieved' },
                { data: 'transact', name: 'transact', title: 'Transact' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'month_of', name: 'month_of' , title: 'Month Of' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Year' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
        });


        // DEANS OFFICE 2 TRACKING TABLE
        var table = $('#dean2TrackingTable').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 100,
            paging: false, // Disable pagination
            dom: '<"top"f>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            data: sampleData,
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
                { data: 'recieve', name: 'recieve', title: 'Recieved' },
                { data: 'transact', name: 'transact', title: 'Transact' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'month_of', name: 'month_of' , title: 'Month Of' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Year' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
        });

        // CASHIER TRACKING TABLE
        var table = $('#cashierTrackingTable').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 100,
            paging: false, // Disable pagination
            dom: '<"top"f>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            data: sampleData,
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
                { data: 'recieve', name: 'recieve', title: 'Recieved' },
                { data: 'transact', name: 'transact', title: 'Transact' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'month_of', name: 'month_of' , title: 'Month Of' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Year' },
                { data: 'amount', name: 'amount', title: 'Amount' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
        });


        // RELEASING TRACKING TABLE
        var table = $('#releasingTrackingTable').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 100,
            paging: false, // Disable pagination
            dom: '<"top"f>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            data: sampleData,
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
                { data: 'recieve', name: 'recieve', title: 'Recieved' },
                { data: 'transact', name: 'transact', title: 'Transact' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'month_of', name: 'month_of' , title: 'Month Of' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'year', name: 'year', title: 'Year' },
                { data: 'amount', name: 'amount', title: 'Amount' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
        });





</script> --}}


@endsection
