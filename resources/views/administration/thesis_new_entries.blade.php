@extends('components.app')

@section('content')
    <div class="row mt-2">
        <h4 class="card-title text-secondary">Thesis New Entries</h4>
    </div>

    {{-- form --}}
    <div class="card custom-card shadow-none border border-primary mt-4" id="thesisEntryForm" style="display: none">
        <div class="card-header">
            <h5 class="card-title">New Thesis Entry Form</h5>
        </div>
        <div class="card-body">
            <form id="thesisEntryForm" method="POST" action="">
                @csrf
                {{-- Student Section --}}
                <div class="row mt-2">
                    <label for="student" class="form-label">Student Name</label>
                </div>
                <div id="searchStudentDiv">
                    <div class="row" id="searchStudentRow">
                        <div class="col-md-10">
                            <select class="form-select" id="student" name="student_id">
                                <option value="">Search/Select Student</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-label-primary w-100" id="addStudentButton">
                                <i class='bx bx-user-plus'></i>Add Student
                            </button>
                        </div>
                    </div>
                </div>
                <div id="inputGroupStudentDiv" style="display: none">
                    <div class="row" id="inputGroupStudentRow">
                        <div class="col-md">
                            <button type="button" class="btn btn-label-warning d-flex justify content-end w-100" id="cancelStudentButton">
                                <i class='bx bx-search-alt'></i>Search
                            </button>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control" name="student_first_name" placeholder="First Name" />
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control" name="student_middle_name" placeholder="Middle Name" />
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control" name="student_suffix" placeholder="Suffix. (optional)" />
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control" name="student_last_name" placeholder="Last Name" />
                        </div>
                    </div>
                </div>

                {{-- Defense Details Section --}}
                <div class="row mt-5">
                    <div class="col-md">
                        <label for="defense_date" class="form-label">Defense Date</label>
                        <input type="date" class="form-control" id="defense_date" name="defense_date" required />
                    </div>
                    <div class="col-md">
                        <label for="defense_time" class="form-label">Defense Time</label>
                        <input type="time" class="form-control" id="defense_time" name="defense_time" required />
                    </div>
                    <div class="col-md">
                        <label for="or_number" class="form-label">OR#</label>
                        <input type="" class="form-control" id="or_number" name="or_number" required />
                    </div>
                </div>

                {{-- Degree & Defense Section --}}
                <div class="row mt-2">
                    <div class="col-md">
                        <label for="degree" class="form-label">Select Degree</label>
                        <select class="form-select" id="degree" name="degree" required>
                            <option value="">Select Degree</option>
                            <option value="masteral">Masteral</option>
                            <option value="doctoral">Doctoral</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <label for="defense" class="form-label">Select Defense</label>
                        <select class="form-select" id="defense" name="defense_type" required>
                            <option value="">Select Defense</option>
                            <option value="proposal">Proposal</option>
                            <option value="pre-oral">Pre-Oral</option>
                            <option value="final">Final</option>
                        </select>
                    </div>
                </div>

                {{-- Adviser & Chairperson Section --}}
                <div class="row mt-2">
                    <div class="col-md">
                        <label for="adviser" class="form-label">Select Adviser</label>
                        <select class="form-select" id="adviser" name="adviser_id" required>
                            <option value="">Search/Select Adviser</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <label for="chairperson" class="form-label">Select Chairperson</label>
                        <select class="form-select" id="chairperson" name="chairperson_id" required>
                            <option value="">Search/Select Chairperson</option>
                        </select>
                    </div>
                </div>

                {{-- Members Section --}}
                <div class="mt-5">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="row mt-2">
                            <label class="form-label">Member {{ $i }}</label>
                        </div>
                        <div class="memberFormField" id="memberFormField_{{ $i }}">
                            <div class="row">
                                <div class="col-md">
                                    <select class="form-select degree" name="member_type_{{ $i }}" required>
                                        <option value="">Select Member Type</option>
                                        <option value="internal">Internal Member</option>
                                        <option value="external">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2 searchMemberDiv">
                                <div class="row searchMemberRow">
                                    <div class="col-md-10">
                                        <select class="form-select member" name="member_{{ $i }}_id">
                                            <option value="">Search/Select Member</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-label-primary w-100 addMemberButton">
                                            <i class='bx bx-user-plus'></i>Create Member
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 inputGroupMemberDiv" style="display: none">
                                <div class="row inputGroupMemberRow">
                                    <div class="col-md">
                                        <button type="button" class="btn btn-label-warning w-100 cancelMemberButton">
                                            <i class='bx bx-search-alt'></i>Search a Member
                                        </button>
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_{{ $i }}_first_name" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_{{ $i }}_middle_name" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_{{ $i }}_suffix" placeholder="Suffix (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_{{ $i }}_last_name" placeholder="Last Name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- Recorder Section --}}
                <div class="row mt-5">
                    <label for="recorder" class="form-label">Recorder</label>
                </div>
                <div class="recorderFormField">
                    <div class="searchRecorderDiv">
                        <div class="row searchRecorderRow">
                            <div class="col-md-10">
                                <select class="form-select recorder" name="recorder_id" required>
                                    <option value="">Search/Select Recorder</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-label-primary w-100 addRecorderButton">
                                    <i class='bx bx-user-plus'></i>Create Recorder
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 inputGroupRecorderDiv" style="display: none">
                        <div class="row inputGroupRecorderRow">
                            <div class="col-md">
                                <button type="button" class="btn btn-label-warning w-100 cancelRecorderButton">
                                    <i class='bx bx-search-alt'></i>Search a Recorder
                                </button>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" name="recorder_first_name" placeholder="First Name" />
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" name="recorder_middle_name" placeholder="Middle Name" />
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" name="recorder_suffix" placeholder="Suffix (optional)" />
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" name="recorder_last_name" placeholder="Last Name" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="row mt-3">
                    <div class="col-md d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="saveFormButton">Save</button>
                        <button type="button" class="btn btn-label-danger ms-2" id="cancelFormButton">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- new entry button --}}
    <div class="row mt-4">
        <div class="col-md d-flex justify-content-end">
            <button class="btn btn-primary" id="addNewThesisEntryButton">Add New Entry</button>
        </div>
    </div>

    {{-- datatables --}}
    <div class="row mt-2">
        <div class="col-md">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thesisEntriesTable" class="table table-borderless table-hover"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('components.specific_page_scripts')
<script>
$(document).ready(function() {
    // Initialize all Select2 dropdowns
    const select2Fields = ['#student', '#adviser', '#chairperson', '.member', '.recorder'];
    select2Fields.forEach(field => {
        $(field).select2({
            placeholder: "Search/Select " + field.replace(/[#.]/g, '').charAt(0).toUpperCase() + field.replace(/[#.]/g, '').slice(1),
            allowClear: true
        });
    });

    // Handle form toggles
    const formToggles = [
        {
            addBtn: '#addStudentButton',
            cancelBtn: '#cancelStudentButton',
            searchDiv: '#searchStudentDiv',
            inputDiv: '#inputGroupStudentDiv'
        },
        {
            addBtn: '.addMemberButton',
            cancelBtn: '.cancelMemberButton',
            searchDiv: '.searchMemberDiv',
            inputDiv: '.inputGroupMemberDiv',
            parent: '.memberFormField'
        },
        {
            addBtn: '.addRecorderButton',
            cancelBtn: '.cancelRecorderButton',
            searchDiv: '.searchRecorderDiv',
            inputDiv: '.inputGroupRecorderDiv',
            parent: '.recorderFormField'
        }
    ];

    formToggles.forEach(toggle => {
        $(toggle.addBtn).click(function() {
            const parent = toggle.parent ? $(this).closest(toggle.parent) : document;
            $(toggle.searchDiv, parent).hide();
            $(toggle.inputDiv, parent).show();
            $('input, select', parent).val('');
        });

        $(toggle.cancelBtn).click(function() {
            const parent = toggle.parent ? $(this).closest(toggle.parent) : document;
            $(toggle.inputDiv, parent).hide();
            $(toggle.searchDiv, parent).show();
            $('input, select', parent).val('');
        });
    });

    // DataTable initialization
    const thesisTable = $('#thesisEntriesTable').DataTable({
        data: [], // Initialize empty
        columns: [
            { data: 'studentName', title: 'Student Name' },
            { data: 'orNumber', title: 'OR Number' },
            {
                data: 'faculties',
                title: 'Faculty Count',
                render: data => `${data.length} <i class="fas fa-chevron-down"></i>`
            }
        ],
        rowCallback: row => $(row).css('cursor', 'pointer')
    });

    // Handle row expansion
    $('#thesisEntriesTable tbody').on('click', 'tr', function() {
        const row = thesisTable.row(this);
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

    // Enhanced search functionality
    $.fn.dataTable.ext.search.push((settings, data, dataIndex) => {
        const searchText = $('.dataTables_filter input').val().toLowerCase();
        if (!searchText) return true;

        const rowData = thesisTable.row(dataIndex).data();
        return data[0].toLowerCase().includes(searchText) || // Student Name
               data[1].toLowerCase().includes(searchText) || // OR Number
               rowData.faculties.some(f => f.toLowerCase().includes(searchText)) ||
               rowData.positions.some(p => p.toLowerCase().includes(searchText));
    });

    // Handle "Add New Entry" button click
    $('#addNewThesisEntryButton').click(function() {
        $('#thesisEntryForm').show();
        $(this).hide();
    });

    // Handle "Cancel" button click
    $('#cancelFormButton').click(function() {
        // Clear all input fields
        $('#thesisEntryForm').find('input, select').val('');

        // Reset Select2 dropdowns
        $('#thesisEntryForm').find('select').trigger('change');

        // Hide form and show add button
        $('#thesisEntryForm').hide();
        $('#addNewThesisEntryButton').show();

        // Reset all member/student/recorder sections to search view
        $('.inputGroupStudentDiv, .inputGroupMemberDiv, .inputGroupRecorderDiv').hide();
        $('.searchStudentDiv, .searchMemberDiv, .searchRecorderDiv').show();
    });
});
</script>
@endsection
