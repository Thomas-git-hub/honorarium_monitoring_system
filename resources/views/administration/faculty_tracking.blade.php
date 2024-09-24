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
            <button type="button" class="btn-label-primary text-primary nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-administration" aria-controls="navs-pills-justified-home" aria-selected="true">
                <span class="d-none d-sm-block">
                    <i class="tf-icons bx bxs-home bx-sm me-1_5 align-text-bottom"></i>
                    BUGS Admin
                    <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">3</span>
                </span>
                <i class="bx bxs-home bx-sm d-sm-none"></i>
            </button>
        </li>

        <li class="nav-item mb-1 mb-sm-0">
            <button type="button" class="btn-label-secondary text-secondary nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-budget" aria-controls="navs-pills-justified-profile" aria-selected="false">
                <span class="d-none d-sm-block">
                    <i class="tf-icons bx bxs-coin bx-sm me-1_5 align-text-bottom"></i>
                    Budget Office
                    <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">3</span>
                </span>
                <i class="bx bxs-coin bx-sm d-sm-none"></i>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn-label-success text-success nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-dean1" aria-controls="navs-pills-justified-messages" aria-selected="false">
                <span class="d-none d-sm-block">
                    <i class="tf-icons bx bxs-graduation bx-sm me-1_5 align-text-bottom"></i>
                    Deans Office
                    <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">3</span>
                </span>
                <i class="bx bxs-graduation bx-sm d-sm-none"></i>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn-label-danger text-danger nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-accounting" aria-controls="navs-pills-justified-messages" aria-selected="false">
                <span class="d-none d-sm-block">
                    <i class="tf-icons bx bxs-calculator bx-sm me-1_5 align-text-bottom"></i>
                    Accounting
                    <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">3</span>
                </span>
                <i class="bx bxs-calculator bx-sm d-sm-none"></i>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn-label-warning text-warning nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-dean2" aria-controls="navs-pills-justified-messages" aria-selected="false">
                <span class="d-none d-sm-block"><i class="tf-icons bx bxs-graduation bx-sm me-1_5 align-text-bottom"></i>
                    Deans Office
                    <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">3</span>
                </span>
                <i class="bx bxs-graduation bx-sm d-sm-none"></i>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn-label-info text-info nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-cashier" aria-controls="navs-pills-justified-messages" aria-selected="false">
                <span class="d-none d-sm-block">
                    <i class="tf-icons bx bxs-credit-card-alt bx-sm me-1_5 align-text-bottom"></i>
                    Cashier
                    <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">3</span>
                </span>
                <i class="bx bxs-credit-card-alt bx-sm d-sm-none"></i>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn-label-dark text-dark nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-releasing" aria-controls="navs-pills-justified-messages" aria-selected="false">
                <span class="d-none d-sm-block"><i class="tf-icons bx bxs-bank bx-sm me-1_5 align-text-bottom"></i>
                    Releasing
                    <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">3</span>
                </span>
                <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
            </button>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-justified-administration" role="tabpanel">
            <p class="text-secondary" id="office-title">BUGS Administration</p>
            <div class="table-responsive">
                <table id="administrationTrackingTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
                    <tbody class="text-center">
                        <!-- Data will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-budget" role="tabpanel">
            <p class="text-secondary" id = "office-title">Budget Office</p>
            <div class="table-responsive">
                <table id="budgetTrackingTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
                    <tbody class="text-center">
                        <!-- Data will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-dean1" role="tabpanel">
            <p class="text-secondary" id = "office-title">Deans Office</p>
            <div class="table-responsive">
                <table id="dean1TrackingTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
                    <tbody class="text-center">
                        <!-- Data will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-accounting" role="tabpanel">
            <p class="text-secondary" id = "office-title">Accounting</p>
            <div class="table-responsive">
                <table id="accountingTrackingTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
                    <tbody class="text-center">
                        <!-- Data will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-dean2" role="tabpanel">
            <p class="text-secondary" id = "office-title">Deans Office</p>
            <div class="table-responsive">
                <table id="dean2TrackingTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
                    <tbody class="text-center">
                        <!-- Data will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-cashier" role="tabpanel">
            <p class="text-secondary" id = "office-title">Cashier</p>
            <div class="table-responsive">
                <table id="cashierTrackingTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
                    <tbody class="text-center">
                        <!-- Data will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-releasing" role="tabpanel">
            <p class="text-secondary" id = "office-title">Releasing</p>
            <div class="table-responsive">
                <table id="releasingTrackingTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
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
    // BUGS ADMINISTRATION TRACKING TABLE
    var sampleData = [
        {
            batch_id:'000-0000',
            recieve: 'Sept 23',
            transact: 'Sept 23',
            honorarium: 'Honorarium 1',
            month_of: 'January',
            semester: 'First Sem',
            year: '2023',
            status: 'On-hold'
        },
        {
            batch_id:'000-0000',
            recieve: 'Sept 23',
            transact: 'Sept 23',
            honorarium: 'Honorarium 2',
            month_of: 'February',
            semester: 'First Sem',
            year: '2023',
            status: 'Processing'
        },
        {
            batch_id:'000-0000',
            recieve: 'Sept 23',
            transact: 'Sept 23',
            honorarium: 'Honorarium 3',
            month_of: 'March',
            semester: 'First Sem',
            year: '2023',
            status: 'Processing'
        }
    ];

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
    var sampleData = [
            {
                batch_id: '000-0000',
                recieve: 'Sept 23',
                transact: 'Sept 23',
                honorarium: 'Honorarium 1',
                month_of: 'January',
                semester: 'First Sem',
                year: '2023',
                status: 'On-hold'
            },
            {
                batch_id: '000-0000',
                recieve: 'Sept 23',
                transact: 'Sept 23',
                honorarium: 'Honorarium 2',
                month_of: 'February',
                semester: 'First Sem',
                year: '2023',
                status: 'Processing'
            },
            {
                batch_id: '000-0000',
                recieve: 'Sept 23',
                transact: 'Sept 23',
                honorarium: 'Honorarium 3',
                month_of: 'March',
                semester: 'First Sem',
                year: '2023',
                status: 'Processing'
            }
        ];

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
        var sampleData = [
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 1',
                    month_of: 'January',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'On-hold'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 2',
                    month_of: 'February',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'Processing'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 3',
                    month_of: 'March',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'Processing'
                }
            ];

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
        var sampleData = [
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 1',
                    month_of: 'January',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'On-hold'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 2',
                    month_of: 'February',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'Processing'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 3',
                    month_of: 'March',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'Processing'
                }
            ];

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
        var sampleData = [
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 1',
                    month_of: 'January',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'On-hold'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 2',
                    month_of: 'February',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'Processing'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 3',
                    month_of: 'March',
                    semester: 'First Sem',
                    year: '2023',
                    status: 'Processing'
                }
            ];

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
        var sampleData = [
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 1',
                    month_of: 'January',
                    semester: 'First Sem',
                    year: '2023',
                    amount: '30,000',
                    status: 'On-hold'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 2',
                    month_of: 'February',
                    semester: 'First Sem',
                    year: '2023',
                    amount: '30,000',
                    status: 'Processing'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 3',
                    month_of: 'March',
                    semester: 'First Sem',
                    year: '2023',
                    amount: '30,000',
                    status: 'Processing'
                }
            ];

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
        var sampleData = [
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 1',
                    month_of: 'January',
                    semester: 'First Sem',
                    year: '2023',
                    amount: '30,000',
                    status: 'On-hold'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 2',
                    month_of: 'February',
                    semester: 'First Sem',
                    year: '2023',
                    amount: '30,000',
                    status: 'Processing'
                },
                {
                    batch_id: '000-0000',
                    recieve: 'Sept 23',
                    transact: 'Sept 23',
                    honorarium: 'Honorarium 3',
                    month_of: 'March',
                    semester: 'First Sem',
                    year: '2023',
                    amount: '30,000',
                    status: 'Processing'
                }
            ];

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





</script>


@endsection
