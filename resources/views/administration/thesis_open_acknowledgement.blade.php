@extends('components.app')

@section('content')



<div class="row">
    <div class="col-md">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="mb-3"><a href="/thesisAcknowledgement" class=""><i class='bx bx-left-arrow-alt text-primary' id="" style="font-size: 2em; cursor: pointer;"></i></a></div>

                <h4 class="d-flex align-items-center"><i class='bx bx-list-ul'  style="font-size: 32px;"></i>Batch Transaction Details</h4>
                <div class="row">
                    <div class="col-md">
                        <div class="alert alert-secondary">
                            Total Transactions: <b>{{$TransCount}}</b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-success">
                            From: <b>{{$office->name}}</b>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="alert alert-warning">
                            Received Date: <b>{{ \Carbon\Carbon::parse($thesisLogs->created_at)->format('F d, Y') }}</b>
                        </div>
                    </div>
                </div>


                <div class="card shadow-none bg-label-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Tracking Number:</h5>
                        {{-- <h1 class="text-primary">{{$onQueue}}</h1> --}}
                        <h1 class="text-primary">{{$tracking_number ? $tracking_number :  'No Data Found'}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <div class="row mb-3">
            <div class="col-md mx-auto d-flex justify-content-end">
                <button type="button" class="btn btn-primary gap-1 ProceedAcknowledge " id="ProceedAcknowledge" >Acknowledge Transaction<i class='bx bx-chevrons-right'></i></button>
            </div>
        </div>

        <div class="card custom-card border border-primary">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="thesisEntriesTable" class="table table-borderless" style="width:100%">
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

        $('#proceed').modal('hide');

        var tracking_number = {!! json_encode($tracking_number) !!};

        window.showMembersAlert = function(id) {
            $.ajax({
                url: '{{ route("thesis.getMembersByID") }}', // Route to get members by ID
                type: 'GET',
                data: { id: id }, // Return the id to the backend
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                },
                success: function(members) {

                    const membersString = members.map(member => {
                        return `<strong>Member Type:</strong> ${member.member_type}<br><strong>Name:</strong> ${member.first_name} ${member.last_name}`;
                    }).join('<br><br>');

                    Swal.fire({
                        title: 'Member(s)',
                        html: membersString,
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#007bff',
                        footer: 'Viewing members for thesis entry.'
                    });
                
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!',
                    });
                }
            });

        };


         // DataTable initialization
         const thesisTable = $('#thesisEntriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('thesis.open.list') }}',
                data: function(d) {
                    d.tracking_number = tracking_number;
                }
            },
            pageLength: 10,
            paging: true,
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            columns: [
                { data: 'student', name: 'student', title: 'Student' },
                { data: 'defense_date', name: 'defense_date', title: 'Defense Date' },
                { data: 'defense_time', name: 'defense_time', title: 'Defense Time' },
                { data: 'orNumber', name: 'orNumber', title: 'OR#' },
                { data: 'degree', name: 'degree', title: 'Degree' },
                { data: 'defense', name: 'defense', title: 'Defense' },
                { data: 'adviser', name: 'adviser', title: 'Adviser' },
                { data: 'chairperson', name: 'chairperson', title: 'Chairperson' },
                { data: 'membersCount', name: 'membersCount', title: 'Members', render: function(data, type, row) {
                    return `<a href="#" onclick="showMembersAlert(${row.id})">${data}</a>`;
                } },
                { data: 'recorder', name: 'recorder', title: 'Recorder' },
                { data: 'created_by', name: 'created_by', title: 'Created By' },
                { data: 'created_on', name: 'created_on', title: 'Created On' },
                { data: 'created_at', name: 'created_at', title: 'Date' },
                // { data: 'action', name: 'action', title: 'Action' }
                
            ],
            order: [[0, 'desc']],  // Sort by date created by default
            columnDefs: [
                {
                    type: 'created_at',
                    targets: [0, 1] // Apply date sorting to date_received and date_on_hold columns
                }
            ],
            createdRow: function(row, data) {
                $(row).addClass('unopened');
            },
            drawCallback: function() {
                
            },

        });


        $('#ProceedAcknowledge').off('click').on('click', function() {

            $.ajax({
                url: '{{ route('thesis.acknowledge') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    tracking_number: tracking_number,
                },
                beforeSend: function() {
                        Swal.fire({
                            title: 'Processing...',
                            html: '<div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },

                success: function(response) {
                    if(response.success){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#thesisEntriesTable').DataTable().ajax.reload();
                        window.location.href = '/thesis-out-going';
                        

                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oh no!',
                            text: response.message,
                        });
                        $('#thesisEntriesTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    // Handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem updating the transactions.',
                    });
                }
            });
        });

      
    });
</script>

@endsection
