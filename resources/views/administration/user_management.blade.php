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
                        <b id="office">Lorem Ipsum</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Full Name:
                    </div>
                    <div class="col-md-8">
                        <b id="faculty">John Doe</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        ID Number:
                    </div>
                    <div class="col-md-8">
                        <b id="id_num">000-0000</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Position/Academic Rank:
                    </div>
                    <div class="col-md-8">
                        <b id="position">Lorem Ipsum</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Mother College:
                    </div>
                    <div class="col-md-8">
                        <b id="college">College of Ipsum</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Contact Number:
                    </div>
                    <div class="col-md-8">
                        <b id="contact">09156748573</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        Email:
                    </div>
                    <div class="col-md-8">
                        <b id="email">lorem@bicol-u.edu.ph</b>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button class="btn btn-label-danger">Close</button>
            </div> --}}
        </div>
        </div>
    </div>


    <div class="row mt-4 mb-3">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-flex align-items-center"><i class='bx bxs-user-plus' style="font-size: 32px;"></i>Create Account</h4>

                    <div class="row gap-1">
                        <div class="col-md">
                            <div class="card shadow-none bg-label-success">
                                <div class="card-header d-flex justify-content-end">
                                    <small class="card-title text-success d-flex align-items-center"><i class='bx bx-question-mark' style="font-size: 32px;"></i></small>
                                </div>
                                <div class="card-body text-success">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md d-flex align-items-center gap-3">
                                            <h1 class="text-success text-center d-flex align-items-center" id="UserCount" style="font-size: 48px;">0</h1>
                                            <h5 class="card-title text-success">Numbers of Active User</h5>
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
            <button class="btn btn-primary" id="requestButton">Add User Account</button>
        </div>
    </div>

    <div class="row mb-3" id="requestFormContainer" style="display: none;">
        <div class="col-md">
            <form id="requestForm">
                @csrf
                <div class="card border border-primary shadow" id="requestFormCard">
                    <div class="card-header">
                        <p class="text-secondary">Create New Account</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-5">
                                <label for="usertype" class="form-label">Request Account for:</label>
                                <select id="usertype" class="form-select" name="usertype">
                                <option value="">Default select</option>
                                <option value="1">Administration</option>
                                <option value="2">Dean</option>
                                <option value="3">Budget Office</option>
                                <option value="4">Accounting</option>
                                <option value="5">Cashier</option>
                                <option value="6" id="facultyOption">Faculty</option>
                                </select>
                                <span class="error-message text-danger small-warning"></span>
                            </div>
                        </div>

                        <div class="row mb-3" id="selectFaculty" style="display: none;">
                            <label for="facultySelect" class="form-label">Select Faculty</label>
                            <select class="form-control" id="facultySelect" name="employee_id" id="employee_id" style="width: 100%;">
                                <option selected disabled>Search by Name/Email...</option>
                                <!-- Other existing options can go here -->
                            </select>
                        </div>


                        <div id="fields" style="display:;">
                            <!-- Other fields as before -->
                            <div class="row mb-3">
                                <div class="col-md">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                    {{-- <small class="text-danger small-warning">Enter Employee's First Name</small> --}}
                                     <span class="error-message text-danger small-warning"></span>
                                </div>
                                <div class="col-md">
                                    <label for="middle_name" class="form-label">Middle name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                    {{-- <small class="text-danger small-warning">Enter Employee's Middle Name</small> --}}
                                     <span class="error-message text-danger small-warning"></span>
                                </div>
                                <div class="col-md">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                    {{-- <small class="text-danger small-warning">Enter Employee's Last Name</small> --}}
                                     <span class="error-message text-danger small-warning"></span>

                                </div>
                                <div class="col-md">
                                    <label for="suffix" class="form-label">Suffix</label>
                                    <input type="text" class="form-control" name="suffix" id="suffix" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md">
                                    <label for="ee_number" class="form-label">Employee ID Number</label>
                                    <input type="text" class="form-control" name="ee_number" id="ee_number" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                    {{-- <small class="text-danger small-warning">Employee ID is Required</small> --}}
                                     <span class="error-message text-danger small-warning"></span>
                                </div>
                                <div class="col-md" style="display: none;" id="academicRankContainer">
                                    <label for="academicRank" class="form-label">Academic Rank</label>
                                    <input type="hidden" class="form-control" name="academicRankValue" id="academicRankValue"/>
                                    <input type="text" class="form-control" name="academicRank" id="academicRank" placeholder="-" disabled/>
                                </div>
                                <div class="col-md" id="positionContainer">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control" name="position" id="position" placeholder="-" />
                                </div>
                            </div>

                            <div class="row mb-3" id="motherCollege" style="display: none;">
                                <div class="col-md">
                                    <label for="mother_college" class="form-label">Mother College</label>
                                    <input type="hidden" class="form-control" name="collge_NUM" id="collge_NUM"/>
                                    <input type="text" class="form-control" name="mother_college" id="mother_college" placeholder="-" disabled/>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="contact_num" class="form-label">Contact No.</label>
                                    <input type="text" class="form-control" name="contact_num" id="contact_num" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                    {{-- <small class="text-danger small-warning">Enter Valid Contact Number</small> --}}
                                     <span class="error-message text-danger small-warning"></span>
                                </div>
                                <div class="col-md-8">
                                    <label for="user_email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="user_email" id="user_email" placeholder="-" aria-describedby="defaultFormControlHelp"/>
                                    {{-- <small class="text-danger small-warning">Enter Valid Email Address</small> --}}
                                     <span class="error-message text-danger small-warning"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <small class="small-button-warning text-danger warning" style="display:none;"><b> Warning, Please check the fields again.</b></small>
                            </div>
                            <div class="col-md d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary" id="submit">Enter</button>
                                <button type="button" class="btn btn-label-danger" id="cancelRequestButton">Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

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
    </div>
@endsection



@section('components.specific_page_scripts')

<script>
    $(document).ready(function() {
        // Fetch active user count on page load
        $.ajax({
            url: '{{ route('user_management.user_count') }}', // Adjust the route as necessary
            type: 'GET',
            success: function(response) {
                $('#UserCount').text(response.active_user_count);
            },
            error: function(xhr) {
                console.error('Error fetching user count:', xhr);
            }
        });
    });
</script>

{{-- DATATABLES --}}
<script>
    $(function () {

        var table = $('#requestAccountTable').DataTable({
            processing: true,
            serverSide: true, // Set serverSide to false to use local data
            ajax: '{{ route('user_management.list') }}',
            pageLength: 10,
            paging: true,      // Enable pagination

            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            columns: [
                { data: 'faculty', name: 'faculty', title: 'Account For' },
                { data: 'usertype', name: 'usertype', title: 'User Type' }, // Map local data to the columns
                { data: 'email', name: 'email', title: 'email' },
                { data: 'date', name: 'date', title: 'created' },
                { data: 'status', name: 'status', title: 'status' },
                { data: 'action', name: 'action', title: 'action' },
                { data: 'contact', name: 'contact', title: 'contact', visible: false },
                { data: 'id', name: 'id', title: 'id', visible: false },
                { data: 'position', name: 'position', title: 'position', visible: false },
                { data: 'college', name: 'college', title: 'college', visible: false },
                { data: 'ee_number', name: 'ee_number', title: 'ee_number', visible: false },
                { data: 'office', name: 'office', title: 'office', visible: false },
            ],
        });

        // Handle View button click
        $('#requestAccountTable').off('click').on('click', '.view-btn', function() {
            var row = $(this).closest('tr');
            var rowData = table.row(row).data();

            // // Populate modal fields

            $('#faculty').text(rowData.faculty);
            $('#id_num').text(rowData.faculty);
            $('#office').text(rowData.office);
            $('#position').text(rowData.position);
            $('#email').text(rowData.email);
            $('#contact').text(rowData.contact);
            $('#college').text(rowData.college);
            $('#id_num').text(rowData.ee_number);
            // $('#editDateReceived').val(rowData.date_of_trans);
            // $('#editFaculty').val(rowData.faculty.replace(/<[^>]+>/g, ''));
            // $('#editIdNumber').val(rowData.id_number);
            // $('#editAcademicRank').val(rowData.academic_rank.replace(/<[^>]+>/g, ''));
            // $('#editCollege').val(rowData.college);
            // $('#editSemester').val(rowData.sem);
            // $('#editSemesterYear').val(rowData.year).change();
            // $('#editHonorarium').val(rowData.honorarium_id).change();

            // $('#editMonthOf').val(rowData.month.month_number).change(); // Set the month


            $('#editRowIndex').val(table.row(row).index());

            // Show modal
            $('#modalToggle').modal('show');
        });

    });
</script>
{{-- DATATABLES END--}}


{{-- FORM VALIDATION --}}
<script>
    $(document).ready(function() {
    // Show #academicRank and hide #position when 'Faculty' is selected
        $('#usertype').on('change', function() {
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
        // validateForm();
    });

</script>

<script>
    $(document).ready(function() {
        $('#requestButton').click(function() {
            $('#requestFormContainer').show();
            $('.warning').hide();

        });

        $('#requestForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('user_management.store') }}',
                data: $(this).serialize(),
                beforeSend: function() {
                    Swal.fire({
                        title: 'Registration is being processed',
                        html: '<div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Registered!!',
                        showClass: {
                            popup: 'animate__animated animate__bounceIn'
                        },
                        customClass: {
                            confirmButton: 'btn btn-success'
                        },
                        buttonsStyling: false
                    }).then(() => {
                        $('#requestAccountTable').DataTable().ajax.reload(); // Reload the DataTable
                        $('#requestFormContainer').hide(); // Hide the form container
                        clearForm(); // Clear the form fields
                    });
                },
                error: function(xhr) {
                    // Clear previous error messages
                    $('.error-message').text('');
                    $('.warning').hide();

                    if (xhr.status === 409) {
                        // Show SweetAlert for error 409
                        Swal.fire({
                            icon: 'error',
                            title: 'Conflict',
                            text: 'The user already exists.',
                            showClass: {
                                popup: 'animate__animated animate__shakeX'
                            },
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        });
                    } else {
                        // Loop through the validation errors and display them under each field
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#' + key).next('.error-message')
                                .text(value[0])
                                .addClass('small-warning text-danger');
                        });
                    }

                    $('.warning').show(); // Show warning if necessary
                }
            });
        });


        // Function to capitalize the first letter of every word
        function capitalizeWords(str) {
            return str.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        }

        function clearForm() {
            $('#requestForm')[0].reset(); // Reset the form fields
            $('.error-message').text(''); // Clear any error messages
            $('.small-warning').removeClass('text-danger'); // Remove warning classes
            $('#selectFaculty').hide(); // Hide faculty selection if it was shown
            $('#facultySelect').val(null).trigger('change');

            $('#collge_NUM').val('');
            $('#academicRank').val('');
            $('#academicRankValue').val('');
            $('#mother_college').val('').prop('disabled', true);
            $('#motherCollege').hide();

        }

        $('#facultySelect').on('select2:select', function(e) {
            var selectedOption = $(this).select2('data')[0]; // Get the selected option data
            var facultyFirstName = `${selectedOption.employee_fname} `;
            var facultyMiddleName = `${selectedOption.employee_mname}`;
            var facultyLastName = `${selectedOption.employee_lname}`;
            var facultyEmail = selectedOption.email; // Get the email from the selected data
            var facultyAcademicRank = selectedOption.academic; // Get the email from the selected data
            var facultyAcademicRankValue = selectedOption.academic; // Get the email from the selected data
            var facultyId = selectedOption.id;
            var facultyeenum = selectedOption.employee_no;
            var facultycollege = selectedOption.college;
            var facultycollge_id = selectedOption.collgeID;

            // Update the hidden input and the To: container
            $('#user_id').val(facultyId);
            $('#first_name').val(facultyFirstName);
            $('#middle_name').val(facultyMiddleName);
            $('#last_name').val(facultyLastName);
            $('#user_email').val(facultyEmail);
            $('#ee_number').val(facultyeenum);
            $('#academicRank').val(facultyAcademicRank);
            $('#academicRankValue').val(facultyAcademicRankValue);
            $('#mother_college').val(facultycollege);
            $('#collge_NUM').val(facultycollge_id);
        });

        $('#facultySelect').select2({
            placeholder: 'Search by Name/ID Number...',
            allowClear: true,
            ajax: {
                url: '{{ route('getUser') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(data) {
                    var options = [];
                    var searchTerm = $('#facultySelect').data('select2').dropdown.$search.val();

                    data.forEach(function(user) {
                        options.push({
                            id: user.id,
                            employee_fname: user.employee_fname,
                            employee_lname: user.employee_lname,
                            employee_mname: user.employee_mname,
                            employee_no: user.employee_no,
                            email: user.email,
                            academic: user.employee_academic_rank,
                            college: user.college_name,
                            collgeID: user.college_id,
                            text: `${user.employee_fname} ${user.employee_lname}`,
                        });
                    });

                    return {
                        results: options
                    };
                },
                cache: true
            }
        });

        // Function to validate all fields
        // function validateForm() {
        //     let isValid = true;

        //     // Validate first name, middle name, last name, and suffix
        //     $('#firstName, #middleName, #lastName, #suffix').each(function() {
        //         if ($(this).val().trim() === '') {
        //             $(this).siblings('.small-warning').show();
        //             isValid = false;
        //         } else {
        //             $(this).siblings('.small-warning').hide();
        //         }
        //     });

        //     // Validate Employee ID Number
        //     if ($('#ee_number').val().trim() === '') {
        //         $('#ee_number').siblings('.small-warning').show();
        //         isValid = false;
        //     } else {
        //         $('#ee_number').siblings('.small-warning').hide();
        //     }

        //     // Validate Contact No.
        //     const contactVal = $('#contact').val().trim();
        //     if (!validateContact(contactVal)) {
        //         $('#contact').siblings('.small-warning').show();
        //         isValid = false;
        //     } else {
        //         $('#contact').siblings('.small-warning').hide();
        //     }

        //     // Validate Email
        //     const emailVal = $('#email').val().trim();
        //     if (!validateEmail(emailVal)) {
        //         $('#email').siblings('.small-warning').show();
        //         isValid = false;
        //     } else {
        //         $('#email').siblings('.small-warning').hide();
        //     }

        //     // Enable/Disable the submit button based on validation
        //     $('#submitButton').prop('disabled', !isValid);
        // }

        //  // Function to validate email
        //  function validateEmail(email) {
        //     const emailRegex = /^[^\s@]+@[^\s@]+\.(edu\.ph|com)$/;
        //     return emailRegex.test(email);
        // }

        // // Function to validate the contact number
        // function validateContact(contact) {
        //     const regex = /^(\+639\d{9}|09\d{9})$/;
        //     return regex.test(contact);
        // }

        // // Restrict contact field to numeric input only and add prefix logic
        // $('#contact').on('input', function() {
        //     let inputVal = this.value.replace(/[^0-9+]/g, '');

        //     // Add "639" if the user types "+6"
        //     if (inputVal.startsWith('+') && inputVal.length === 2) {
        //         this.value = '+639';
        //     }
        //     // Add "09" if the user types "0"
        //     else if (inputVal.startsWith('0') && inputVal.length === 1) {
        //         this.value = '09';
        //     }
        //     // Allow continued input after setting the prefix
        //     else {
        //         this.value = inputVal;
        //     }

        //     // Validate contact number and hide/show warning
        //     validateForm();
        // });

        // // Apply capitalization and hide/show warnings on input
        // $('#firstName, #middleName, #lastName, #suffix').on('input', function() {
        //     $(this).val(capitalizeWords($(this).val()));
        //     validateForm();
        // });

        // // Validate email on input
        // $('#email').on('input', function() {
        //     validateForm();
        // });

        // // Validate Employee ID Number on input
        // $('#ee_number').on('input', function() {
        //     validateForm();
        // });

        // Initial validation on document ready
        // validateForm();
    });
</script>
{{-- FORM VALIDATION END--}}


{{-- INPUT X SELECT OPTION FIELD BY NAME OR EMAIL --}}
<script>
    $(document).ready(function() {
        // $('#facultySelect').select2({
        //     placeholder: 'Search by Name/Email...',
        //     tags: true, // Allow custom values
        //     allowClear: true,
        //     width: '100%', // Ensure full width
        //     createTag: function(params) {
        //         // Custom logic to create a new tag from user input
        //         let term = $.trim(params.term);
        //         if (term === '') {
        //             return null;
        //         }
        //         return {
        //             id: term, // Set the id to the custom input
        //             text: term, // Display the custom input
        //             newOption: true
        //         };
        //     },
        //     templateResult: function(data) {
        //         // Mark new entries with a special indication
        //         let $result = $('<span></span>');
        //         $result.text(data.text);
        //         if (data.newOption) {
        //             $result.append(' <em>(new)</em>');
        //         }
        //         return $result;
        //     }
        // });


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
