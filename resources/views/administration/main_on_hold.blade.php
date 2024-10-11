@extends('components.app')

@section('content')

<div class="row mt-4">
    <h4 class="card-title text-secondary">On Hold Transactions</h4>
</div>

{{-- <div class="row mt-4 gap-3">
    <div class="col-md">
        <div class="card shadow-none bg-label-danger">
            <div class="card-body text-danger">
                <h5 class="card-title text-danger">On Hold Transactions</h5>
                <h1 class="text-danger">{{$OnHold? $OnHold : 0}}</h1>
            </div>
        </div>
    </div>
</div> --}}

<div class="row mt-4">
    <div class="col">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="onHoldTable" class="table table-borderless table-hover" style="width:100%">
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

            var table = $('#onHoldTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('main_on_hold.list')}}',
                responsive: true,
                pageLength: 10,
                paging: true,
                dom: '<"top"lf>rt<"bottom"ip>',
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                },
                columns: [
                    { data: 'batch_id', name: 'batch_id', title: 'TN' },
                    { data: 'count_transaction', name: 'count_transaction', title: 'Number of Trans' },
                    { data: 'hold_by', name: 'hold_by', title: 'On-Hold By' },
                    { data: 'office', name: 'office', title: 'Office of' },
                    { data: 'sent', name: 'sent', title: 'Sent' },
                    { data: 'date_received', name: 'date_received', title: 'Date' },
                ],

                order: [[0, 'desc']], // Sort by date_received column by default
                columnDefs: [
                    {
                        type: 'date',
                        targets: [0, 1] // Apply date sorting to date_received and date_on_hold columns
                    }
                ],
                createdRow: function(row, data) {
                    $(row).addClass('unopened');
                }
            });

            // Row click event
            $('#onHoldTable tbody').on('click', 'tr', function() {
                        var rowData = table.row($(this).closest('tr')).data();

                        // If the row is unopened, change its class to opened
                        if ($(this).hasClass('unopened')) {
                            $(this).removeClass('unopened').addClass('opened');
                        }

                        // Redirect to another page with full details (example)
                        window.location.href = `/admin_on_hold?id=${rowData.batch_id}`;
            });

    });
</script>


@endsection
