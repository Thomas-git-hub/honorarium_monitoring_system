@extends('components.app')

@section('content')

    {{-- Edit form --}}
    <div class="modal fade" id="editThesisEntriesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Thesis Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div>
                            <div class="row mt-2">
                                <label for="student" class="form-label">Student Name</label>
                            </div>
                            <div id="editInputGroupStudentDiv">
                                <input type="hidden" class="form-control" name="thesis_id" />
                                <input type="hidden" class="form-control" name="student_id" id="student_id" />

                                <div class="row" id="inputGroupStudentRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control required-field " name="student_first_name" placeholder="First Name" />
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
                        </div>

                        <div class="row mt-4">
                            <div class="col-md">
                                <label for="defense_date" class="form-label">Defense Date</label>
                                <input type="date" class="form-control required-field" id="ediDefensedate" name="defense_date" required />
                                <div class="invalid-feedback">Defense date is required</div>
                            </div>
                            <div class="col-md">
                                <label for="defense_time" class="form-label">Defense Time</label>
                                <input type="time" class="form-control required-field" id="editDefenseTime" name="defense_time" required />
                                <div class="invalid-feedback">Defense time is required</div>
                            </div>
                            <div class="col-md">
                                <label for="or_number" class="form-label">OR#</label>
                                <input type="" class="form-control required-field" id="orNumber" name="or_number" required />
                                <div class="invalid-feedback">OR number is required</div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md">
                                <label for="degree" class="form-label">Select Degree</label>
                                <select class="form-select required-field" id="editDegree" name="degree" required>
                                    <option value="">Select Degree</option>
                                </select>
                                <div class="invalid-feedback">Please select a degree</div>
                            </div>
                            <div class="col-md">
                                <label for="defense" class="form-label">Select Defense</label>
                                <select class="form-select required-field" id="editDefense" name="defense_type" required>
                                    <option value="">Select Defense</option>
                                </select>
                                <div class="invalid-feedback">Please select a defense type</div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md">
                                <label for="adviser" class="form-label">Select Adviser</label>
                                <select class="form-select required-field" id="editAdviser" name="adviser_id" required>
                                    <option value="">Search/Select Adviser</option>
                                </select>
                                <div class="invalid-feedback">Please select an adviser</div>
                                
                            </div>
                            <div class="col-md">
                                <label for="chairperson" class="form-label">Select Chairperson</label>
                                <select class="form-select required-field" id="editChairperson" name="chairperson_id" required>
                                    <option value="">Search/Select Chairperson</option>
                                </select>
                                <div class="invalid-feedback">Please select a chairperson</div>
                            </div>
                        </div>

                        <div>
                            <div class="row mt-4">
                                <label for="member" class="form-label">Member 1</label>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <input type="hidden" class="form-control" name="member_id_1" />
                                    <select class="form-select " name="member_type_1" required>
                                        <option value="">Select Member Type</option>
                                        <option value="Internal Member">Internal Member</option>
                                        <option value="External Member">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name_1" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name_1" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix_1" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name_1" placeholder="Last Name" />
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
                                    <input type="hidden" class="form-control" name="member_id_2" />
                                    <select class="form-select degree" name="member_type_2" required>
                                        <option value="">Select Member Type</option>
                                        <option value="Internal Member">Internal Member</option>
                                        <option value="External Member">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name_2" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name_2" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix_2" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name_2" placeholder="Last Name" />
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
                                    <input type="hidden" class="form-control" name="member_id_3" />
                                    <select class="form-select degree" name="member_type_3" required>
                                        <option value="">Select Member Type</option>
                                        <option value="Internal Member">Internal Member</option>
                                        <option value="External Member">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name_3" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name_3" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix_3" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name_3" placeholder="Last Name" />
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
                                    <input type="hidden" class="form-control" name="member_id_4" />
                                    <select class="form-select degree" name="member_type_4" required>
                                        <option value="">Select Member Type</option>
                                        <option value="Internal Member">Internal Member</option>
                                        <option value="External Member">External Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="editGroupMemberDiv">
                                <div class="row" id="editGroupMemberRow">
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_first_name_4" placeholder="First Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_middle_name_4" placeholder="Middle Name" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_suffix_4" placeholder="Suffix. (optional)" />
                                    </div>
                                    <div class="col-md">
                                        <input type="text" class="form-control" name="member_last_name_4" placeholder="Last Name" />
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
                                    <input type="text" class="form-control required-field" name="recorder_first_name" placeholder="First Name" />
                                    <div class="invalid-feedback">First name is required</div>
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control required-field" name="recorder_middle_name" placeholder="Middle Name" />
                                    <div class="invalid-feedback">Middle name is required</div>
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control" name="recorder_suffix" placeholder="Suffix. (optional)" />
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control required-field" name="recorder_last_name" placeholder="Last Name" />
                                    <div class="invalid-feedback">Last name is required</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success editSubmitBtn">Save changes</button>
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
                            <input type="text" class="form-control required-field f_name" name="student_first_name" placeholder="First Name" />
                            <div class="invalid-feedback">First name is required</div>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control required-field m_name" name="student_middle_name" placeholder="Middle Name" />
                            <div class="invalid-feedback">Middle name is required</div>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control suffix" name="student_suffix" placeholder="Suffix. (optional)" />
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control required-field l_name" name="student_last_name" placeholder="Last Name" />
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
                                        <option value="Internal Member">Internal Member</option>
                                        <option value="External Member">External Member</option>
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
        <div class="col-md d-flex justify-content-end gap-2">
            <button class="btn btn-label-primary btn-sm" id="refresh">Refresh</button>
            <button class="btn btn-primary" id="addNewThesisEntryButton">Add New Entry</button>
            <button class="btn btn-success" id="generateTrackingNumberButton">Generate Tracking Number</button>
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

    {{-- <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-primary" id="generateTrackingNumberButton">Generate Tracking Number</button>
    </div> --}}

    <div class="card border border-primary trackingNumDisplay mt-2" id="trackingNumDisplay" style="display: none;">
        <div class="card-body">
            <div class="row d-flex align-items-center mb-5">
                <label for="html5-text-input" class="col-md-4 col-form-label fs-6">Tracking Number:</label>
                <div class="col-md-8">
                  <b class="text-primary" id="batchThesisID">-</b>
                </div>
                <small class="text-danger"><b>Note:&nbsp;</b>Always attach the tracking number on the documents.</small>
            </div>
            <div class="row d-flex align-items-center">
                <label for="html5-text-input" class="col-md-4 col-form-label">Total Students:</label>
                <div class="col-md-8">
                  <b class="text-dark" id="thesisTransCount">-</b>
                </div>
            </div>
            <div class="row d-flex align-items-center mb-3">
                <label for="html5-text-input" class="col-md-4 col-form-label">Transaction Date:</label>
                <div class="col-md-8">
                  <small class="text-dark" id="date"><?php echo date('F j, Y'); ?></small>
                </div>
            </div>
            <div class="">
                <small class="text-danger">Please ensure that all outgoing defenses have complete documentation and that all defense members submits complete requirements.</small>
                <button class="btn btn-primary w-100" id="proceedThesisTransactionButton">Proceed to next office</button>
            </div>

        </div>
    </div>


@endsection

@section('components.specific_page_scripts')
<script>
    $(document).ready(function() {

        $('#proceedThesisTransactionButton').off('click').on('click', function() {
            $.ajax({
                url: '{{ route('thesis.proceed') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processing...',
                        html: '<div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },

                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaction Completed',
                            text: response.message,
                        }).then(function() {
                            // Reload the entire page when the "OK" button is clicked
                            location.reload();
                        });

                        getNewEntries();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong',
                            text: response.message,
                        });

                        getNewEntries();
                    }

                    // Reload DataTable
                    $('#facultyTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    getNewEntries();

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem updating the transactions.',
                    });
                }
            });
        });

         // clear fields when switching actions
        // Clear the select field with id #student when #addStudentButton is clicked
        $('#addStudentButton').click(function() {
            // Clear the selected option in the student dropdown
            $('#student').val(null).trigger('change'); // Use trigger('change') to update Select2
        });
        // Clear the fields with class names f_name, m_name, suffix, and l_name when #cancelStudentButton is clicked
        $('#cancelStudentButton').click(function() {
            $('.f_name, .m_name, .suffix, .l_name').val(''); // Clear the input fields
        });
        // Clear the select field with class .member when .addMemberButton is clicked
        $('.addMemberButton').click(function() {
            $('.member').val(null).trigger('change'); // Clear the select field
        });
        // Clear the input fields with specific name attributes when .cancelMemberButton is clicked
        $('.cancelMemberButton').click(function() {
            $('input[name*="_first_name"], input[name*="_middle_name"], input[name*="_suffix"], input[name*="_last_name"]').val(''); // Clear the input fields
        });

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
                let defenseSelect = $('#defense, #editDefense');
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
                let degreeSelect = $('#degree, #editDegree');
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
        
       // Helper function to configure select2
        function createSelect2Edit(placeholder) {
            return {
                placeholder: placeholder,
                allowClear: true,
                width: '100%',
                dropdownParent: $('#editThesisEntriesModal'),
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

        // Initialize select2 for adviser and chairperson fields
        ['editAdviser', 'editChairperson'].forEach(field => {
            $(`#${field}`).select2(createSelect2Edit('Search by Name/ID Number...'));
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

        window.showMembersAlert = function(id) {

            $.ajax({
                url: '{{ route("thesis.getMembersByID") }}', // Route to get members by ID
                type: 'GET',
                data: { id: id }, // Return the id to the backend
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                success: function(members) {

                    const membersString = Object.keys(members).map(lastName => {
                        const member = members[lastName];
                        return `<strong>Member Type:</strong> ${member.member_type}<br><strong>Name:</strong> ${member.first_name} ${lastName}`;
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

        console.log(typeof showMembersAlert); 

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
                { data: 'membersCount', name: 'membersCount', title: 'Members', render: function(data, type, row) {
                    return `<a href="#" onclick="showMembersAlert(${row.id})">${data}</a>`;
                } },
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
                                <button type="button" class="btn btn-icon me-2 btn-label-success edit-btn" data-bs-toggle="modal" data-bs-target="#editThesisEntriesModal" data-id="${data}">
                                    <span class="tf-icons bx bx-pencil bx-22px"></span>
                                </button>
                                <button type="button" class="btn btn-icon me-2 btn-label-danger deleteThesisEntry" data-id="${data}">
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


        $(document).on('click', '.edit-btn', function() {
            const thesisId = $(this).data('id'); // Get the thesis ID from the button's data attribute

            $.ajax({
                url: '{{ route("thesis.getTransactionByID") }}', // Route to get transaction by ID
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                data: {
                    id: thesisId // Pass the ID of the transaction
                },
                success: function(response) {
                    // Populate the modal fields with the retrieved data
                    const thesisEntry = response.thesisEntry;
                    const student = response.student;
                    const defense = response.defense;
                    const degree = response.degree;
                    const recorder = response.recorder;
                    const adviser = response.adviser;
                    const chairperson = response.chairperson;
                    const members = response.members;

                    console.log(adviser.id);

                    // Clear existing values before setting new ones
                    $('#editThesisEntriesModal input[name="thesis_id"]').val('');
                    $('#editThesisEntriesModal input[name="student_id"]').val('');
                    $('#editThesisEntriesModal input[name="student_first_name"]').val('');
                    $('#editThesisEntriesModal input[name="student_middle_name"]').val('');
                    $('#editThesisEntriesModal input[name="student_last_name"]').val('');
                    $('#editThesisEntriesModal input[name="student_suffix"]').val('');
                    $('#editThesisEntriesModal input[name="defense_date"]').val('');
                    $('#editThesisEntriesModal input[name="defense_time"]').val('');
                    $('#editThesisEntriesModal input[name="or_number"]').val('');
                    $('#editThesisEntriesModal select[name="degree"]').val('');
                    $('#editThesisEntriesModal select[name="defense_type"]').val('');
                    $('#editThesisEntriesModal input[name="recorder_first_name"]').val('');
                    $('#editThesisEntriesModal input[name="recorder_middle_name"]').val('');
                    $('#editThesisEntriesModal input[name="recorder_last_name"]').val('');
                    $('#editThesisEntriesModal input[name="recorder_suffix"]').val('');

                    // Set the values in the modal
                    $('#editThesisEntriesModal input[name="thesis_id"]').val(thesisEntry.id);
                    $('#editThesisEntriesModal input[name="student_id"]').val(student.id);
                    $('#editThesisEntriesModal input[name="student_first_name"]').val(student.first_name);
                    $('#editThesisEntriesModal input[name="student_middle_name"]').val(student.middle_name);
                    $('#editThesisEntriesModal input[name="student_last_name"]').val(student.last_name);
                    $('#editThesisEntriesModal input[name="student_suffix"]').val(student.suffix);
                    $('#editThesisEntriesModal input[name="defense_date"]').val(thesisEntry.defense_date);
                    $('#editThesisEntriesModal input[name="defense_time"]').val(thesisEntry.defense_time);
                    $('#editThesisEntriesModal input[name="or_number"]').val(thesisEntry.or_number);
                    $('#editThesisEntriesModal select[name="degree"]').val(degree.id);
                    $('#editThesisEntriesModal select[name="defense_type"]').val(defense.id);
                    $('#editThesisEntriesModal input[name="recorder_first_name"]').val(recorder.first_name);
                    $('#editThesisEntriesModal input[name="recorder_middle_name"]').val(recorder.middle_name);
                    $('#editThesisEntriesModal input[name="recorder_last_name"]').val(recorder.last_name);
                    $('#editThesisEntriesModal input[name="recorder_suffix"]').val(recorder.suffix);

                    // Populate Select2 for adviser and chairperson with selected IDs
                    const adviserSelect = $('#editThesisEntriesModal select[name="adviser_id"]');
                    const chairpersonSelect = $('#editThesisEntriesModal select[name="chairperson_id"]');

                    // Set Adviser
                    adviserSelect.append(new Option(adviser.employee_fname + ' ' + adviser.employee_lname, adviser.id, true, true)).trigger('change');
            
                    // Set Chairperson
                    chairpersonSelect.append(new Option(chairperson.employee_fname + ' ' + chairperson.employee_lname, chairperson.id, true, true)).trigger('change');

                      // Clear member fields before populating
                    for (let i = 1; i <= 4; i++) {
                        $(`#editThesisEntriesModal input[name="member_id_${i}"]`).val('');
                        $(`#editThesisEntriesModal input[name="member_first_name_${i}"]`).val('');
                        $(`#editThesisEntriesModal input[name="member_middle_name_${i}"]`).val('');
                        $(`#editThesisEntriesModal input[name="member_last_name_${i}"]`).val('');
                        $(`#editThesisEntriesModal input[name="member_suffix_${i}"]`).val('');
                        $(`#editThesisEntriesModal select[name="member_type_${i}"]`).val('');
                    }

                    // Populate members in the modal
                    members.forEach((member, index) => {
                        if (index < 4) { // Assuming you have 4 member fields
                            $(`#editThesisEntriesModal input[name="member_id_${index + 1}"]`).val(member.id);
                            $(`#editThesisEntriesModal input[name="member_first_name_${index + 1}"]`).val(member.first_name);
                            $(`#editThesisEntriesModal input[name="member_middle_name_${index + 1}"]`).val(member.middle_name);
                            $(`#editThesisEntriesModal input[name="member_last_name_${index + 1}"]`).val(member.last_name);
                            $(`#editThesisEntriesModal input[name="member_suffix_${index + 1}"]`).val(member.suffix);
                            $(`#editThesisEntriesModal select[name="member_type_${index + 1}"]`).val(member.member_type);
                        }
                    });

                    // Show the modal
                    $('#editThesisEntriesModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!',
                    });
                }
            });
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
            $('#trackingNumDisplay').hide();
            $('#generateTrackingNumberButton').hide();
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
            $('#generateTrackingNumberButton').show();


            // Reset all member/student/recorder sections to search view
            $('.inputGroupStudentDiv, .inputGroupMemberDiv, .inputGroupRecorderDiv').hide();
            $('.searchStudentDiv, .searchMemberDiv, .searchRecorderDiv').show();
        });

      
        $('#thesisEntryFormData').off('submit').on('submit', function(e) {

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
                        $('#thesisTable').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Thesis entry saved successfully!'
                        });

                        // Clear the form and reset it if needed
                        $('#cancelFormButton').click();

                        // Check table data or perform any additional logic
                        checkTableData();

                        // Reload the DataTable to reflect the new data
                        $('#thesisEntriesTable').DataTable().ajax.reload();
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

        // Handle delete button click
        $(document).on('click', '.deleteThesisEntry', function() {
            const thesisId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/thesis/delete/${thesisId}`, // Adjust the URL as necessary
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                                thesisTable.ajax.reload(); // Reload the DataTable
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
                }
            });
        });

        // Handle Generate Tracking Number button click
        $('#generateTrackingNumberButton').click(function() {
            $.ajax({
                url: '{{ route("thesis.generateTrackingNum") }}', // Route to generate tracking number
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        $('#trackingNumDisplay').show(); // Show tracking number display
                        $('#batchThesisID').text(response.batch_id); // Update the displayed tracking number
                        $('#thesisTransCount').text(response.processing_transactions); // Update the displayed tracking number
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to generate tracking number.',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!',
                    });
                }
            });
        });

        // Handle the submission of the edit form
        $(document).on('click', '.editSubmitBtn', function() {

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
               
                return false;
            }
           
            const formData = $('#editThesisEntriesModal').find('input, select').serialize() ;

            $.ajax({
                url: `/thesis/update`, // Adjust the URL as necessary
                type: 'PUT',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#thesisEntriesTable').DataTable().ajax.reload(); // Reload the DataTable
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Thesis entry updated successfully!'
                        });
                        $('#editThesisEntriesModal').modal('hide'); // Hide the modal
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

    });

    // refresh page
    $('#refresh').click(function() {
        window.location.reload();
    });

</script>
@endsection