@extends('components.app')

@section('content')
    <div class="row mt-4">
        <h4 class="card-title text-secondary">Profile</h4>
    </div>

    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card">
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
                        <div class="btn btn-label-primary w-100 gap-1"><i class='bx bxs-image-add'></i>Change Profile</div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
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


            <div class="card mt-4">
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
            <div class="card" id="profileDetails">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">Profile Details</small>
                    <ul class="list-unstyled my-3 py-1 border-bottom">
                        <li class="d-flex align-items-center mb-4">
                            <i class="bx bx-user"></i>
                            <span class="fw-medium mx-2">Full Name:</span>
                            <span class="text-dark"><b>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name}}</b></span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="bx bx-crown"></i>
                            <span class="fw-medium mx-2">Academic Rank:</span>
                            <span class="text-dark"><b>{{ Auth::user()->position}}</b></span>
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
                            @if (Auth::user()->college->college_name)
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
            <div class="card" id="updateProfileDetails" style="display:none;">
                <div class="card-body">

                    <form action="" id="">
                        <small class="card-text text-uppercase text-muted small">Update Profile Details</small>
                        <ul class="list-unstyled my-3 py-1 border-bottom">
                            <div class="row">
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="defaultFormControlInput" class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" id="" placeholder="Enter Name" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->first_name}}"/>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="defaultFormControlInput" class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" id="" placeholder="Enter middle name" aria-describedby="defaultFormControlHelp" value="{{Auth::user()->middle_name}}"/>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="defaultFormControlInput" class="form-label">Surname</label>
                                        <input type="text" name="last_name" class="form-control" id="" placeholder="Enter last name" aria-describedby="defaultFormControlHelp" />
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="defaultFormControlInput" class="form-label">Suffix</label>
                                        <input type="text" name="last_name" class="form-control" id="" placeholder="ex. Jr." aria-describedby="defaultFormControlHelp" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="defaultFormControlInput" class="form-label">Academic Rank</label>
                                        {{-- show the academic rank in the field --}}
                                        <input type="text" name="position" class="form-control" id="" placeholder="academic rank" aria-describedby="defaultFormControlHelp" disabled/>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="defaultFormControlInput" class="form-label">Employee ID Number</label>
                                        <input type="text" name="ee_number" class="form-control" id="" placeholder="2024-2-0700" aria-describedby="defaultFormControlHelp" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <div class="mb-3">
                                        <label for="defaultFormControlInput" class="form-label">Mother College</label>
                                        {{-- show the academic rank in the field --}}
                                        <input type="text" name="college" class="form-control" id="" placeholder="College of Science" aria-describedby="defaultFormControlHelp" disabled/>
                                    </div>
                                </div>
                            </div>
                        </ul>

                        {{-- <small class="card-text text-uppercase text-muted small">Location</small> --}}
                        <ul class="list-unstyled my-3 py-1 border-bottom">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="defaultFormControlInput" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="" placeholder="Block-Lot/Street, Baranggay, City/Province, Postal Code" aria-describedby="defaultFormControlHelp" />
                                </div>
                            </div>
                        </ul>

                        {{-- <small class="card-text text-uppercase text-muted small">Contact Information</small> --}}
                        <ul class="list-unstyled my-3 py-1">
                            <div class="row">
                                <div class="col-md">
                                    <div class="">
                                        <label for="defaultFormControlInput" class="form-label">Contact Number</label>
                                        <input type="text" name="contact" class="form-control" id="" placeholder="+639" aria-describedby="defaultFormControlHelp" />
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="">
                                        <label for="defaultFormControlInput" class="form-label">Email Address</label>
                                        <input type="text" name="email" class="form-control" id="" placeholder="johndoe@bicol-u.edu.ph" aria-describedby="defaultFormControlHelp" />
                                    </div>
                                </div>
                            </div>
                        </ul>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary gap-1" id="save">Save</button>
                            <button type="" class="btn btn-label-danger gap-1" id="cancel">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="" id="displayPassword" style="">
                        <p class="text-info">Changing of Password every 3 months is highly recommended</p>
                        <ul class="list-unstyled my-3 py-1">
                            <li class="d-flex align-items-center" id="listPassword">
                                <i class='bx bxs-key'></i>
                                <span class="fw-medium mx-2">Password:</span>
                                <span>***********</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center ">
                            <div class="btn btn-label-info w-100 gap-1" id="updateDetailsBtn"><i class='bx bxs-cog'></i>Change Password</div>
                        </div>
                    </div>

                    <div class="" id="changePassword" style="">
                        <p class="text-info">Change Password</p>
                        <ul class="list-unstyled my-3 py-1">
                            <div class="col-md">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="defaultFormControlInput" class="form-label">Present Password</label>
                                            <input type="text" name="email" class="form-control" id="" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="defaultFormControlInput" class="form-label">New Password</label>
                                            <input type="text" name="email" class="form-control" id="" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="defaultFormControlInput" class="form-label">Re-type New Password</label>
                                            <input type="text" name="email" class="form-control" id="" placeholder="password" aria-describedby="defaultFormControlHelp" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-primary gap-1" id="updateDetailsBtn"><i class='bx bxs-cog'></i>Save</button>
                        <button class="btn btn-label-danger gap-1" id="updateDetailsBtn"><i class='bx bxs-cog'></i>Save</button>
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
</script>

@endsection
