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

        <div class="col-md-4">
            {{-- <div class="card shadow-none">
                <div class="card-body">
                    <div class="card shadow-none" style="width: 100%;">
                        <img src="{{ asset('assets/myimg/avatar.jpg') }}" class="rounded-circle" alt="">
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <div class="">
                            <h5 class="text-Dark text-center d-flex justify-content-center"><b>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</b></h5>
                            <p class="text-Dark text-center d-flex justify-content-center"><small>{{ Auth::user()->position}}</small></p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center ">
                        <button type="" class="btn btn-label-primary w-100 gap-1"><i class='bx bxs-image-add'></i>Change Profile</button>
                    </div>
                </div>
            </div> --}}

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

        <div class="col-md">
            <div class="card shadow-none" id="profileDetails">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">Profile Details</small>
                    <ul class="list-unstyled my-3 py-1 border-bottom">
                        <li class="d-flex align-items-center mb-4">
                            <i class="bx bx-user"></i>
                            <span class="fw-medium mx-2">Full Name:</span>
                            <span class="text-dark"><b>{{ Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name }}</b></span>
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
                        <li class="d-flex align-items-center mb-4"><i class="bx bx-map"></i><span
                                class="fw-medium mx-2">Address:</span> <span>Zone 1 Dimatagpuan</span></li>
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

                    <div class="d-flex justify-content-center ">
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
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="middleName" class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" id="middleName" placeholder="Enter middle name" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->middle_name}}"/>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Surname</label>
                                        <input type="text" name="last_name" class="form-control" id="lastName" placeholder="Enter last name" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->last_name}}"/>
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
                                    <label for="address" class="form-label">Address <b class="text-danger">*</b></label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="Block-Lot/Street, Baranggay, City/Province, Postal Code" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->address}}"/>
                                </div>
                            </div>
                        </ul>
                        <ul class="list-unstyled my-3 py-1">
                            <div class="row">
                                <div class="col-md">
                                    <div class="">
                                        <label for="contact" class="form-label">Contact Number<b class="text-danger">*</b></label>
                                        <input type="text" name="contact" class="form-control" id="contact" placeholder="+639" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->contact}}"/>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="">
                                        <label for="email" class="form-label">Email Address<b class="text-danger">*</b></label>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="johndoe@bicol-u.edu.ph" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->email}}"/>
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
                <div class="card-body">
                        <small class="card-text d-flex align-items-center text-uppercase text-muted small gap-1">
                            <i class='bx bxs-key text-dark'></i> Change Password
                        </small>
                        <ul class="list-unstyled my-3 py-1">
                            <div class="col-md">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="defaultFormControlInput" class="form-label">Present Password</label>
                                            <input type="text" name="email" class="form-control" id="presentPassword" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="defaultFormControlInput" class="form-label">New Password</label>
                                            <input type="text" name="email" class="form-control" id="newPassword" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="defaultFormControlInput" class="form-label">Re-type New Password</label>
                                            <input type="text" name="email" class="form-control" id="retypePassword" placeholder="password" aria-describedby="defaultFormControlHelp" />
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
            </div>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-md-4">

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


</script>

<script>
    $(document).ready(function() {
        $('#updateProfileForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: '{{ route("profile.update") }}', // Your route
                type: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if(response.success) {
                        alert('Profile updated successfully!');
                    } else {
                        alert('Failed to update profile.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>

@endsection
