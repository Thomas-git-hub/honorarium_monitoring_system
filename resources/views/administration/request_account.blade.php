@extends('components.app')



@section('content')


<!--VIEW DETAILS-->
    <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalToggleLabel">Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        Office:
                    </div>
                    <div class="col-md-8">
                        <b>Lorem Ipsum</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Full Name:
                    </div>
                    <div class="col-md-8">
                        <b>John Doe</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        ID Number:
                    </div>
                    <div class="col-md-8">
                        <b>000-0000</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Position/Academic Rank:
                    </div>
                    <div class="col-md-8">
                        <b>Lorem Ipsum</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Mother College:
                    </div>
                    <div class="col-md-8">
                        <b>College of Ipsum</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Contact Number:
                    </div>
                    <div class="col-md-8">
                        <b>09156748573</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Email:
                    </div>
                    <div class="col-md-8">
                        <b>lorem@bicol-u.edu.ph</b>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-label-danger">Close</button>
            </div>
        </div>
        </div>
    </div>


<div class="row mt-4 mb-3">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <h4 class="d-flex align-items-center"><i class='bx bxs-user-plus' style="font-size: 32px;"></i>Request Account</h4>

                <div class="row gap-1">
                    <div class="col-md">
                        <div class="card shadow-none bg-label-success">
                            <div class="card-header d-flex justify-content-end">
                                <small class="card-title text-success d-flex align-items-center"><i class='bx bx-question-mark' style="font-size: 32px;"></i></small>
                            </div>
                            <div class="card-body text-success">
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <h1 class="text-success text-center" style="font-size: 48px;">5</h1>
                                    </div>
                                    <div class="col-10">
                                        <h5 class="card-title text-success">Approved Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="card shadow-none bg-label-danger">
                            <div class="card-header d-flex justify-content-end">
                                <small class="card-title text-danger d-flex align-items-center"><i class='bx bxs-shield-x' style="font-size: 32px;"></i></small>
                            </div>
                            <div class="card-body text-danger">
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <h1 class="text-danger text-center" style="font-size: 48px;">5</h1>
                                    </div>
                                    <div class="col-10">
                                        <h5 class="card-title text-danger">Pending Requests</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md d-flex justify-content-end">
        <button class="btn btn-primary" id="requestButton">Request Account</button>
    </div>
</div>



<div class="row">
    <div class="col-md">
        <diuv class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="requestAccountTable" class="table table-borderless" style="width:100%">
                        <tbody class="text-center">
                            <!-- Data will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </diuv>
    </div>

    <div class="col-md" id="requestFormContainer" style="display: none;">
        <form id="requestForm" action="">
            <div class="card border border-primary shadow" id="requestFormCard">
                <div class="card-header">
                    <p class="text-secondary">Request Form</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-5">
                            <label for="defaultSelect" class="form-label">Request Account for:</label>
                            <select id="defaultSelect" class="form-select">
                            <option>Default select</option>
                            <option value="1">Administration</option>
                            <option value="2">Dean</option>
                            <option value="3">Budget Office</option>
                            <option value="4">Accounting</option>
                            <option value="5">Cashier</option>
                            <option value="6" id="facultyOption">Faculty</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3" id="selectFaculty" style="display: none;">
                        <label for="facultySelect" class="form-label">Select Faculty</label>
                        <select class="form-control" id="facultySelect" name="employee_id" style="width: 100%;">
                            <option selected disabled>Search by Name/Email...</option>
                            <!-- Other existing options can go here -->
                        </select>
                    </div>


                    <div id="fields" style="display:;">
                        <!-- Other fields as before -->
                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">First name</label>
                                <input type="text" class="form-control" name="first_name" id="firstName" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Enter Employee's First Name</small>
                            </div>
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Middle name</label>
                                <input type="text" class="form-control" name="middle_name" id="middleName" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Enter Employee's Middle Name</small>
                            </div>
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Last name</label>
                                <input type="text" class="form-control" name="last_name" id="lastName" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Enter Employee's Last Name</small>
                            </div>
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Suffix</label>
                                <input type="text" class="form-control" name="suffix" id="suffix" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Employee ID Number</label>
                                <input type="text" class="form-control" name="ee_number" id="ee_number" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Employee ID is Required</small>
                            </div>
                            <div class="col-md" style="display: none;" id="academicRankContainer">
                                <label for="academicRank" class="form-label">Academic Rank</label>
                                <input type="text" class="form-control" name="position" id="academicRank" placeholder="-" disabled/>
                            </div>
                            <div class="col-md" id="positionContainer">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" class="form-control" name="position" id="position" placeholder="-" />
                            </div>
                        </div>

                        <div class="row mb-3" id="motherCollege" style="display: none;">
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Mother College</label>
                                <input type="text" class="form-control" name="college" id="college" placeholder="-" aria-describedby="defaultFormControlHelp" disabled/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Contact No.</label>
                                <input type="text" class="form-control" name="contact" id="contact" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Enter Valid Contact Number</small>
                            </div>
                            <div class="col-md-8">
                                <label for="defaultFormControlInput" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Enter Valid Email Address</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <small class="small-button-warning text-danger" style="display:none;"><b> Warning, Please check the fields again.</b></small>
                        </div>
                        <div class="col-md d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary" id="submit">Send Request</button>
                            <button type="button" class="btn btn-label-danger" id="cancelRequestButton">Cancel</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>

</div>
@endsection



@section('components.specific_page_scripts')

{{-- DATATABLES --}}
<script>
    $(function () {
    var data = [
        {
            date: 'September 16, 2024',
            office: 'System Admin',
            faculty: '<strong>John Doe</strong>',
            email: 'user@bicol-u.edu.ph',
            status: 'pending',
            action: '<button type="button" class="btn btn-icon me-2 btn-label-primary mb-1" data-bs-toggle="modal" data-bs-target="#modalToggle"><span class="tf-icons bx bx-show-alt bx-22px"></span></button> <button type="button" class="btn btn-icon me-2 btn-label-success"><span class="tf-icons bx bxs-check-circle bx-22px"></span></button>',
        },
        // Add more objects as needed
    ];

    var table = $('#requestAccountTable').DataTable({
        processing: true,
        serverSide: false, // Set serverSide to false to use local data
        data: data,        // Provide the local data
        pageLength: 10,
        paging: true,      // Enable pagination

        dom: '<"top"lf>rt<"bottom"ip>',
        language: {
            search: "", // Remove the default search label
            searchPlaceholder: "Search..." // Set the placeholder text
        },
        columns: [
            { data: 'date', name: 'date', title: 'requested last' },
            { data: 'office', name: 'office', title: 'office of' }, // Map local data to the columns
            { data: 'faculty', name: 'faculty', title: 'Account For' },
            { data: 'email', name: 'email', title: 'email' },
            { data: 'status', name: 'status', title: 'status' },
            { data: 'action', name: 'action', title: 'action' },
        ],
    });
});
</script>
{{-- DATATABLES END--}}


{{-- FORM VALIDATION --}}
<script>
    $(document).ready(function() {
    // Show #academicRank and hide #position when 'Faculty' is selected
    $('#defaultSelect').on('change', function() {
        let selectedValue = $(this).val();

        if (selectedValue == '6') {  // 6 is the value of 'Faculty'
            $('#academicRankContainer').show();  // Show Academic Rank
            $('#selectFaculty').show();
            $('#motherCollege').show();
            $('#positionContainer').hide();  // Hide Position
        } else {
            $('#academicRankContainer').hide();  // Hide Academic Rank
            $('#selectFaculty').hide();
            $('#positionContainer').show();  // Show Position
        }
    });

    // Initial validation on document ready
    validateForm();
});

</script>

<script>
$(document).ready(function() {
    $('#requestButton').click(function() {
        $('#requestFormContainer').show();
    });

    // Function to capitalize the first letter of every word
    function capitalizeWords(str) {
        return str.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Function to validate email
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.(edu\.ph|com)$/;
        return emailRegex.test(email);
    }

    // Function to validate the contact number
    function validateContact(contact) {
        const regex = /^(\+639\d{9}|09\d{9})$/;
        return regex.test(contact);
    }

    // Function to validate all fields
    function validateForm() {
        let isValid = true;

        // Validate first name, middle name, last name, and suffix
        $('#firstName, #middleName, #lastName, #suffix').each(function() {
            if ($(this).val().trim() === '') {
                $(this).siblings('.small-warning').show();
                isValid = false;
            } else {
                $(this).siblings('.small-warning').hide();
            }
        });

        // Validate Employee ID Number
        if ($('#ee_number').val().trim() === '') {
            $('#ee_number').siblings('.small-warning').show();
            isValid = false;
        } else {
            $('#ee_number').siblings('.small-warning').hide();
        }

        // Validate Contact No.
        const contactVal = $('#contact').val().trim();
        if (!validateContact(contactVal)) {
            $('#contact').siblings('.small-warning').show();
            isValid = false;
        } else {
            $('#contact').siblings('.small-warning').hide();
        }

        // Validate Email
        const emailVal = $('#email').val().trim();
        if (!validateEmail(emailVal)) {
            $('#email').siblings('.small-warning').show();
            isValid = false;
        } else {
            $('#email').siblings('.small-warning').hide();
        }

        // Enable/Disable the submit button based on validation
        $('#submitButton').prop('disabled', !isValid);
    }

    // Restrict contact field to numeric input only and add prefix logic
    $('#contact').on('input', function() {
        let inputVal = this.value.replace(/[^0-9+]/g, '');

        // Add "639" if the user types "+6"
        if (inputVal.startsWith('+') && inputVal.length === 2) {
            this.value = '+639';
        }
        // Add "09" if the user types "0"
        else if (inputVal.startsWith('0') && inputVal.length === 1) {
            this.value = '09';
        }
        // Allow continued input after setting the prefix
        else {
            this.value = inputVal;
        }

        // Validate contact number and hide/show warning
        validateForm();
    });

    // Apply capitalization and hide/show warnings on input
    $('#firstName, #middleName, #lastName, #suffix').on('input', function() {
        $(this).val(capitalizeWords($(this).val()));
        validateForm();
    });

    // Validate email on input
    $('#email').on('input', function() {
        validateForm();
    });

    // Validate Employee ID Number on input
    $('#ee_number').on('input', function() {
        validateForm();
    });

    // Initial validation on document ready
    validateForm();
});
</script>
{{-- FORM VALIDATION END--}}


{{-- INPUT X SELECT OPTION FIELD BY NAME OR EMAIL --}}
<script>
$(document).ready(function() {
    $('#facultySelect').select2({
        placeholder: 'Search by Name/Email...',
        tags: true, // Allow custom values
        allowClear: true,
        width: '100%', // Ensure full width
        createTag: function(params) {
            // Custom logic to create a new tag from user input
            let term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            return {
                id: term, // Set the id to the custom input
                text: term, // Display the custom input
                newOption: true
            };
        },
        templateResult: function(data) {
            // Mark new entries with a special indication
            let $result = $('<span></span>');
            $result.text(data.text);
            if (data.newOption) {
                $result.append(' <em>(new)</em>');
            }
            return $result;
        }
    });
});
</script>
{{-- INPUT X SELECT FIELD NAME OR EMAIL  END--}}


<script>
    $(document).ready(function() {
    $('#cancelRequestButton').click(function() {
        // Clear all input fields
        $('#requestFormCard input[type="text"]').val('');
        $('#facultySelect').prop('selectedIndex', 0); // Reset the select option
        $('.small-warning').hide(); // Hide all warnings

        // Hide the request form card
        $('#requestFormContainer').hide();
    });
});
</script>

@endsection
