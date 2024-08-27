@include('administration.email_toast')

{{-- SENDING EMAIL FOR SPINNER AND STATUS START --}}
@section('components.specific_page_scripts')
<script>
    $(document).ready(function() {
        // Retrieve the CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // Ensure failed messages, spinner, and toasts are hidden on page load
        $('#sendingFailed').hide();
        $('#spinner').hide();
        $('#toastSuccess').hide();
        $('#toastDiscard').hide();

        $('#replyForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting
            // event.stopPropagation();
            console.log("test");
            // Show the spinner and hide the failed message
            $('#spinner').show();
            $('#sendingFailed').hide();

            // Gather form data
            var formData = {
                subject: $('#floatingInput').val(),
                message: $('#emailTextArea').val()
            };

            // Perform AJAX request
            $.ajax({
                url: '/send_email', // Ensure this is the correct URL
                type: 'POST',
                data: $('#replyForm').serialize(),
                success: function(response) {
                    // Hide the spinner
                    $('#spinner').hide();

                    // Clear all input fields
                    $('#replyForm').find('input[type="text"], textarea').val('');
                    // Close the offcanvas
                    $('#offcanvasEnd').offcanvas('hide');
                },
                complete:function(){
                    // Show success toast
                    $('#toastSuccess').toast('show');
                },
                error: function(xhr, status, error) {
                    // Hide the spinner
                    $('#spinner').hide();
                    // Show error message
                    $('#sendingFailed').toast('show');
                }
            });
        });

        $('#discard').on('click', function() {
            console.log("test2");
            // Clear all input fields
            $('#replyForm').find('input[type="text"], textarea').val('');
            // Hide the failed message
            $('#sendingFailed').hide();
            // Show the discard toast
            $('#toastDiscard').toast('show');
            // Toggle the offcanvas
            const $offcanvas = $('#offcanvasEnd');
            if ($offcanvas.hasClass('show')) {
                $offcanvas.offcanvas('hide');
            } else {
                $offcanvas.offcanvas('show');
            }
        });

        // Event listener to hide failed message on any action
        $('#replyForm input, #replyForm textarea, #sendButton, #discard').on('input click', function() {
            $('#sendingFailed').hide();
        });

        // Add a click event listener to hide the toast when anywhere on the screen is clicked
        $(document).on('click.toastDismiss', function() {
            $('.toast').toast('hide');
            $(document).off('click.toastDismiss'); // Remove the event listener after hiding the toast
        });
    });
</script>
@endsection

