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
                    <div id="searchStudentDiv">
                        <div class="row" id="searchStudentRow">
                            <div class="col-md-10">
                                <select class="form-select" id="student" name="student">
                                    <option value="">Search/Select Student</option>
                                    <!-- Options for advisers will be populated here -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-label-primary w-100" id="addStudentButton"><i class='bx bx-user-plus'></i>Add Student</button>
                            </div>
                        </div>
                    </div>
                    <div id="inputGroupStudentDiv" style="display: none">
                        <div class="row" id="inputGroupStudentRow">
                            <div class="col-md">
                                <button class="btn btn-label-warning d-flex justify content-end w-100" id="cancelStudentButton"><i class='bx bx-search-alt'></i>Search</button>
                            </div>
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

                    <!-- Member -->
                    <div class="row mt-3">
                        <label for="defaultFormControlInput" class="form-label">Member</label>
                    </div>

                    <div class="mb-4 memberFormField" id="memberFormField_1">
                        <div class="row">
                            <div class="col-md">
                                <select class="form-select degree" name="degree">
                                    <option value="">Select Member Type</option>
                                    <option value="masteral">Internal Member</option>
                                    <option value="doctoral">External Member</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-2 searchMemberDiv">
                            <div class="row searchStudentRow">
                                <div class="col-md-10">
                                    <select class="form-select member" name="member">
                                        <option value="">Search/Select Member</option>
                                        <!-- Options for advisers will be populated here -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-label-primary w-100 addMemberButton"><i class='bx bx-user-plus'></i>Create Member</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 inputGroupMemberDiv" style="display: none">
                            <div class="row inputGroupMemberRow">
                                <div class="col-md">
                                    <button class="btn btn-label-warning w-100 cancelMemberButton"><i class='bx bx-search-alt'></i>Search a Member</button>
                                </div>
                                <!-- Name fields -->
                                <div class="col-md"><input type="text" class="form-control" placeholder="First Name" /></div>
                                <div class="col-md"><input type="text" class="form-control" placeholder="Middle Name" /></div>
                                <div class="col-md"><input type="text" class="form-control" placeholder="Suffix (optional)" /></div>
                                <div class="col-md"><input type="text" class="form-control" placeholder="Last Name" /></div>
                            </div>
                        </div>
                    </div>

                    <!-- New Button for Adding Forms -->
                    <button class="btn btn-primary mt-3" id="addNewMemberFormButton">Add New Member Form</button>

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
    // Student
    $(document).ready(function() {
        $('#addStudentButton').click(function() {
            $('#searchStudentDiv').hide();
            $('#inputGroupStudentDiv').show();
            $('#searchStudentDiv input').val('');
            $('#inputGroupStudentDiv input').val('');
        });

        $('#cancelStudentButton').click(function() {
            $('#inputGroupStudentDiv').hide();
            $('#searchStudentDiv').show();
            $('#searchStudentDiv input').val('');
            $('#inputGroupStudentDiv input').val('');
        });
    });


    // adding of member
    $(document).ready(function() {
        let formCount = 1;
        const maxForms = 4;

        // Add new member form when the "Add New Member Form" button is clicked
        $('#addNewMemberFormButton').click(function(e) {
            e.preventDefault();

            if (formCount < maxForms) {
                formCount++;
                const newForm = $('#memberFormField_1').clone().removeAttr('id');

                // Clear inputs in the cloned form and reset visibility states
                newForm.find('input').val('');
                newForm.find('.searchMemberDiv').show();
                newForm.find('.inputGroupMemberDiv').hide();

                // Insert cloned form
                $('#memberFormField_1').after(newForm);
            } else {
                alert("Maximum of 4 member forms reached.");
            }
        });

        // Delegated event for show/hide toggle (covers original and duplicated forms)
        $(document).on('click', '.addMemberButton', function(e) {
            e.preventDefault();
            $(this).closest('.searchMemberDiv').hide();
            $(this).closest('.memberFormField').find('.inputGroupMemberDiv').show();
        });

        $(document).on('click', '.cancelMemberButton', function(e) {
            e.preventDefault();
            $(this).closest('.inputGroupMemberDiv').hide();
            $(this).closest('.memberFormField').find('.searchMemberDiv').show();
        });
    });




    // Datatables
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
        $('#student').select2({
            placeholder: "Search/Select Student",
            allowClear: true
        });

        $('#adviser').select2({
            placeholder: "Search/Select Adviser",
            allowClear: true
        });

        $('#chairperson').select2({
            placeholder: "Search/Select Chairperson",
            allowClear: true
        });

        $('#member').select2({
            placeholder: "Search/Select Member",
            allowClear: true
        });
    });


</script>
@endsection
