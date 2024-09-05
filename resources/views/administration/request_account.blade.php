@extends('components.app')



@section('content')
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
                hello world
            </div>
        </diuv>
    </div>

    <div class="col-md-8" id="requestFormContainer" style="display: none;">
        <form id="requestForm" action="">
            <div class="card border border-primary shadow">
                <div class="card-header">
                    <p class="text-secondary">Request Form</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-5">
                            <label for="facultySelect" class="form-label">Select Employee</label>
                            <select class="form-control" id="facultySelect" name="employee_id" style="width: 100%;">
                                <option selected disabled>Search by Name/Email...</option>
                            </select>
                        </div>
                    </div>

                    <div id="fields" style="display:;">
                        <!-- Other fields as before -->
                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">First name</label>
                                <input type="text" class="form-control" name="first_name" id="firstName" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Kindly input first name</small>
                            </div>
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Middle name</label>
                                <input type="text" class="form-control" name="middle_name" id="middleName" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Kindly input middle name</small>
                            </div>
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Last name</label>
                                <input type="text" class="form-control" name="last_name" id="lastName" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Kindly input last name</small>
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
                            <div class="col-md">
                                <label for="defaultFormControlInput" class="form-label">Academic Rank</label>
                                <input type="text" class="form-control" name="position" id="position" placeholder="-" aria-describedby="defaultFormControlHelp" disabled/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="col-md">
                                    <label for="defaultFormControlInput" class="form-label">Mother College</label>
                                    <input type="text" class="form-control" name="college" id="college" placeholder="-" aria-describedby="defaultFormControlHelp" disabled/>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Contact No.</label>
                                <input type="text" class="form-control" name="contact" id="contact" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Kindly input correct contact number</small>
                            </div>
                            <div class="col-md-8">
                                <label for="defaultFormControlInput" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                <small class="text-danger small-warning">Kindly input BU Email address</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <small class="small-button-warning text-danger" style="display:none;"><b> Warning, Please check the fields again.</b></small>
                        </div>
                        <div class="col-md d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary" id="submit" disabled>Send Request</button>
                            <button type="button" class="btn btn-label-danger">Cancel</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>
@endsection



@section('components.specific_page_scripts')

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

@endsection
