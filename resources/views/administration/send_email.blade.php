<!-- Toasts -->
<div class="bs-toast toast fade position-absolute top-0 end-0 mt-4 mx-5" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" id="toastSuccess">
    <div class="toast-header">
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body d-flex justify-content-center">
        <h6 class="text-success d-flex align-items-center"><i class='bx bxs-check-circle'>&nbsp;</i>Message Sent</h6>
    </div>
</div>

<div class="bs-toast toast fade position-absolute top-0 end-0 mt-4 mx-5" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" id="sendingFailed">
    <div class="toast-header">
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body d-flex justify-content-center">
        <h6 class="text-danger d-flex align-items-center"><i class='bx bxs-check-circle'>&nbsp;</i>Message Sending Failed</h6>
    </div>
</div>

<div class="bs-toast toast fade position-absolute top-0 end-0 mt-4 mx-5" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" id="toastDiscard">
    <div class="toast-header">
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body d-flex justify-content-center">
        <h6 class="text-primary d-flex align-items-center"><i class='bx bxs-check-circle'>&nbsp;</i>Discard Message</h6>
    </div>
</div>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasEndLabel" class="offcanvas-title d-flex align-items-center"><i
                class='bx bxs-envelope'>&nbsp;</i>Send Email</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-3 flex-grow-0">
        <!-- Spinner -->
        <div class="spinner-border text-primary mb-2" role="status" id="spinner" style="display: none;">
            <span class="visually-hidden">Loading...</span>
        </div>

        <!-- Form -->
        <form id="replyForm">
            <div class="card mb-5">
                <div class="card-body d-flex align-items-center">
                    <div class="text-dark"><b>To:&nbsp;</b> John Doe Duridut&nbsp;<small class="text-secondary"
                            style="font-style: italic;">johndoe@bicol-u.edu.ph</small></div>
                </div>
            </div>

            <div class="form-floating mb-4 border-bottom">
                <input type="text" class="form-control border-none" id="floatingInput" placeholder=""
                    aria-describedby="floatingInputHelp" />
                <label for="floatingInput">Subject</label>
            </div>
            <div>
                <textarea class="form-control" id="emailTextArea" rows="3" placeholder="Message" style="border: none;"></textarea>
            </div>
            <div class="border-top mt-3">
                <div class="d-flex flex-row justify-content-end mt-3 gap-2">
                    <button type="button" class="btn btn-label-danger border-none btn-trash bg-transparent"
                        id="discard"><i class='bx bxs-trash-alt'></i></button>
                    <button type="submit" class="btn btn-primary" id="sendButton"><i
                            class='bx bxs-send'>&nbsp;</i>Send</button>
                </div>
            </div>
        </form>
    </div>
</div>

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

