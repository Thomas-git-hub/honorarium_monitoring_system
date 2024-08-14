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
          <h5 class="text-center text-danger">Transaction ID No. = <b>002-08122024</b></h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
          <button type="button" class="btn btn-primary gap-1">Proceed to Budget Office<i class='bx bx-chevrons-right'></i></button>
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
                <h1 class="text-danger">5</h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="facultyTable" class="table table-borderless" style="width:100%">
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

</script>


@endsection
