@extends('components.app')

@section('content')
    {{-- <h1>Welcome to the BUGS Honorarium Monitoring System</h1>
        <p>This is the content of the admin dashboard.</p> --}}
    <div class="row">
        <div class="col">
            <div class="card" style="">
                <div class="card-body">
                    <h2 class="card-title">Honorarium Transaction</h2>
                    <p class="card-text">Summary of Transaction</p>
                    <div class="row gy-4">
                        <div class="col-md">
                            <a href="/">
                                <div class="card shadow-none bg-label-primary">
                                    <div class="card-body text-primary">
                                        <h5 class="card-title text-primary">New Emails</h5>
                                        <p class="card-text fs-3 d-flex align-items-center">
                                            <i class='bx bxs-envelope fs-3'>&nbsp;</i>{{$EmailCount ? $EmailCount : 0}}
                                        </p>
                                    </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md">
                        <a href="">
                            <div class="card shadow-none bg-label-warning">
                                <div class="card-body text-warning">
                                    <h5 class="card-title text-warning">On Queue Transactions</h5>
                                    <p class="card-text fs-3 d-flex align-items-center">
                                        <i class='bx bx-list-ol fs-4'>&nbsp;</i>{{$OnQueue ? $OnQueue : 0}}
                                    </p>
                                </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <a href="">
                        <div class="card shadow-none bg-label-secondary">
                            <div class="card-body text-secondary">
                                <h5 class="card-title text-secondary">On Hold Transactions</h5>
                                <p class="card-text fs-3 d-flex align-items-center">
                                    <i class='bx bxs-error-alt fs-3'>&nbsp;</i>{{$OnHold ? $OnHold : 0}}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row d-flex flex-column justify-content-start">
                        <h2 class="card-title">Emails</h2>
                    </div>
                    <div class="table-responsive">
                        <div class="d-flex align-items-center" style="margin-left: 1.8%;">
                            <div class="form-check form-check-primary check-buttons d-flex align-items-center">
                                <label><input class="form-check-input" type="checkbox" id="toggleCheck">&nbsp;&nbsp;</label>
                                <label class="text-danger" id="deleteSelected">Move to Trash</label>
                            </div>
                        </div>
                        <table id="inboxTable" class="table table-borderless table-hover" style="width:100%">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <a href="">
                                <div class="card shadow-none bg-label-primary">
                                    <div class="card-body text-secondary">
                                        <h5 class="card-title text-secondary">Lorem Ipsum</h5>
                                        <p class="card-text fs-3 d-flex align-items-center">
                                            <i class='bx bxs-error-alt fs-3'>&nbsp;</i>23
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="col-md-4">
                            <a href="">
                                <div class="card shadow-none bg-label-danger">
                                    <div class="card-body text-danger">
                                        <h5 class="card-title text-danger">You haven't move your transaction for</h5>
                                        <p class="card-text fs-3 d-flex align-items-center">
                                            <i class='bx bxs-error-alt fs-3'>&nbsp;</i>3 Days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
