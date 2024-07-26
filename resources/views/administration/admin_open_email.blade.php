@extends('components.app')

@section('content')

        <div class="row">
            <div class="col">
                <div class="card border-none shadow-none">
                    <div class="card-body">
                        <div class="row"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>
                        <div class="row mt-4"><h2 class="fw-light">Subject Here</h2></div>
                        <div class="row"><small>John Doe <div class="fst-italic">(email@bu-u.edu.ph)</div></small></div>
                    </div>
                    <div class="card-body">
                        <p class="border-bottom">This will be the container of the email details</p>
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-primary" id="replyEmail"><i class='bx bx-reply' >&nbsp;</i>Reply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="card card-reply" style="display: none;" id="messageCard">
                    <div class="card-body">
                        <form action="" id="emailReply">
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

@endsection



@section('components.specific_page_scripts')
{{-- SENDING EMAIL FOR SPINNER AND STATUS START --}}
<script>
    $(document).ready(function() {

        // Ensure success and failed messages are hidden on page load
        $('#emailSuccess').hide();
        $('#emailFailed').hide();

        $('#sendButton').on('click', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Show the spinner and hide success and failed messages
            $('#spinner').show();
            $('#emailSuccess').hide();
            $('#emailFailed').hide();

            // Simulate an asynchronous operation (e.g., an AJAX request)
            setTimeout(function() {
                // Hide the spinner
                $('#spinner').hide();

                // Logic to determine success or failure
                const isSuccess = Math.random() > 0.5; // Replace with actual success/failure logic
                if (isSuccess) {
                    $('#emailSuccess').show();
                } else {
                    $('#emailFailed').show();
                }
            }, 2000); // Simulate a 2-second delay for the operation
        });
    });
    </script>
{{-- SENDING EMAIL FOR SPINNER AND STATUS END--}}



{{-- CLEARING AND HIDING OF REPLY EMAIL CARD START--}}
<script>
    $(document).ready(function() {
        // Show the message card when the reply button is clicked
        $('#replyEmail').on('click', function() {
            $('#messageCard').show();
        });

        // Hide the card and clear the input fields when the trigger button is clicked
        $('#removeEmailReply').on('click', function() {
            $('#messageCard').hide();
            $('#emailReply').find('input[type="text"], textarea').val('');
        });
    });
</script>
{{-- CLEARING AND HIDING OF REPLY EMAIL CARD END--}}
@endsection



