@extends('components.app')

@section('content')
    <div class="row mt-4">
        <h4 class="card-title text-secondary">Profile</h4>
    </div>

    <div class="row mt-4">
        <div class="col-md">
            <div class="card bg-primary">
                <div class="card-body">
                    <h1 class="text-white">{{ Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name }}</h1>
                    <h6 class="text-white">{{ Auth::user()->position}}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-md">
            <div class="card shadow-none" id="profileDetails">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">Profile Details</small>
                    <ul class="list-unstyled my-3 py-1 border-bottom">
                        <li class="d-flex align-items-center mb-4">
                            <i class="bx bx-user"></i>
                            <span class="fw-medium mx-2">Full Name:</span>
                            <span class="text-dark"><b>{{ Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name . ' ' . Auth::user()->suffix }}</b></span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="bx bx-crown"></i>
                            <span class="fw-medium mx-2">Academic Rank:</span>
                            @if (Auth::user()->position)
                                <span class="text-dark"><b>{{ Auth::user()->position}}</b></span>
                            @else
                                <span class="text-danger"><small>No Academic Rank Found</small></span>
                            @endif
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class='bx bx-id-card'></i>
                            <span class="fw-medium mx-2">ID Number:</span>
                            @if (Auth::user()->ee_number)
                                <span class="text-dark"><b>{{Auth::user()->ee_number}}</b></span>
                            @else
                            <span class="text-danger"><small>No ID Number Found</small></span>
                            @endif
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class='bx bxs-school'></i>
                            <span class="fw-medium mx-2">Mother College:</span>
                            @if (Auth::user()->college)
                                <span class="text-dark"><b>{{Auth::user()->college->college_name}}</b></span>
                            @else
                            <span class="text-danger"><small>No Mother College Found</small></span>
                            @endif
                        </li>
                    </ul>

                    <small class="card-text text-uppercase text-muted small">Location</small>
                    <ul class="list-unstyled my-3 py-1 border-bottom">
                        <li class="d-flex align-items-center mb-4"><i class="bx bx-map"></i>
                            <span class="fw-medium mx-2">Address:</span>
                            <span class="text-dark"><b>{{Auth::user()->address}}</b></span>
                        </li>
                    </ul>
                    <small class="card-text text-uppercase text-muted small">Contacts</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <i class="bx bx-phone"></i>
                            <span class="fw-medium mx-2">Contact:</span>
                            @if (Auth::user()->contact)
                                <span class="text-dark"><b>{{ Auth::user()->contact}}</b></span>
                            @else
                            <span class="text-danger"><small>No Contact Number Found</small></span>
                            @endif
                        </li>
                        <li class="d-flex align-items-center mb-4"><i class="bx bx-envelope">
                            </i><span class="fw-medium mx-2">Email:</span>
                            <span class="text-primary">{{ Auth::user()->email}}</span>
                        </li>
                    </ul>

                    <div class="">
                        <small class="text-primary">Kindly Fill up all missing information above.</small>
                        <div class="btn btn-label-primary w-100 gap-1" id="updateDetailsBtn"><i class='bx bxs-cog'></i>Update Details</div>
                    </div>
                </div>
            </div>

            {{-- Update Form --}}
            <div class="card shadow border border-primary" id="updateProfileDetails" style="display:none;" >
                <div class="card-body">

                    <form id="updateProfileForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <small class="card-text d-flex align-items-center text-uppercase text-muted small gap-1">
                            <i class='bx bxs-cog text-dark'></i> Update Profile Details
                        </small>
                        <ul class="list-unstyled my-3 py-1 border-bottom">
                            <div class="row">
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" id="firstName" placeholder="Enter Name" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->first_name}}"/>
                                        <small class="text-danger note" id="noteFirstName">Kindly enter your first name</small>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="middleName" class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" id="middleName" placeholder="Enter middle name" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->middle_name}}"/>
                                        <small class="text-danger note" id="noteMiddleName">Kindly enter your middle name</small>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Surname</label>
                                        <input type="text" name="last_name" class="form-control" id="lastName" placeholder="Enter last name" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->last_name}}"/>
                                        <small class="text-danger note" id="noteLastName">Kindly enter your last name</small>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="suffix" class="form-label">Suffix</label>
                                        <input type="text" name="suffix" class="form-control" id="suffix" placeholder="ex. Jr." aria-describedby="defaultFormControlHelp" value="{{Auth::user()->suffix}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Academic Rank</label>
                                        <input type="text" name="position" class="form-control" id="position" placeholder="No Academic Rank Found" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->position}}" disabled/>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="ee_number" class="form-label">Employee ID Number<b class="text-danger">*</b></label>
                                        <input type="text" name="ee_number" class="form-control" id="ee_number" placeholder="2024-2-0700" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->ee_number}}"/>
                                        <small class="text-danger note" id="note">ID Number is Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="college" class="form-label">Mother College</label>
                                        <input type="text" name="college" class="form-control" id="college" placeholder="No College Found" aria-describedby="defaultFormControlHelp" value="{{ Auth::user()->college ? Auth::user()->college->college_name : 'No College Found' }}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <ul class="list-unstyled my-3 py-1 border-bottom">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="Block-Lot/Street, Baranggay, City/Province, Postal Code" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->address}}"/>
                                    <small class="text-danger note" id="noteAddress">Kindly enter your address</small>
                                </div>
                            </div>
                        </ul>
                        <ul class="list-unstyled my-3 py-1">
                            <div class="row">
                                <div class="col-md">
                                    <div class="">
                                        <label for="contact" class="form-label">Contact Number</label>
                                        <input type="text" name="contact" class="form-control" id="contact" placeholder="+639" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->contact}}"/>
                                        <small class="text-danger note" id="noteContact">Kindly enter your contact number</small>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="johndoe@bicol-u.edu.ph" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->email}}"/>
                                        <small class="text-danger note" id="noteEmail">Email address is Required</small>
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary gap-1" id="save">Save</button>
                            <button type="button" class="btn btn-label-danger gap-1" id="cancel">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-none">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">Status</small>
                    <ul class="list-unstyled my-3 py-1 border-bottom">
                        <li class="d-flex align-items-center">
                            <i class="bx bx-check"></i><span class="fw-medium mx-2">Account Status:</span><b class="text-success">Active</b>
                        </li>
                    </ul>

                    {{-- FOR SUPER ADMIN SIDE ONLY --}}
                    <div style="display: none;">
                        <small>Disabling this account means there are technical difficulties encountered on this account</small>
                        <button class="btn btn-label-danger w-100">Disable Account</button>
                    </div>
                </div>
            </div>

            <div class="card shadow-none mt-4" id="changePasswordDiv">
                <div class="card-body">
                    <div class="" style="">
                        <p class="text-info">Changing of Password every 3 months is highly recommended</p>
                        <ul class="list-unstyled my-3 py-1">
                            <div class="btn btn-label-info w-100 gap-1" id="changePasswordBtn"><i class='bx bxs-cog'></i>Change Password?</div>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card shadow border border-primary mt-4" id="changePasswordField" style="display:none;">
                <form id="changePasswordForm">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            <small class="card-text d-flex align-items-center text-uppercase text-muted small gap-1">
                                <i class='bx bxs-key text-dark'></i> Change Password
                            </small>
                            <ul class="list-unstyled my-3 py-1">
                                <div class="col-md">
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="mb-3">
                                                <label for="defaultFormControlInput" class="form-label">Present Password</label>
                                                <input type="password" name="current_password" class="form-control" id="current_password" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                                <div id="current_passwordError" class="invalid-feedback"></div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="mb-3">
                                                <label for="defaultFormControlInput" class="form-label">New Password</label>
                                                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                                <div id="new_passwordError" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="mb-3">
                                                <label for="defaultFormControlInput" class="form-label">Re-type New Password</label>
                                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                                <div id="new_password_confirmationError" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary gap-1" id="saveChangePassword">Save</button>
                                <button type="submit" class="btn btn-label-danger gap-1" id="cancelChangePassword">Cancel</button>
                            </div>
                    </div>
                </form>
            </div>

            <div class="card shadow-none mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-1">
                        <i class='bx bxs-error-alt text-danger'></i>
                        <small class="card-text text-uppercase text-danger small">Report a Problem!</small>
                    </div>

                    <p class="text-secondary mt-2"><small>If you encounter any issues while navigating the system, please send an email to <b class="text-primary">user@gmail.com</b> or click the message button below to contact the system administrator directly.</small></p>
                    <small class="text-danger">Send email to System Administrator now?</small>
                    <button class="btn btn-label-danger w-100 gap-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd" id="sendEmailBtn"><i class='bx bxs-envelope' ></i>Email</button>
                </div>
            </div>

        </div>

    </div>

    @include('administration.email_toast')

@endsection


@section('components.specific_page_scripts')

<script>
    $('#updateDetailsBtn').click(function() {
        $('#profileDetails').hide();
        $('#updateProfileDetails').show();
    });

    $('#cancel').click(function() {
        $('#profileDetails').show();
        $('#updateProfileDetails').hide();
    });

    $('#changePasswordBtn').click(function() {
        $('#changePasswordField').show();
        $('#changePasswordDiv').hide();
    });



    $(document).ready(function() {
        $('#cancelChangePassword').click(function(e) {
            e.preventDefault(); // Prevent form submission if needed

            // Hide the change password field
            $('#changePasswordField').hide();
            $('#changePasswordDiv').show();

            // Clear the password fields
            $('#presentPassword').val('');
            $('#newPassword').val('');
            $('#retypePassword').val('');
        });
    });


    $(document).ready(function() {
        // Function to toggle visibility of the small tags
        function toggleNotes() {
            // Loop through each input and its corresponding small tag
            $('#updateProfileForm input').each(function() {
                let inputField = $(this);
                let note = inputField.siblings('.note'); // Get the corresponding small tag

                if (inputField.val().trim() !== '') {
                    note.hide();  // Hide the note if the field has a value
                } else {
                    note.show();  // Show the note if the field is empty
                }
            });
        }

        // Initial call to toggleNotes when the page loads
        toggleNotes();

        // Call toggleNotes function whenever an input field is changed
        $('#updateProfileForm input').on('input', function() {
            toggleNotes();
        });
    });
</script>


{{-- JS For Updating Profile --}}


<script>
$(document).ready(function() {
    // Store the original values of the form fields
    const originalValues = {
        firstName: $('#firstName').val(),
        middleName: $('#middleName').val(),
        lastName: $('#lastName').val(),
        suffix: $('#suffix').val(),
        eeNumber: $('#ee_number').val(),
        address: $('#address').val(),
        contact: $('#contact').val(),
        email: $('#email').val()
    };

    // Function to check if any field values have changed
    function hasChanges() {
        return $('#firstName').val() !== originalValues.firstName ||
               $('#middleName').val() !== originalValues.middleName ||
               $('#lastName').val() !== originalValues.lastName ||
               $('#suffix').val() !== originalValues.suffix ||
               $('#ee_number').val() !== originalValues.eeNumber ||
               $('#address').val() !== originalValues.address ||
               $('#contact').val() !== originalValues.contact ||
               $('#email').val() !== originalValues.email;
    }

    // Function to validate the contact number
    function validateContactNumber(contact) {
        const regex = /^(\+639|09)\d{9}$/;
        return regex.test(contact);
    }

    // Restrict contact field to numeric input only and add prefix logic
    $('#contact').on('input', function() {
        let inputVal = this.value.replace(/[^0-9+]/g, '');

        // Add "39" if the user types "+6"
        if (inputVal === '+') {
            this.value = '+639';
        }
        // Add "9" if the user types "0"
        else if (inputVal === '0') {
            this.value = '09';
        }
        // Allow continued input after setting the prefix
        else {
            this.value = inputVal;
        }
    });

    $('#updateProfileForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Check for changes
        if (!hasChanges()) {
            Swal.fire({
                icon: 'info',
                title: 'No Updates',
                text: 'No changes have been made to your profile.',
            });
            return;
        }

        // Validate the contact number
        const contact = $('#contact').val();
        if (!validateContactNumber(contact)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Contact Number',
                text: 'Please enter a valid Philippine contact number.',
            });
            return;
        }

        // Proceed with form submission
        $.ajax({
            url: '{{ route("profile.update") }}', // Your route
            type: 'POST',
            data: $(this).serialize(), // Serialize the form data
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update Success',
                        text: response.message,
                    }).then(function() {
                        // Reload the page
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'An Error Occurred!',
                    text: 'Please try again later.',
                });
            }
        });
    });
});
</script>

<script>
    $(document).ready(function(){

        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('password.change') }}', 
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: true,
                        });
                        $('#changePasswordForm')[0].reset();
                    } else {
                        var errors = response.errors;
                        Object.keys(errors).forEach(function(key) {
                            var inputField = $('#changePasswordForm [name=' + key + ']');
                            inputField.addClass('is-invalid');
                            $('#changePasswordForm #' + key + 'Error').text(errors[key][0]);
                        });
                    }
                },
                error: function(xhr) {
                    hideLoader();
                    console.log(xhr.responseText);
                }
            });
        });
    })
</script>

<script>

    $('#sendEmailBtn').click(function() {
        
        $('#sendEmailToast').toast('show');
        $('.checklist').hide();

        $.ajax({
            url: '{{ route("get.super.admins") }}',
            method: 'GET',
            success: function(response) {
                
                // Check if response is an array and has items
                if (Array.isArray(response) && response.length > 0) {
                    // Get the first super admin from the array
                    const superAdmin = response[0];
                    
                    // Create formatted name
                    const fullName = `${superAdmin.first_name} ${superAdmin.last_name}`;
                    
                    // Update the hidden input and the To: container
                    $('#user_id').val(superAdmin.id);
                    $('.card-body .send_to').html(`
                        <b>To:&nbsp;</b> ${fullName}&nbsp;
                        <small class="text-secondary" style="font-style: italic;">${superAdmin.email}</small>
                    `);

                   
                    
                    // Set default subject and clear message
                    $('#floatingInput').val('Report a Problem');
                } else {
                    console.error('No super admins found');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        }); 
    });

</script>

{{-- SENDING EMAIL FOR SPINNER AND STATUS START --}}
<script>
    $(document).ready(function() {
        // Ensure success and failed messages are hidden on page load
        // $('#emailSuccess').hide();
        // $('#emailFailed').hide();

        $('#toastSuccess').show();
        $('#sendingFailed').show();


        $('#sendButton').on('click', function(event) {
            event.preventDefault();
            $('#spinner').show();

            var formData = {
                user_id: $('#user_id').val(),
                subject: $('#floatingInput').val(),
                message: $('#emailTextArea').val(),
                employee_id: $('#facultySelect').val(),
               
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('send.email') }}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#spinner').hide();

                    if (response.success) {
                        $('#toastSuccess').toast('show');

                        Swal.fire({
                            icon: 'success',
                            title: 'Sent!',
                            text: response.message,
                        }).then(function() {
                            // This will reload the page once the "OK" button is clicked
                            location.reload();
                        });


                    } else {
                        $('#sendingFailed').toast('show');
                    }
                },
                error: function(xhr, status, error) {
                    $('#spinner').hide();
                    $('#sendingFailed').toast('show');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Occurred During Form Submission',
                        text: 'Please ensure all fields are filled out correctly and none are left blank',
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

    });
</script>
{{-- SENDING EMAIL FOR SPINNER AND STATUS END--}}


@endsection
