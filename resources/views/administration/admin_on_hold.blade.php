@extends('components.app')

@section('content')

<!-- PROCEED MODAL START -->
<!-- Modal -->
<div class="modal fade" id="proceed" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="text-warning">Read</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="text-center text-danger">!</h1>
          <p class="text-center">"Proceeding with this transaction indicates that the individual has submitted all necessary requirements for their honorarium."</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i></button>
          <button type="button" class="btn btn-warning gap-1">Proceed to Budget Office<i class='bx bx-chevrons-right'></i></button>
        </div>
      </div>
    </div>
  </div>
{{-- EDIT MODAL END --}}

{{-- MESSAGE MODAL START --}}
<!-- Modal -->
<div class="modal fade" id="onHoldMessage" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl" id="onHoldModalDialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title gap-1 d-flex align-items-center" id="backDropModalTitle"><i class='bx bxs-hand'></i>Hold Transaction</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="emailReply">
                <div class="d-flex justify-content-end gap-2">
                    <!-- Spinner -->
                    <div class="spinner-border text-primary" role="status" id="spinner" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <!-- Success Message -->
                    <div class="text-success d-flex flex-row gap-2" id="emailSuccess" style="display: none !important;">
                        <b>Sent</b><i class='bx bx-check-circle fs-3'></i>
                    </div>
                    <!-- Failed Message -->
                    <div class="text-danger d-flex flex-row gap-2" id="emailFailed" style="display: none !important;">
                        <b>Failed</b><i class='bx bx-x-circle fs-3'></i>
                    </div>
                </div>
                <div>
                    <p><b><small>To:</small></b> John Doe Duridut&nbsp;<small style="font-style: italic;">johndoe@bicol-u.edu.ph</small></p>
                </div>
                <div class="mb-4">
                    <label for="defaultInput" class="form-label">Subject</label>
                    <input id="defaultInput" class="form-control" type="text" placeholder="Subject"/>
                </div>
                <div>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Message" style="border: none;"></textarea>
                </div>
                <div class="border-top mt-3">
                    <div class=" d-flex flex-row justify-content-end mt-3 gap-2">
                        <button type="button" class="btn btn-label-danger border-none" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-custom-class="tooltip-danger" title="Discard email" id="removeEmailReply"><i class='bx bxs-trash-alt'></i></button>
                        <button type="button" class="btn btn-primary me-1 mb-1" id="sendButton"><i class='bx bxs-send'>&nbsp;</i>Send</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
{{-- MESSAGE MODAL END --}}

<div class="row mt-4">
    <h4 class="card-title text-secondary">On Hold</h4>
</div>

<div class="row mt-4 gap-3">
    <div class="col-md">
        <div class="card shadow-none bg-label-danger">
            <div class="card-body text-danger">
                <h5 class="card-title text-danger">On Hold Transactions</h5>
                <h1 class="text-danger">5</h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="facultyTable" class="table table-borderless" style="width:100%">
                        <tbody class="text-center">
                            <!-- Data will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('components.specific_page_scripts')

{{--FACULTY DATATABLES START --}}
<script>
    $(function () {
        var data = [
            {
                date_received: '<p>07/27/2024</p>',
                date_on_hold: '<p class="text-danger">07/27/2024</p>',
                faculty: '<p class="text-primary">John Doe</p>',
                id_number: '<p class="text-primary">1-id-no-2024</p>',
                academic_rank: '<span class="badge bg-label-primary">Associate Professor II</span>',
                college: '<p>College of Arts</p>',
                honorarium: '<p>honorarium here</p>',
                semester: '<p class="text-success">First Semester</p>',
                semester_year: '<p>2024</p>',
                month_of: '<p>July</p>',
                action: '<div class="d-flex flex-row"> <button type="button" class="btn me-2 btn-label-warning edit-btn gap-1" data-bs-toggle="modal" data-bs-target="#proceed">Proceed<i class="bx bx-chevrons-right"></i></button></div>',
            },
            // More data...
        ];

        var table = $('#facultyTable').DataTable({
            data: data,
            processing: false,
            serverSide: false,
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            columns: [
                { data: 'date_received', name: 'date_received', title: 'Date Received' },
                { data: 'date_on_hold', name: 'date_on_hold', title: 'Date On Hold' },
                { data: 'faculty', name: 'faculty', title: 'Faculty' },
                { data: 'id_number', name: 'id_number', title: 'ID Number' },
                { data: 'academic_rank', name: 'academic_rank', title: 'Academic Rank' },
                { data: 'college', name: 'college', title: 'College' },
                { data: 'honorarium', name: 'honorarium', title: 'Honorarium' },
                { data: 'semester', name: 'semester', title: 'Semester' },
                { data: 'semester_year', name: 'semester_year', title: 'Semester Year' },
                { data: 'month_of', name: 'month_of', title: 'Month Of' },
                { data: 'action', name: 'action', title: 'Action' }
            ],
        });
    });
</script>




@endsection
