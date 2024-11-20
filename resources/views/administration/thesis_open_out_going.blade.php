@extends('components.app')



@section('content')
 {{-- Page Title --}}
 <div class="row">
    <div class="col-md">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="mb-3"><a href="/thesis-out-going" class=""><i class='bx bx-left-arrow-alt text-primary' id="" style="font-size: 2em; cursor: pointer;"></i></a></div>

                <h4 class="d-flex align-items-center"><i class='bx bx-list-ul'  style="font-size: 32px;"></i>Batch Out Going Defenses Transaction Details</h4>
                <div class="row">
                    <div class="col-md">
                        <div class="alert alert-secondary">
                            Total Transactions: <b></b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-success">
                            From: <b></b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-warning">
                            Received Date: <b></b>
                        </div>
                    </div>
                </div>


                <div class="card shadow-none bg-label-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Tracking Number:</h5>
                        {{-- <h1 class="text-primary">{{$onQueue}}</h1> --}}
                        <h1 class="text-primary"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Add Deduction and Net Amount Modal--}}
<div class="modal fade" id="addHonorariumAmount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Add Honorarium Amount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <form action="" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md">
                        <h4>Student: &nbsp;<b class="text-primary">John Doe</b></h4>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <div>Defense Date: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                    </div>
                    <div class="col-md mb-2">
                        <div>Defense Time: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md mb-2">
                        <div>Degree: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                    </div>
                    <div class="col-md mb-2">
                        <div>Defense: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md">
                        <div>Adviser: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                        <input id="adviserInputAmount" class="form-control form-control-md mb-2" type="text" name="adviser_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                    <div class="col-md">
                        <div>Chairperson: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                        <input id="chairpersonInputAmount" class="form-control form-control-md mb-2" type="text" name="chairperson_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div>Member 1: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                        <input id="firstMemberInputAmount" class="form-control form-control-md mb-2" type="text" name="first_member_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                    <div class="col-md-6">
                        <div>Member 2: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                        <input id="secondMemberInputAmount" class="form-control form-control-md mb-2" type="text" name="second_member_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                    <div class="col-md-6">
                        <div>Member 3: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                        <input id="thirdMemberInputAmount" class="form-control form-control-md mb-2" type="text" name="third_member_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                    <div class="col-md-6">
                        <div>Member 4: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                        <input id="fourthMemberInputAmount" class="form-control form-control-md mb-2" type="text" name="fourth_member_amount" placeholder="Enter Honorarium Amount" >
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md">
                        <div>Recorder: &nbsp;<b class="text-primary">lorem ipsum</b></div>
                        <input id="recorderInputAmount" class="form-control form-control-md mb-2" type="text" name="recorder_amount" placeholder="Enter Honorarium Amount"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Amount</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>


{{-- Datatables --}}
<div class="row mt-4">
    <div class="col">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="thesisOpenOutGoingTable" class="table table-borderless table-hover" style="width:100%">
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
<script>
    $(function () {

        var file_name = 'file_name' + new Date().toISOString().split('T')[0];

        // Datatables
        // var thesisOpenOutgoingTable;
        var thesisOpenOutgoingTable = $('#thesisOpenOutGoingTable').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 100,
            paging: true,
            dom: '<"top"Bf>rt<"bottom"ip><"clear">',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            data: [
                {
                    student: "John Doe",
                    defense_date: "2022-01-01",
                    defense_time: "10:00 AM",
                    OR: "OR123",
                    degree: "BSIT",
                    defense: "Thesis Defense",
                    adviser: "Dr. Jane Doe",
                    chairperson: "Dr. John Smith",
                    members: "Jane Doe, John Smith",
                    recorder: "Recorder Name",
                    date: "2022-01-01",
                    action: ""
                },
                // Add more data as needed
            ],
            columns: [
                { data: 'student', name: 'student', title: 'Student' },
                { data: 'defense_date', name: 'defense_date', title: 'Defense Date' },
                { data: 'defense_time', name: 'defense_time', title: 'Defense Time' },
                { data: 'OR', name: 'OR', title: 'OR' },
                { data: 'degree', name: 'degree', title: 'Degree' },
                { data: 'defense', name: 'defense', title: 'Defense' },
                { data: 'adviser', name: 'adviser', title: 'Adviser' },
                { data: 'chairperson', name: 'chairperson', title: 'Chairperson' },
                { data: 'members', name: 'members', title: 'Members' },
                { data: 'recorder', name: 'recorder', title: 'Recorder' },
                { data: 'date', name: 'date', title: 'Date' },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex">
                                <button type="button" class="btn btn-icon me-2 btn-label-success delete-btn" data-id="" data-bs-toggle="modal" data-bs-target="#addHonorariumAmount">
                                    <span class="tf-icons bx bx-show-alt bx-22px"></span>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            buttons: [
                {
                    extend: 'excelHtml5', // 'excel' is not the correct option, use 'excelHtml5'
                    text: 'Export Batch as .xls',
                    className: 'btn btn-primary shadow-none',
                    filename: function() {
                        var trackingNumber = 'Tracking_Number'; // Replace with actual tracking number logic

                        // Get the current date and format it as "Month Name, Day, Year"
                        var date = new Date();
                        var options = { year: 'numeric', month: 'long', day: 'numeric' };
                        var formattedDate = date.toLocaleDateString('en-US', options); // Format: "Month Day, Year" (e.g., "November 20, 2024")

                        return trackingNumber + '_' + formattedDate; // Format: Tracking_Number_Month Day, Year
                    },
                    exportOptions: {
                        columns: ':not(:last-child)' // This excludes the last column (the 'Action' column) from the export
                    }
                }
            ],
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            }
        });


        // Row click event
        // $('#thesisOpenOutGoingTable tbody').on('click', 'tr', function() {
        //         var rowData = table.row($(this).closest('tr')).data();

        //         // If the row is unopened, change its class to opened
        //         if ($(this).hasClass('unopened')) {
        //             $(this).removeClass('unopened').addClass('opened');
        //         }

        //         // Redirect to another page with full details (example)
        //         window.location.href = `/thesisOpenOutGoing?id=${rowData.tracking_number}`;
        // });
    });


    // On form submit
    $('form').on('submit', function(event) {
            // Flag to check if form is valid
            let isValid = true;

            // Array of field IDs to validate
            const fields = [
                '#adviserInputAmount',
                '#chairpersonInputAmount',
                '#firstMemberInputAmount',
                '#secondMemberInputAmount',
                '#thirdMemberInputAmount',
                '#fourthMemberInputAmount',
                '#recorderInputAmount'
            ];

            // Loop through each field ID
            fields.forEach(function(fieldId) {
                // Check if the field is empty
                if ($(fieldId).val() === '') {
                    // Add border-danger class to indicate an error
                    $(fieldId).addClass('border-danger');
                    isValid = false; // Mark form as invalid
                } else {
                    // Remove border-danger class if the field is filled
                    $(fieldId).removeClass('border-danger');
                }
            });

            // If the form is not valid, prevent the form from submitting
            if (!isValid) {
                event.preventDefault(); // Prevent form submission
            }
        });

        // Optional: On input change, remove border-danger class if the field is not empty
        const fields = [
            '#adviserInputAmount',
            '#chairpersonInputAmount',
            '#firstMemberInputAmount',
            '#secondMemberInputAmount',
            '#thirdMemberInputAmount',
            '#fourthMemberInputAmount',
            '#recorderInputAmount'
        ];

        // Loop through each field and remove the border-danger class when the user starts typing
        fields.forEach(function(fieldId) {
            $(fieldId).on('input', function() {
                // If the field is not empty, remove border-danger class
                if ($(fieldId).val() !== '') {
                    $(fieldId).removeClass('border-danger');
                }
            });
        });



</script>
@endsection
