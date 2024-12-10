@extends('components.app')

@section('content')

    <div class="row mt-3 mb-5">
        <div class="col-md">
            <h1 class="text-muted fw-medium d-flex align-items-center">Dashboard</h1>
        </div>
    </div>

    <div class="row  mb-5">
        <div class="d-flex justify-content-between gap-3">
            <div class="col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="badge bg-info p-4 rounded mb-4">
                            <i class='bx bx-envelope fs-3' ></i>
                        </div>
                          <h3 class="text-info fw-bold">{{$EmailCount ? $EmailCount : 0}} New Emails</h3>
                    </div>
                    <p class="fw-medium mb-0 d-flex justify-content-end"><a class="stretched-link" href="/admin_email">Go to<i class='bx bx-chevron-right'></i></a></p>
                  </div>
                </div>
            </div>

            <div class="col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="badge bg-warning p-4 rounded mb-4">
                            <i class='bx bx-list-ol fs-3' ></i>
                        </div>
                          <h3 class="text-warning fw-bold">{{$OnQueue ? $OnQueue : 0}} In-Queue Trans</h3>
                    </div>
                    <p class="fw-medium mb-0 d-flex justify-content-end"><a class="stretched-link" href="/admin_on_queue">Go to<i class='bx bx-chevron-right'></i></a></p>
                  </div>
                </div>
            </div>

            <div class="col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="badge bg-danger p-4 rounded mb-4">
                            <i class='bx bx-error-alt fs-3' ></i>
                        </div>
                          <h3 class="text-danger fw-bold">{{$OnHold ? $OnHold : 0}} On-Hold Trans</h3>
                    </div>
                    <p class="fw-medium mb-0 d-flex justify-content-end"><a class="stretched-link" href="/admin_on_hold">Go to<i class='bx bx-chevron-right'></i></a></p>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md">
            {{-- <h4 class="card-title mb-1">Incoming Acknowledgements</h4> --}}
            <div class="card">
                <div class="card-body">
                    <div class="card shadow-none border border-muted mb-2">
                        <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            {{-- <div class="badge bg-secondary p-4 rounded mb-4">
                                <i class='bx bx-archive-in fs-3' ></i>
                            </div> --}}
                                <h3 class="fw-light">Incoming Acknowledgements</h3>
                        </div>
                        <p class="fw-medium mb-0 d-flex justify-content-end"><a class="stretched-link" href="/for_acknowledgement">Go to<i class='bx bx-chevron-right'></i></a></p>
                        </div>
                    </div>

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

    <div class="row mt-4">
        <div class="col">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="card shadow-none border border-muted mb-2">
                        <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            {{-- <div class="badge bg-secondary p-4 rounded mb-4">
                                <i class='bx bx-archive-in fs-3' ></i>
                            </div> --}}
                                <h3 class="fw-light text-info">Incoming Emails</h3>
                        </div>
                        <p class="fw-medium mb-0 d-flex justify-content-end"><a class="stretched-link" href="/admin_email">Go to<i class='bx bx-chevron-right'></i></a></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        {{-- <div class="d-flex align-items-center" style="margin-left: 1.8%;">
                            <div class="form-check form-check-primary check-buttons d-flex align-items-center">
                                <label><input class="form-check-input" type="checkbox" id="toggleCheck">&nbsp;&nbsp;</label>
                                <label class="text-danger" id="deleteSelected">Move to Trash</label>
                            </div>
                        </div> --}}
                        <table id="inboxTable" class="table table-borderless table-hover" style="width:100%">
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
        var table = $('#acknowledgementTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('for_acknowledgement.list')}}',
            pageLength: 10,
            paging: true, // abled pagination
            dom: '<"top"lf>rt<"bottom"ip>',
            language: {
                search: "", // Remove the default search label
                searchPlaceholder: "Search..." // Set the placeholder text
            },
            columns: [
                { data: 'batch_id', name: 'batch_id', title: 'TN' },
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
        $('#acknowledgementTable tbody').on('click', 'tr', function() {
                var rowData = table.row($(this).closest('tr')).data();

                // If the row is unopened, change its class to opened
                if ($(this).hasClass('unopened')) {
                    $(this).removeClass('unopened').addClass('opened');
                }

                // Redirect to another page with full details (example)
                window.location.href = `/open_acknowledgement?id=${rowData.batch_id}`;
            });
    });
</script>
@endsection
