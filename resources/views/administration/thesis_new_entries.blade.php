@extends('components.app')

@section('content')

    {{-- Edit form --}}
    <div class="modal fade" id="editThesisEntiresModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div>
                            <div class="row mt-2">
                                <label for="student" class="form-label">Student Name</label>
                            </div>
                            <div id="editInputGroupStudentDiv">
                                <div class="row" id="inputGroupStudentRow">
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
                        </div>

                        <div class="row mt-4">
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

                        <div class="row mt-2">
                            <div class="col-md">
                                <label for="adviser" class="form-label">Select Adviser</label>
                                <select class="form-select" id="editAdviser" name="adviser_id" required>
                                    <option value="">Search/Select Adviser</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <label for="chairperson" class="form-label">Select Chairperson</label>
                                <select class="form-select" id="editChairperson" name="chairperson_id" required>
                                    <option value="">Search/Select Chairperson</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <div class="row mt-4">
                                <label for="member" class="form-label">Member 1</label>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <select class="form-select degree" name="" required>
                                        <option value="">Select Member Type</option>
                                        <option value="internal">Internal Member</option>
                                        <option value="external">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name" placeholder="Last Name" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row mt-4">
                                <label for="member" class="form-label">Member 2</label>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <select class="form-select degree" name="" required>
                                        <option value="">Select Member Type</option>
                                        <option value="internal">Internal Member</option>
                                        <option value="external">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name" placeholder="Last Name" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row mt-4">
                                <label for="member" class="form-label">Member 3</label>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <select class="form-select degree" name="" required>
                                        <option value="">Select Member Type</option>
                                        <option value="internal">Internal Member</option>
                                        <option value="external">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name" placeholder="Last Name" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row mt-4">
                                <label for="member" class="form-label">Member 4</label>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <select class="form-select degree" name="" required>
                                        <option value="">Select Member Type</option>
                                        <option value="internal">Internal Member</option>
                                        <option value="external">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name" placeholder="Last Name" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <label for="recorder" class="form-label">Recorder</label>
                        </div>
                        <div id="editGroupRecorderDiv">
                            <div class="row" id="editGroupRecorderRow">
                                <div class="col-md">
                                    <input type="text" class="form-control" name="recorder_first_name" placeholder="First Name" />
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control" name="recorder_middle_name" placeholder="Middle Name" />
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control" name="recorder_suffix" placeholder="Suffix. (optional)" />
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control" name="recorder_last_name" placeholder="Last Name" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success">Save changes</button>
                    <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 gap-3" id="thesisNewEntriesTitle">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h4 class="card-title text-secondary">Thesis New Entries</h4>
                    </div>

                    <div class="row">
                        <div class="card shadow-none bg-label-success">
                            <div class="card-header d-flex justify-content-end">
                                <small class="card-title text-success d-flex align-items-center gap-1"><i class='bx bxs-calendar'></i>{{ date('F j, Y') }}</small>
                            </div>
                            <div class="card-body text-success">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md d-flex align-items-center gap-3">
                                        <h1 class="text-success text-center d-flex align-items-center" id="onQueue" style="font-size: 48px;">10</h1>
                                        <h5 class="card-title text-success">Outgoing Defenses Added</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Add form --}}
    <div class="card custom-card shadow-none border border-primary mt-4" id="thesisEntryForm" style="display: none">
        <div class="card-header">
            <h5 class="card-title">New Thesis Entry Form</h5>
        </div>
        <div class="card-body">
            <form id="thesisEntryFormData">
                {{-- Student Section --}}
                <div class="row mt-2">
                    <label for="student" class="form-label">Student Name</label>
                </div>
                <div id="searchStudentDiv">
                    <div class="row" id="searchStudentRow">
                        <div class="col-md-10">
                            <select class="form-select required-field" id="student" name="student_id">
                                <option value="">Search/Select Student</option>
                            </select>
                            <div class="invalid-feedback">Please select a student</div>
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
                            <input type="text" class="form-control required-field" name="student_first_name" placeholder="First Name" />
                            <div class="invalid-feedback">First name is required</div>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control required-field" name="student_middle_name" placeholder="Middle Name" />
                            <div class="invalid-feedback">Middle name is required</div>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control" name="student_suffix" placeholder="Suffix. (optional)" />
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control required-field" name="student_last_name" placeholder="Last Name" />
                            <div class="invalid-feedback">Last name is required</div>
                        </div>
                    </div>
                </div>

                {{-- Defense Details Section --}}
                <div class="row mt-5">
                    <div class="col-md">
                        <label for="defense_date" class="form-label">Defense Date</label>
                        <input type="date" class="form-control required-field" id="defense_date" name="defense_date" />
                        <div class="invalid-feedback">Defense date is required</div>
                    </div>
                    <div class="col-md">
                        <label for="defense_time" class="form-label">Defense Time</label>
                        <input type="time" class="form-control required-field" id="defense_time" name="defense_time" />
                        <div class="invalid-feedback">Defense time is required</div>
                    </div>
                    <div class="col-md">
                        <label for="or_number" class="form-label">OR#</label>
                        <input type="" class="form-control required-field" id="or_number" name="or_number" />
                        <div class="invalid-feedback">OR number is required</div>
                    </div>
                </div>

                {{-- Degree & Defense Section --}}
                <div class="row mt-2">
                    <div class="col-md">
                        <label for="degree" class="form-label">Select Degree</label>
                        <select class="form-select required-field" id="degree" name="degree_id">
                            <option value="">Select Degree</option>
                            
                        </select>
                        <div class="invalid-feedback">Please select a degree</div>
                    </div>
                    <div class="col-md">
                        <label for="defense" class="form-label">Select Defense</label>
                        <select class="form-select required-field" id="defense" name="defense_id">
                            <option value="">Select Defense</option>
                           
                        </select>
                        <div class="invalid-feedback">Please select a defense type</div>
                    </div>
                </div>

                {{-- Adviser & Chairperson Section --}}
                <div class="row mt-2">
                    <div class="col-md">
                        <label for="adviser" class="form-label">Select Adviser</label>
                        <select class="form-select required-field" id="adviser" name="adviser_id">
                            <option value="">Search/Select Adviser</option>
                        </select>
                        <div class="invalid-feedback">Please select an adviser</div>
                    </div>
                    <div class="col-md">
                        <label for="chairperson" class="form-label">Select Chairperson</label>
                        <select class="form-select required-field" id="chairperson" name="chairperson_id">
                            <option value="">Search/Select Chairperson</option>
                        </select>
                        <div class="invalid-feedback">Please select a chairperson</div>
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
                                    <select class="form-select degree" name="member_type_{{ $i }}">
                                        <option value="">Select Member Type</option>
                                        <option value="internal">Internal Member</option>
                                        <option value="external">External Member</option>
                                    </select>
                                    {{-- <div class="invalid-feedback">Please select member type</div> --}}
                                </div>
                            </div>
                            <div class="mt-2 searchMemberDiv">
                                <div class="row searchMemberRow">
                                    <div class="col-md-10">
                                        <select class="form-select member" name="member_{{ $i }}_id">
                                            <option value="">Search/Select Member</option>
                                        </select>
                                        {{-- <div class="invalid-feedback">Please select a member</div> --}}
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
                                        {{-- <div class="invalid-feedback">First name is required</div> --}}
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_{{ $i }}_middle_name" placeholder="Middle Name" />
                                        {{-- <div class="invalid-feedback">Middle name is required</div> --}}
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_{{ $i }}_suffix" placeholder="Suffix (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_{{ $i }}_last_name" placeholder="Last Name" />
                                        {{-- <div class="invalid-feedback">Last name is required</div> --}}
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
                                <select class="form-select recorder required-field" name="recorder_id" id="recorder">
                                    <option value="">Search/Select Recorder</option>
                                </select>
                                <div class="invalid-feedback">Please select a recorder</div>
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
                                <input type="text" class="form-control required-field" name="recorder_first_name" placeholder="First Name" />
                                <div class="invalid-feedback">First name is required</div>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control required-field" name="recorder_middle_name" placeholder="Middle Name" />
                                <div class="invalid-feedback">Middle name is required</div>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" name="recorder_suffix" placeholder="Suffix (optional)" />
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control required-field" name="recorder_last_name" placeholder="Last Name" />
                                <div class="invalid-feedback">Last name is required</div>
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

    <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-primary" id="generateTrackingBtn" style="display: none;">Generate Tracking Number</button>
    </div>


@endsection

@section('components.specific_page_scripts')
<script>
    $(document).ready(function() {

        $('#student').select2({
            placeholder: 'Search Student...',
            allowClear: true,
            ajax: {
                url: '{{ route('thesis.getStudent') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(user => ({
                            id: user.id,
                            text: `${user.first_name} ${user.last_name}`
                        }))
                    };
                },
                cache: true
            }
        });

        $('#recorder').select2({
            placeholder: 'Search Student...',
            allowClear: true,
            ajax: {
                url: '{{ route('thesis.getRecorder') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(user => ({
                            id: user.id,
                            text: `${user.first_name} ${user.last_name}`
                        }))
                    };
                },
                cache: true
            }
        });

        function createSelect2Config(placeholder) {
            return {
                placeholder: placeholder,
                allowClear: true,
                ajax: {
                    url: '{{ route('getUser') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(user) {
                                return {
                                    id: user.id,
                                    text: user.employee_fname + ' ' + user.employee_lname
                                };
                            })
                        };
                    }
                }
            };
        }

        ['chairperson', 'adviser'].forEach(field => {
            $(`#${field}`).select2(createSelect2Config('Search by Name/ID Number...'));
        });

        for (let i = 1; i <= 4; i++) {
            $(`select[name="member_${i}_id"]`).select2({
                placeholder: 'Search by Name...',
                allowClear: true,
                ajax: {
                    url: '{{ route('thesis.getMembers') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(member => ({
                                id: member.id,
                                text: `${member.first_name} ${member.last_name}`
                            }))
                        };
                    },
                    cache: true
                }
            });
        }

        // Load defense types
        $.ajax({
            url: '{{ route('thesis.getDefenseTypes') }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let defenseSelect = $('#defense');
                defenseSelect.empty();
                defenseSelect.append('<option value="">Select Defense Type...</option>');
                data.forEach(function(item) {
                    defenseSelect.append(`<option value="${item.id}">${item.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading defense types:', error);
            }
        });

        // Load degrees
        $.ajax({
            url: '{{ route('thesis.getDegrees') }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let degreeSelect = $('#degree');
                degreeSelect.empty();
                degreeSelect.append('<option value="">Select Degree...</option>');
                data.forEach(function(item) {
                    degreeSelect.append(`<option value="${item.id}">${item.name}</option>`);
                });
            },
            error: function(error) {
                console.error('Error loading degrees:', error);
            }
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
                // $('input, select', parent).val('');
            });

            $(toggle.cancelBtn).click(function() {
                const parent = toggle.parent ? $(this).closest(toggle.parent) : document;
                $(toggle.inputDiv, parent).hide();
                $(toggle.searchDiv, parent).show();
                // $('input, select', parent).val('');
                $('.required-field', parent).removeClass('error');
                $('.select2-selection', parent).removeClass('error');
                $('.invalid-feedback', parent).hide();
            });
        });

        // Add CSS for required fields
        $("<style>")
            .prop("type", "text/css")
            .html(`
                .required-field.error {
                    border-color: #dc3545;
                }
                .required-field.error + .invalid-feedback {
                    display: block;
                }
                .select2-container--default .selection .select2-selection--single.error {
                    border-color: #dc3545;
                }
                .select2-container--default.select2-container--open .selection .select2-selection--single.error {
                    border-color: #dc3545;
                }
            `)
            .appendTo("head");

        // Validate required fields when form is submitted
        $('#thesisEntryFormData').on('submit', function(e) {
            let isValid = true;
            
            // Check all visible required fields
            $('.required-field:visible').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('error');
                    $(this).next('.invalid-feedback').show();
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).next('.select2-container').find('.select2-selection').addClass('error');
                    }
                    isValid = false;
                } else {
                    $(this).removeClass('error');
                    $(this).next('.invalid-feedback').hide();
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).next('.select2-container').find('.select2-selection').removeClass('error');
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                return false;
            }
        });

        // Remove error class on input
        $('.required-field').on('input change', function() {
            if ($(this).val()) {
                $(this).removeClass('error');
                $(this).next('.invalid-feedback').hide();
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('error');
                }
            }
        });

        // Remove error class on select2 change
        $('select').on('change', function() {
            if ($(this).val()) {
                $(this).removeClass('error');
                $(this).next('.invalid-feedback').hide();
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('error');
                }
            }
        });

        
        // DataTable initialization
        const thesisTable = $('#thesisEntriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("thesis.list") }}',
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
                // { data: 'member_1', name: 'member_1', title: 'Member 1' },
                // { data: 'member_2', name: 'member_2', title: 'Member 2' },
                // { data: 'member_3', name: 'member_3', title: 'Member 3' },
                // { data: 'member_4', name: 'member_4', title: 'Member 4' },
                { data: 'recorder', name: 'recorder', title: 'Recorder' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                { data: 'created_on', name: 'created_on', title: 'Created On' },
                { data: 'created_at', name: 'created_at', title: 'Date' },
                {
                    data: 'id',
                    title: 'Action',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return `
                            <div class="d-flex">
                                <button type="button" class="btn btn-icon me-2 btn-label-success" data-bs-toggle="modal" data-bs-target="#editThesisEntiresModal">
                                    <span class="tf-icons bx bx-pencil bx-22px"></span>
                                </button>
                                <button type="button" class="btn btn-icon me-2 btn-label-danger">
                                    <span class="tf-icons bx bxs-trash bx-22px"></span>
                                </button>
                            </div>
                        `;
                    }
                }
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
                // Check data whenever table is redrawn
                checkTableData();
            },
            
        });

        function checkTableData() {
            $.ajax({
                url: '{{ route("thesis.checkData") }}',
                type: 'GET',
                success: function(response) {
                    if (response.hasData) {
                        $('#generateTrackingBtn').show();
                    } else {
                        $('#generateTrackingBtn').hide();
                    }
                },
                error: function(xhr) {
                    console.error('Error checking table data:', xhr);
                }
            });
        }

        // Call the function when page loads
        checkTableData();
        
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
            
            // Remove error classes
            $('.required-field').removeClass('error');
            $('.select2-selection').removeClass('error');
            $('.invalid-feedback').hide();

            // Reset Select2 dropdowns
            $('#thesisEntryForm').find('select').trigger('change');

            // Hide form and show add button
            $('#thesisEntryForm').hide();
            $('#addNewThesisEntryButton').show();

            // Reset all member/student/recorder sections to search view
            $('.inputGroupStudentDiv, .inputGroupMemberDiv, .inputGroupRecorderDiv').hide();
            $('.searchStudentDiv, .searchMemberDiv, .searchRecorderDiv').show();
        });

        $('#thesisEntryFormData').on('submit', function(e) {
            e.preventDefault();
            
            // Get all form data
            const formData = $(this).serialize();
            $.ajax({
                url: '{{ route("thesis.store") }}',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Thesis entry saved successfully!'
                        });

                        $('#cancelFormButton').click();
                        checkTableData();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!'
                    });
                }
            });
        });

        // Function to capitalize first letter of each word
        function capitalizeWords(str) {
            return str.replace(/\b\w/g, function(txt) { return txt.toUpperCase(); });
        }

        // Apply auto-capitalization to name input fields
        $('#thesisEntryForm').on('input', 'input[type="text"]', function() {
            if ($(this).attr('placeholder') && $(this).attr('placeholder').includes('Name')) {
                $(this).val(capitalizeWords($(this).val()));
            }
        });


        // Prevent form submission on enter key
        // $('#thesisEntryForm').on('keypress', function(e) {
        //     return e.which !== 13;
        // });

        // // Initialize date picker
        // $('input[name="defense_date"]').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true
        // });

        // // Initialize time picker
        // $('input[name="defense_time"]').timepicker({
        //     showMeridian: true,
        //     minuteStep: 1
        // });
    });
</script>
@endsection
