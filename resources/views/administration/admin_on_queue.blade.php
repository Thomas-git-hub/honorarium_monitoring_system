@extends('components.app')

@section('content')
    <div class="row mt-4">
        <h4 class="card-title text-secondary">In Queue Transactions</h4>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="inQueueTable" class="table table-borderless table-hover" style="width:100%">
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

        var table = $('#inQueueTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('admin_on_queue.list')}}',
            pageLength: 100,
            paging: true, // abled pagination
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            order: [[3, 'desc']],
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'Batch' },
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
        $('#inQueueTable tbody').on('click', 'tr', function() {
                var rowData = table.row($(this).closest('tr')).data();

                // If the row is unopened, change its class to opened
                if ($(this).hasClass('unopened')) {
                    $(this).removeClass('unopened').addClass('opened');
                }

                // Redirect to another page with full details (example)
                window.location.href = `/open_on_queue?id=${rowData.batch_id}`;
            });
    });
</script>

@endsection


