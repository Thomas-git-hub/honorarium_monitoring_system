@extends('components.app')



@section('content')
<div class="row mt-4">
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
                                        <h5 class="card-title text-danger">Pending Accounts</h5>
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


<div class="row mt-4">
    <div class="col-md">
        <div class="card">
            <div class="card-header">
                <p class="text-secondary">Add Entries</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <label for="defaultFormControlInput" class="form-label">First name</label>
                        <input type="text" class="form-control" name="first_name" id="firstName" placeholder="Enter first name" aria-describedby="defaultFormControlHelp" />
                    </div>
                    <div class="col-md">
                        <label for="defaultFormControlInput" class="form-label">Middle name</label>
                        <input type="text" class="form-control" name="middle_name" id="middleName" placeholder="Enter middle name" aria-describedby="defaultFormControlHelp" />
                    </div>
                    <div class="col-md">
                        <label for="defaultFormControlInput" class="form-label">last name</label>
                        <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Enter last name" aria-describedby="defaultFormControlHelp" />
                    </div>
                    <div class="col-md">
                        <label for="defaultFormControlInput" class="form-label">Suffix</label>
                        <input type="text" class="form-control" name="suffix" id="suffix" placeholder="Enter suffix" aria-describedby="defaultFormControlHelp" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <label for="defaultFormControlInput" class="form-label">Middle name</label>
                        <input type="text" class="form-control" name="middle_name" id="middleName" placeholder="Enter middle name" aria-describedby="defaultFormControlHelp" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md">
        <diuv class="card">
            <div class="card-body">
                hello world
            </div>
        </diuv>
    </div>
</div>
@endsection



@section('components.specific_page_scripts')

@endsection
