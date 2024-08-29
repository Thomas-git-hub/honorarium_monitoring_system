@extends('components.app')



@section('content')

<div class="row mt-4">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <h4 class="d-flex align-items-center"><i class='bx bxs-shield-alt-2' style="font-size: 32px;"></i>System User Management</h4>

                <div class="row gap-1">
                    <div class="col-md">
                        <div class="card shadow-none bg-label-warning">
                            <div class="card-header d-flex justify-content-end">
                                <small class="card-title text-warning d-flex align-items-center"><i class='bx bxs-user-plus' style="font-size: 32px;"></i></small>
                            </div>
                            <div class="card-body text-warning">
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <h1 class="text-warning text-center" style="font-size: 48px;">5</h1>
                                    </div>
                                    <div class="col-10">
                                        <h5 class="card-title text-warning">Account Request</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="card shadow-none bg-label-primary">
                            <div class="card-header d-flex justify-content-end">
                                <small class="card-title text-primary d-flex align-items-center"><i class='bx bxs-group' style="font-size: 32px;"></i></small>
                            </div>
                            <div class="card-body text-primary">
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <h1 class="text-primary text-center" style="font-size: 48px;">5</h1>
                                    </div>
                                    <div class="col-10">
                                        <h5 class="card-title text-primary">System User Accounts</h5>
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
                                        <h5 class="card-title text-danger">Inactive Accounts</h5>
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
        <div class="nav-align-top">
            <ul class="nav nav-pills mb-4" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Account Request</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">System Users</button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="accountRequestTable" class="table table-borderless table-hover" style="width:100%">
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                <div class="row">
                    <div class="col-md">

                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table id="facultyTable" class="table table-borderless table-hover" style="width:100%">
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>

@endsection



@section('components.specific_page_scripts')

<script>
    // const user = @json(Auth::user());
   $(function () {
       var data = [
           { from: 'John Doe', for: 'full name here', office: 'Office', date: 'Jul 5' },
           { from: 'John Doe Jr.', for: 'full name here', office: 'Office', date: 'Jul 5' },
           { from: 'John Doe Papa Dot', for: 'full name here', office: 'Office', date: 'Jul 5' },
           { from: 'John Doe Papa Dot Jr.', for: 'full name here', office: 'Office', date: 'Jul 5' },
           // Add more objects as needed
       ];

       var table = $('#accountRequestTable').DataTable({
           data: data,
           processing: false,
           serverSide: false,
           pageLength: 200,
           paging: false, // Disable pagination
           dom: '<"top"f>rt<"bottom"ip>',
           language: {
               search: "", // Remove the default search label
               searchPlaceholder: "Search..." // Set the placeholder text
           },
           columns: [
               { data: 'from', name: 'from', title: 'From' },
               { data: 'for', name: 'for', title: 'For' },
               { data: 'office', name: 'office', title: 'Office of' },
               { data: 'date', name: 'date', title: 'Date' }
           ],
       });
   });
</script>

{{-- EMAIL DATATABLES END --}}

@endsection
