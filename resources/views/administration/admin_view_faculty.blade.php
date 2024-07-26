@extends('components.app')

@section('content')
    {{-- <div class="row">
        <div class="col">
            <div class="card bg-transparent border-none shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex flex-row gap-3">
                            <div class="row mb-4"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>
                            <h4 class="card-title text-primary">Faculties</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>
                    <div class="text">Faculty:&nbsp;<small class="fw-bold">John Doe</small></div>
                    <div class="text">ID Number:&nbsp;<small class="fw-bold">1-id-no-2024</small></div>
                    <div class="text">Academic Rank:&nbsp;<small class="fw-bold">Associate Professor II</small></div>
                    <div class="text">College:&nbsp;<small class="fw-bold">College of Arts</small></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="">
                <div class="card mb-2">
                    <div class="card-body">
                        BUGS Administration
                    </div>
                </div>
            </a>
            <a href="">
                <div class="card mb-2">
                    <div class="card-body">
                        Budget Office
                    </div>
                </div>
            </a>
            <a href="">
                <div class="card mb-2">
                    <div class="card-body">
                        Dean
                    </div>
                </div>
            </a>
            <a href="">
                <div class="card mb-2">
                    <div class="card-body">
                        Accounting
                    </div>
                </div>
            </a>
            <a href="">
                <div class="card mb-2">
                    <div class="card-body">
                        Dean
                    </div>
                </div>
            </a>
            <a href="">
                <div class="card mb-2">
                    <div class="card-body">
                        Cashier
                    </div>
                </div>
            </a>
            <a href="">
                <div class="card mb-2">
                    <div class="card-body">
                        Released
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row d-flex flex-column justify-content-start">
                            <h4 class="card-title">BUGS Administration</h4>
                        </div>
                        <div class="table-responsive">
                            <table id="facultyTable" class="table table-borderless" style="width:100%">
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
