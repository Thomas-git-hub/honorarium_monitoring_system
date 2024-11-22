@extends('components.app')

@section('content')

<div class="row mt-4">
    <div class="col">
        <div class="row d-flex flex-column justify-content-start">
            <h4 class="card-title">Track and Monitor Thesis</h4>
        </div>
    </div>
</div>

<div class="col-md mt-4">
    {{-- <h6 class="text-muted">Offices</h6> --}}
    <div class="nav-align-top mb-6">
        <ul class="nav nav-pills nav-fill d-flex flex-nowrap overflow-auto mb-3 gap-2" id="ul-scroll" role="tablist">
            <li class="nav-item">
                <button type="button" class="btn-label-success text-success nav-link office-btn" data-route="{{ route('thesis.dean_office.new-entries') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-graduation bx-sm me-1_5 align-text-bottom"></i>
                        Deans Office
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$initialDeanCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="btn-label-primary text-primary nav-link office-btn" data-route="{{ route('thesis.bugs') }}" role="tab" aria-selected="true">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-home bx-sm me-1_5 align-text-bottom"></i>
                        BUGS Admin
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$adminCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="btn-label-secondary text-secondary nav-link office-btn" data-route="{{ route('thesis.budget-office') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-coin bx-sm me-1_5 align-text-bottom"></i>
                        Budget Office
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$budgtCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-success text-success nav-link office-btn" data-route="{{ route('thesis.dean_office') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-graduation bx-sm me-1_5 align-text-bottom"></i>
                        Deans Office
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$deanCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-danger text-danger nav-link office-btn" data-route="{{ route('thesis.accounting') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-calculator bx-sm me-1_5 align-text-bottom"></i>
                        Accounting
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$acctCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-warning text-warning nav-link office-btn" data-route="{{ route('thesis.dean_office_two') }}" role="tab">
                    <span class="d-none d-sm-block"><i class="tf-icons bx bxs-graduation bx-sm me-1_5 align-text-bottom"></i>
                        Deans Office
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$deanCountTwo ?? 0}}</span>
                    </span>
                    <i class="bx bxs-graduation bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-info text-info nav-link office-btn" data-route="{{ route('thesis.cashier') }}" role="tab">
                    <span class="d-none d-sm-block">
                        <i class="tf-icons bx bxs-credit-card-alt bx-sm me-1_5 align-text-bottom"></i>
                        Cashier
                        <span class="badge rounded-pill badge-center position-absolute h-px-20 w-px-20 bg-danger ms-1 pt-50">{{$cashCount ?? 0}}</span>
                    </span>
                    <i class="bx bx bxs-bank bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn-label-dark text-dark nav-link office-btn" data-route="{{ route('thesis.honorarium_released') }}" role="tab">
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
                    <table id="thesisEntriesTable" class="table table-borderless table-hover faculty_tracking_table" style="width:100%">
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

<script>

    $(function () {
        var user_id = {!! json_encode($user->employee_id) !!}; // Retrieve user ID
        window.showMembersAlert = function(id) {
            $.ajax({
                url: '{{ route("thesis.getMembersByID") }}', // Route to get members by ID
                type: 'GET',
                data: { id: id }, // Return the id to the backend
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                success: function(members) {

                    const membersString = members.map(member => {
                        return `<strong>Member Type:</strong> ${member.member_type}<br><strong>Name:</strong> ${member.first_name} ${member.last_name}`;
                    }).join('<br><br>');

                    Swal.fire({
                        title: 'Member(s)',
                        html: membersString,
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#007bff',
                        footer: 'Viewing members for thesis entry.'
                    });
                
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!',
                    });
                }
            });

        };

         // DataTable initialization
         const thesisTable = $('#thesisEntriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('thesis.dean_office.new-entries') }}',
                
            },
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            columns: [
                { data: 'student', name: 'student', title: 'Student' },
                { data: 'defense_date', name: 'defense_date', title: 'Defense Date' },
                { data: 'defense_time', name: 'defense_time', title: 'Defense Time' },
                { data: 'orNumber', name: 'orNumber', title: 'OR#' },
                { data: 'degree', name: 'degree', title: 'Degree' },
                { data: 'defense', name: 'defense', title: 'Defense' },
                { data: 'adviser', name: 'adviser', title: 'Adviser' },
                { data: 'chairperson', name: 'chairperson', title: 'Chairperson' },
                // { data: 'membersCount', name: 'membersCount', title: 'Members', render: function(data, type, row) {
                //     return `<a href="#" onclick="showMembersAlert(${row.id})">${data}</a>`;
                // } },
                { data: 'membersCount', name: 'membersCount', title: 'Members' },
                { data: 'recorder', name: 'recorder', title: 'Recorder' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                { data: 'created_on', name: 'created_on', title: 'Created On' },
                { data: 'created_at', name: 'created_at', title: 'Date' },
                
            ],
            order: [[0, 'desc']],  // Sort by date created by default
            columnDefs: [
                {
                    type: 'created_at',
                    targets: [0, 1] // Apply date sorting to date_received and date_on_hold columns
                }
            ],
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            },
            drawCallback: function() {
                
            },

        });



        // Handle button clicks for dynamic routes
        $('.office-btn').on('click', function(e) {
            e.preventDefault();
            var route = $(this).data('route'); // Get the route from the clicked button
            var officeTitle = $(this).text(); // Get the button text for the title display

            // Update the DataTable AJAX URL dynamically based on the clicked button
            thesisTable.ajax.url(route).load();

            // Update the office title
            $('#office-title').text(officeTitle);
        });

        // Automatically trigger the first button click to load the default route
        $('.office-btn').first().trigger('click');
    });
</script>



@endsection
