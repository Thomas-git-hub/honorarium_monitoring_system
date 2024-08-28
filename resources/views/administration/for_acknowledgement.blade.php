@extends('components.app')

@section('content')
    <div class="row mt-4">
        <h4 class="card-title text-secondary">For Acknowledgement</h4>
    </div>

    <div class="row mt-4">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-flex align-items-center"><i class='bx bxs-envelope' style="font-size: 32px;"></i>Unopened Transactions</h4>

                    <div class="row gap-1">
                        <div class="col-md">
                            <div class="card shadow-none bg-label-success">
                                <div class="card-header d-flex justify-content-end">
                                    <small class="card-title text-success d-flex align-items-center gap-1">
                                        <i class='bx bxs-calendar'></i>
                                        <?php echo date('F j, Y'); ?>
                                    </small>
                                </div>
                                <div class="card-body text-success">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-2">
                                            <h1 class="text-success text-center" style="font-size: 48px;">{{$TransCountToday ? $TransCountToday : 0}}</h1>
                                        </div>
                                        <div class="col-10">
                                            <h5 class="card-title text-success">New Transactions for Acknowledgement as of Today</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="card shadow-none bg-label-warning">
                                <div class="card-header d-flex justify-content-end">
                                    <small class="card-title text-warning d-flex align-items-center gap-1"><i class='bx bxs-calendar'></i><?php echo date('F j, Y'); ?></small>
                                </div>
                                <div class="card-body text-warning">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-2">
                                            <h1 class="text-warning text-center" style="font-size: 48px;">{{$TransCountYesterday ? $TransCountYesterday : 0}}</h1>
                                        </div>
                                        <div class="col-10">
                                            <h5 class="card-title text-warning">Unacknowledged Transactions Pending as of Yesterday</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="card shadow-none bg-label-danger">
                                <div class="card-header d-flex justify-content-end">
                                    <small class="card-title text-danger d-flex align-items-center gap-1"><i class='bx bxs-calendar'></i><?php echo date('F j, Y'); ?></small>
                                </div>
                                <div class="card-body text-danger">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-2">
                                            <h1 class="text-danger text-center" style="font-size: 48px;">{{$TransCountDaysAgo ? $TransCountDaysAgo : 0}}</h1>
                                        </div>
                                        <div class="col-10">
                                            <h5 class="card-title text-danger">Unacknowledged Transactions Pending from the Past Several Days</h5>
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
        <div class="col">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="acknowledgementTable" class="table table-borderless table-hover" style="width:100%">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('components.specific_page_scripts')
@endsection
