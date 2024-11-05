@extends('components.app')

@section('content')

       <div class="row mt-4">
            <h4 class="card-title text-secondary">Faculties</h4>
       </div>

        <div class="row mt-4 gap-3">
            <div class="col-md">
                <div class="card shadow-none bg-label-success">
                <div class="card-body text-success">
                    <h5 class="card-title text-success">New Activated Accounts Today</h5>
                    <h1 class="text-success">{{ $newAccountsToday }}</h1>
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
                                <tbody>

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
    $(function () {
        var data = [
            {
                faculty: '<strong>John Doe</strong>',
                id_number: '<p class="text-primary">1-id-no-2024</p>',
                academic_rank: '<span class="badge bg-success">Associate  Professor II</span>',
                college: 'College of Arts',
                account_status: '<span class="text-danger">Inactive</span>',
                // action: '<button class="btn btn-info">View</button>'
            },
            {
                faculty: '<strong>John Doe</strong>',
                id_number: '<p class="text-primary">1-id-no-2024</p>',
                academic_rank: '<span class="badge bg-warning">Part-time</span>',
                college: 'College of Science',
                account_status: '<span class="text-success">active</span>',
                // action: '<button class="btn btn-info">View</button>'
            }
            // Add more objects as needed
        ];

        var table = $('#facultyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin_faculty.list') }}',
            pageLength: 10,
            paging: true, // Disable pagination

            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            order: [[5, 'desc']],
            columns: [
                { data: 'id', name: 'id', title: 'ID', visible: false},
                { data: 'faculty', name: 'faculty', title: 'Faculty' },
                { data: 'ee_number', name: 'ee_number', title: 'ID Number' },
                { data: 'position', name: 'position', title: 'academic_rank' },
                { data: 'college', name: 'college', title: 'College' },
                { data: 'created_at', name: 'created_at', title: 'Created At' },
            ],
            createdRow: function(row, data) {
                // Add class to unopened rows
                $(row).addClass('unopened');
            }
        });

        // Row click event
        $('#facultyTable tbody').on('click', 'tr', function() {
            var rowData = table.row($(this).closest('tr')).data();

            // If the row is unopened, change its class to opened
            if ($(this).hasClass('unopened')) {
                // $(this).removeClass('unopened').addClass('opened');
            }

            // Redirect to another page with full details (example)
            window.location.href = `/admin_view_faculty?id=${rowData.employee_id}`;
        });
    });
</script>
{{--FACULTY DATATABLES END --}}
@endsection
