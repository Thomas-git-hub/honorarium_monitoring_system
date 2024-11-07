@extends('components.app')

@section('content')
    <div class="row mt-2">
        <h4 class="card-title text-secondary">Thesis New Entries</h4>
    </div>


    <div class="row mt-2">
        <div class="col-md">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <label for="defaultFormControlInput" class="form-label">Student Name</label>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            {{-- <label for="defaultFormControlInput" class="form-label">Name</label> --}}
                            <input type="text" class="form-control" id="defaultFormControlInput" placeholder="First Name" aria-describedby="defaultFormControlHelp" />
                        </div>
                        <div class="col-md">
                            {{-- <label for="defaultFormControlInput" class="form-label">Name</label> --}}
                            <input type="text" class="form-control" id="defaultFormControlInput" placeholder="Middle Name" aria-describedby="defaultFormControlHelp" />
                        </div>
                        <div class="col-md">
                            {{-- <label for="defaultFormControlInput" class="form-label">Name</label> --}}
                            <input type="text" class="form-control" id="defaultFormControlInput" placeholder="Suffix. (optional)" aria-describedby="defaultFormControlHelp" />
                        </div>
                        <div class="col-md">
                            {{-- <label for="defaultFormControlInput" class="form-label">Name</label> --}}
                            <input type="text" class="form-control" id="defaultFormControlInput" placeholder="Last Name" aria-describedby="defaultFormControlHelp" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md d-flex justify-content-end">
                            <button type="button" class="btn btn-icon me-2 btn-primary">
                                <span class="tf-icons bx bx-search-alt bx-22px"></span>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md">
                            <label for="defense_date" class="form-label">Defense Date</label>
                            <input type="date" class="form-control" id="defense_date" name="defense_date" />
                        </div>
                        <div class="col-md">
                            <label for="defense_time" class="form-label">Defense Time</label>
                            <input type="time" class="form-control" id="defense_time" name="defense_time" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md">
                            <label for="degree" class="form-label">Select Degree</label>
                            <select class="form-select" id="degree" name="degree">
                                <option value="">Select Degree</option>
                                <option value="masteral">Masteral</option>
                                <option value="doctoral">Doctoral</option>
                            </select>
                        </div>
                        <div class="col-md">
                            <label for="defense" class="form-label">Select Defense</label>
                            <select class="form-select" id="defense" name="defense">
                                <option value="">Select Defense</option>
                                <option value="proposal">Proposal</option>
                                <option value="pre-oral">Pre-Oral</option>
                                <option value="final">Final</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md">
                            <label for="adviser" class="form-label">Select Adviser</label>
                            <select class="form-select" id="adviser" name="adviser">
                                <option value="">Search/Select Adviser</option>
                                <!-- Options for advisers will be populated here -->
                            </select>
                        </div>
                        <div class="col-md">
                            <label for="chairperson" class="form-label">Select Chairperson</label>
                            <select class="form-select" id="chairperson" name="chairperson">
                                <option value="">Search/Select Chairperson</option>
                                <!-- Options for chairpersons will be populated here -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md d-flex justify-content-end">
            <button class="btn btn-primary">Add New Thesis Entries</button>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thesisEntriesTable" class="table table-borderless table-hover">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('components.specific_page_scripts')
<script>
    $(document).ready(function() {
        // Sample data - replace with actual data source
        const studentsData = [
            {
                studentName: "John Doe",
                orNumber: "OR12345",
                faculties: ["Faculty 1", "Faculty 2", "Faculty 3", "Faculty 4", "Faculty 5"],
                positions: ["Chairman", "Member", "Member", "Member", "Member"]
            },
            {
                studentName: "Jane Smith",
                orNumber: "OR12346",
                faculties: ["Faculty A", "Faculty B", "Faculty C", "Faculty D", "Faculty E"],
                positions: ["Chairman", "Member", "Member", "Member", "Member"]
            }
        ];

        const table = $('#thesisEntriesTable').DataTable({
            data: studentsData,
            columns: [
                { data: 'studentName', title: 'Student Name' },
                { data: 'orNumber', title: 'OR Number' },
                {
                    data: 'faculties',
                    title: 'Faculty Count',
                    render: data => `${data.length} <i class="fas fa-chevron-down"></i>`
                }
            ],
            rowCallback: function(row, data) {
                $(row).css('cursor', 'pointer');
            }
        });

        // Add search functionality for faculty and position
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                const searchText = $('.dataTables_filter input').val().toLowerCase();
                const rowData = studentsData[dataIndex];

                // Search in faculties array
                const facultyMatch = rowData.faculties.some(faculty =>
                    faculty.toLowerCase().includes(searchText)
                );

                // Search in positions array
                const positionMatch = rowData.positions.some(position =>
                    position.toLowerCase().includes(searchText)
                );

                // Return true if main data matches OR faculty matches OR position matches
                return !searchText ||
                       data[0].toLowerCase().includes(searchText) || // Student Name
                       data[1].toLowerCase().includes(searchText) || // OR Number
                       facultyMatch ||
                       positionMatch;
            }
        );

        $('#thesisEntriesTable tbody').on('click', 'tr', function() {
            const row = table.row(this);
            const data = row.data();

            if (row.child.isShown()) {
                row.child.hide();
                $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            } else {
                const facultyTable = $('<table class="table table-sm">').append(
                    $('<thead>').append(
                        $('<tr>').append(
                            $('<th>').text('Faculty'),
                            $('<th>').text('Position')
                        )
                    ),
                    $('<tbody>').append(
                        data.faculties.map((faculty, index) =>
                            $('<tr>').append(
                                $('<td>').text(faculty),
                                $('<td>').text(data.positions[index])
                            )
                        )
                    )
                );

                row.child(facultyTable).show();
                $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
        });

        // Trigger search on input change
        $('.dataTables_filter input').on('keyup', function() {
            table.draw();
        });
    });

    // Select2 searchable fields for Adviser and Chairperson
    $(document).ready(function() {
        // Initialize Select2 for searchable dropdowns
        $('#adviser').select2({
            placeholder: "Search/Select Adviser",
            allowClear: true
        });

        $('#chairperson').select2({
            placeholder: "Search/Select Chairperson",
            allowClear: true
        });
    });
</script>
@endsection
