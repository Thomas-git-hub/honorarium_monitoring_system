@extends('components.app')

@section('content')

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
            <a href="javascript:void(0)" id="bugsAdminBtn" class="btn btn-label-primary btn-lg p-4 mb-2 w-100 shadow-sm office-btn" data-route="{{ route('faculty.bugs') }}">
                BUGS Administration
            </a>
            <a href="javascript:void(0)" class="btn btn-label-secondary btn-lg p-4 mb-2 w-100 shadow-sm office-btn" data-route="{{ route('faculty.budget-office') }}">
                Budget Office
            </a>
            <a href="javascript:void(0)" class="btn btn-label-success btn-lg p-4 mb-2 w-100 shadow-sm office-btn" data-route="{{ route('faculty.dean_office') }}">
                Dean Office
            </a>
            <a href="javascript:void(0)" class="btn btn-label-danger btn-lg p-4 mb-2 w-100 shadow-sm office-btn" data-route="{{ route('faculty.accounting') }}">
                Accounting
            </a>
            {{-- <a href="javascript:void(0)" class="btn btn-label-warning btn-lg p-4 mb-2 w-100 shadow-sm office-btn" data-route="{{ route('faculty.dean_office') }}">
                Dean Office
            </a> --}}
            <a href="javascript:void(0)" class="btn btn-label-info btn-lg p-4 mb-2 w-100 shadow-sm office-btn" data-route="{{ route('faculty.cashier') }}">
                Cashier
            </a>
            <a href="javascript:void(0)" class="btn btn-label-dark btn-lg p-4 mb-2 w-100 shadow-sm office-btn" data-route="{{ route('faculty.honorarium_released') }}">
                Honorarium Released
            </a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card custom-card">
                    <div class="card-body">
                        <p class="text-secondary" id = "office-title">Title of Clicked Office Here</p>
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
            var user_id = {!! json_encode($user->employee_id) !!}; // Retrieve user ID
            console.log(user_id);
            var table = $('#transactionStatusTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('faculty.bugs') }}', // Default empty, it will change based on the button click
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
                    { data: 'transaction_date', name: 'transaction_date', title: 'transaction_date' },
                    {
                        data: 'honorarium',
                        name: 'honorarium',
                        title: 'Honorarium',
                        render: function(data, type, row) {
                            return '<span class="badge rounded-pill bg-warning">' + data + '</span>';
                        }
                    },
                    { data: 'month.month_name', name: 'month', title: 'Month Of' },
                    { data: 'sem', name: 'sem', title: 'Semester' },
                    { data: 'year', name: 'year', title: 'Semester Year' },
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

            $('#bugsAdminBtn').first().trigger('click');
        });
</script>


@endsection
