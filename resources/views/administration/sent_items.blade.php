@extends('components.app')

@section('content')

        <div class="row mt-4">
            <h4 class="card-title text-secondary">Sent Items</h4>
        </div>

        {{-- <div class="row mt-4 gap-3">
            <div class="col-md">
                <div class="card shadow-none bg-label-success">
                  <div class="card-body text-success">
                    <h5 class="card-title text-success">New Emails Today</h5>
                    <h1 class="text-success">5</h1>
                  </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card shadow-none bg-label-primary">
                  <div class="card-body text-primary">
                    <h5 class="card-title text-primary">Unread Emails</h5>
                    <h1 class="text-primary">10</h1>
                  </div>
                </div>
            </div>
        </div> --}}

        <div class="row mt-4">
            <div class="col">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="d-flex align-items-center" style="margin-left: 1.8%;">
                                <div class="form-check form-check-primary check-buttons d-flex align-items-center">
                                    <label><input class="form-check-input" type="checkbox" id="toggleCheck">&nbsp;&nbsp;</label>
                                    <label class="text-danger" id="deleteSelected" style="cursor: pointer;">Move to Trash</label>
                                </div>
                            </div>
                            <table id="sentItemsTable" class="table table-borderless table-hover" style="width:100%">
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

    {{-- SENT ITEMS DATATABLES START --}}
    <script>
        // const user = @json(Auth::user());
       $(function () {
           var table = $('#sentItemsTable').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{route('getEmailsSent')}}',
               pageLength: 100,
               paging: false, // Disable pagination
               dom: '<"top"f>rt<"bottom"ip>',
               language: {
                   search: "", // Remove the default search label
                   searchPlaceholder: "Search..." // Set the placeholder text
               },
               order: [[3, 'desc']], // Sort by the 'date' column in descending order
               columns: [
                    {
                        data: 'id',
                        orderable: false,
                        render: function(data, type, row) {
                            return '<input type="checkbox" class="form-check-input row-checkbox" value="' + row.id + '">';
                        }
                    },
                   { data: 'name', name: 'name', title: 'Name' },
                   { data: 'subject', name: 'subject', title: 'Subject' },
                   { data: 'date', name: 'date', title: 'Date' }
               ],
               createdRow: function(row, data) {
                   // Add class to unopened rows

               }
           });

            // Function to update the Toggle Check button text
            function updateToggleCheckButton() {
                var allChecked = $('#sentItemsTable tbody input.row-checkbox').length === $('#sentItemsTable tbody input.row-checkbox:checked').length;
                var anyChecked = $('#sentItemsTable tbody input.row-checkbox:checked').length > 0;

                if (allChecked || anyChecked) {
                    $('#toggleCheck').text('Uncheck');
                } else {
                    $('#toggleCheck').text('Check All');
                }
            }

            // Initial call to set the button text based on initial state
            updateToggleCheckButton();

        //    Prevent checkbox click from triggering row click event
           $('#sentItemsTable tbody').on('click', 'input.row-checkbox', function(e) {
               e.stopPropagation();
               updateToggleCheckButton(); // Update button text when a checkbox is clicked
           });

           // Row click event
           $('#sentItemsTable tbody').on('click', 'tr', function() {
               var rowData = table.row($(this).closest('tr')).data();

               // If the row is unopened, change its class to opened
               if ($(this).hasClass('unopened')) {
                   $(this).removeClass('unopened').addClass('opened');
               }


               // Redirect to another page with full details (example)
               window.location.href = `/open_sent_items?id=${rowData.id}`;
           });

           // Toggle Check All/Uncheck All button click event
        //    $('#toggleCheck').on('click', function() {
        //        var allChecked = $('#sentItemsTable tbody input.row-checkbox').length === $('#sentItemsTable tbody input.row-checkbox:checked').length;

        //        if (allChecked) {
        //            $('#sentItemsTable tbody input.row-checkbox').prop('checked', false);
        //            $('#toggleCheck').text('Check All');
        //        } else {
        //            $('#sentItemsTable tbody input.row-checkbox').prop('checked', true);
        //            $('#toggleCheck').text('Uncheck');
        //        }
        //    });

        //    // Delete Selected button click event
        //    $('#deleteSelected').on('click', function() {
        //        $('#sentItemsTable tbody input.row-checkbox:checked').each(function() {
        //            var row = $(this).closest('tr');
        //            table.row(row).remove().draw(false);
        //        });
        //        updateToggleCheckButton(); // Update button text after deletion
        //    });

        //    // Delete row button click event
        //    $('#sentItemsTable tbody').on('click', '.delete-row', function(e) {
        //        e.stopPropagation();
        //        var row = $(this).closest('tr');
        //        table.row(row).remove().draw(false);
        //        updateToggleCheckButton(); // Update button text after deletion
        //    });

             // Prevent checkbox click from triggering row click event
            $('#sentItemsTable tbody').on('click', 'input.row-checkbox', function(e) {
                e.stopPropagation();

                updateToggleCheckButton(); // Update button text when a checkbox is clicked
            });

            // Delete Selected button click event
            $('#deleteSelected').on('click', function() {
                var selectedIds = [];
                $('#sentItemsTable tbody input.row-checkbox:checked').each(function() {
                    var rowId = $(this).val(); // Get the ID of the row
                    selectedIds.push(rowId);   // Collect the selected row IDs
                });

                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No selection',
                        text: 'Please select at least one item to delete.',
                    });
                    return;
                }

                // Confirm deletion
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to change the status to "Deleted"
                        $.ajax({
                            url: '{{ route('deleteEmails') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selectedIds
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove the selected rows from the table
                                    $('#sentItemsTable tbody input.row-checkbox:checked').each(function() {
                                        var row = $(this).closest('tr');
                                        table.row(row).remove().draw(false);
                                    });
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Selected emails have been deleted.',
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'There was an error deleting the selected emails.',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'There was an issue with the deletion process.',
                                });
                            }
                        });
                    }
                });

                updateToggleCheckButton(); // Update button text after deletion
            });

            // Toggle Check All/Uncheck All button click event
            $('#toggleCheck').on('click', function() {
                var allChecked = $('#sentItemsTable tbody input.row-checkbox').length === $('#sentItemsTable tbody input.row-checkbox:checked').length;

                if (allChecked) {
                    $('#sentItemsTable tbody input.row-checkbox').prop('checked', false);
                    $('#toggleCheck').text('Check All');
                } else {
                    $('#sentItemsTable tbody input.row-checkbox').prop('checked', true);
                    $('#toggleCheck').text('Uncheck');
                }
            });
       });
   </script>
   {{-- SENT ITEMS DATATABLES END --}}



@endsection
