@extends('components.app')

@section('content')
    {{-- <div class="row">
        <div class="col">
            <div class="card bg-transparent border-none shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex flex-row gap-3">
                            <div class="row mb-4"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>
                            <h4 class="card-title text-primary">Faculties</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>
                    <div class="text">Faculty:&nbsp;<small class="fw-bold">{{$user->first_name . ' ' . $user->last_name}}</small></div>
                    <div class="text">ID Number:&nbsp;<small class="fw-bold">{{$user->ee_number}}</small></div>
                    <div class="text">Academic Rank:&nbsp;<small class="fw-bold">{{$user->position}}</small></div>
                    <div class="text">College:&nbsp;<small class="fw-bold">{{$college}}</small></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="" class="btn btn-label-primary btn-lg p-4 mb-2 w-100 shadow-sm">
                BUGS Administration
            </a>
            <a href="" class="btn btn-label-secondary btn-lg p-4 mb-2 w-100 shadow-sm">
                Budget Office
            </a>
            <a href="" class="btn btn-label-success btn-lg p-4 mb-2 w-100 shadow-sm">
                Dean Office
            </a>
            <a href="" class="btn btn-label-danger btn-lg p-4 mb-2 w-100 shadow-sm">
                Accounting
            </a>
            <a href="" class="btn btn-label-warning btn-lg p-4 mb-2 w-100 shadow-sm">
                Dean Office
            </a>
            <a href="" class="btn btn-label-info btn-lg p-4 mb-2 w-100 shadow-sm text-secondary">
                Cashier
            </a>
            <a href="" class="btn btn-label-dark btn-lg p-4 mb-2 w-100 shadow-sm">
                Honorarium Released
            </a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card custom-card">
                    <div class="card-body">
                        <p class="text-secondary">Title of Clicked Office Here</p>
                        {{-- <div class="row d-flex flex-column justify-content-start">
                            <h4 class="card-title">BUGS Administration</h4>
                        </div> --}}
                        <div class="table-responsive">
                            <table id="transactionStatusTable" class="table table-borderless" style="width:100%">
                                <tbody class="text-center">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
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
        var data = [
            {
                date_received: '<p>07/26/2024</p>',
                transaction_date: '<p>07/26/2024</p>',
                honorarium: '<p>Honorarium</p>',
                month_of: '<p>June</p>',
                semester: '<p>First Sem</p>',
                semester_year: '<p>2024</p>',
                status: '<p class="text-primary">Processing</p>',
            },
            {
                date_received: '<p>07/26/2024</p>',
                transaction_date: '<p>07/26/2024</p>',
                honorarium: '<p>Honorarium</p>',
                month_of: '<p>June</p>',
                semester: '<p>First Sem</p>',
                semester_year: '<p>2024</p>',
                status: '<p class="text-danger">On Hold</p>',
            },
            // More data...
        ];

        var table = $('#transactionStatusTable').DataTable({
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
                { data: 'transaction_date', name: 'transaction_date', title: 'Transaction Date' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'month_of', name: 'month_of', title: 'month_of' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'semester', name: 'semester', title: 'semester_year' },
                { data: 'status', name: 'status', title: 'Status' },
            ],
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            }
        });
    });
</script>


@endsection
