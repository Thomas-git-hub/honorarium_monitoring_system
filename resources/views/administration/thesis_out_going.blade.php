@extends('components.app')



@section('content')
 {{-- Page Title --}}
 <div class="row mt-4 gap-3" id="thesisNewEntriesTitle">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4 class="card-title text-secondary">Thesis Out-Going Defenses</h4>
                </div>

                <div class="row">
                    <div class="card shadow-none bg-label-success">
                        <div class="card-header d-flex justify-content-end">
                            <small class="card-title text-success d-flex align-items-center gap-1"><i class='bx bxs-calendar'></i>{{ date('F j, Y') }}</small>
                        </div>
                        <div class="card-body text-success">
                            <div class="row d-flex align-items-center">
                                <div class="col-md d-flex align-items-center gap-3">
                                    <h1 class="text-success text-center d-flex align-items-center" id="onQueue" style="font-size: 48px;">0</h1>
                                    <h5 class="card-title text-success">Outgoing Defenses Added</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Datatables --}}
<div class="row mt-4">
    <div class="col">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="thesisOutGoingTable" class="table table-borderless table-hover" style="width:100%">
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
        function fetchTransactionCount() {
            $.ajax({
                url: '{{ route("thesis.outgoing.getItems") }}', // Adjust the route as necessary
                type: 'GET',
                success: function(response) {
                    if (response.transactions !== undefined) {
                        $('#onQueue').text(response.transactions); // Update the count in the HTML
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching transaction count:', xhr);
                }
            });
        }
        // Call the function to fetch the count on page load
        fetchTransactionCount();
        var table = $('#thesisOutGoingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('thesis.outgoing.list')}}', 
            pageLength: 100,
            paging: true, // abled pagination
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            
            columns: [
                { data: 'tracking_number', name: 'tracking_number', title: 'TN' },
                { data: 'from', name: 'from', title: 'From' },
                { data: 'trans_id', name: 'trans_id', title: 'No. of Transactions' },
                { data: 'created_at', name: 'created_at', title: 'Received Date' },
            ],
            createdRow: function(row, data) {
                // Add class to unopened rows
                $(row).addClass('unopened');
            }
        });


        // Row click event
        $('#thesisOutGoingTable tbody').on('click', 'tr', function() {
                var rowData = table.row($(this).closest('tr')).data();

                // If the row is unopened, change its class to opened
                if ($(this).hasClass('unopened')) {
                    $(this).removeClass('unopened').addClass('opened');
                }

                // Redirect to another page with full details (example)
                window.location.href = `/thesis-open-out-going?id=${rowData.tracking_number}`;
                // window.location.href = `/thesisOpenOutGoing?id=${rowData.tracking_number}`;
        });
    });
</script>
@endsection
