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
                    <input type="hidden" name="id" id="user_id">
                    <input type="hidden" name="trans_id" id="trans_id">
                    <div class="text-dark send_to"><b>To:&nbsp;</b>&nbsp;<small class="text-secondary"
                            style="font-style: italic;"></small></div>
                </div>
            </div>

            <div class="form-floating mb-4 border-bottom">
                <input type="text" class="form-control border-none" id="floatingInput" placeholder="" aria-describedby="floatingInputHelp"  name="subject" />
                <label for="floatingInput">Subject</label>
            </div>
            <div >
                <label for="floatingInput">Subject</label>
                <textarea class="form-control" id="emailTextArea" name="message" rows="3" placeholder="Message" style="border: none;"></textarea>
            </div>
            {{-- <div class="border-bottom">
                <small class="text-danger" id="label" style="display: none;">Please specify the reason for holding this transaction.</small>
            </div> --}}

            @if(Auth::user()->usertype->name !== 'Faculty')

            <div class="mt-4 checklist">
                <div>
                    <small class="text-danger">Check the missing document that needs for compliance</small>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="documentation[]" value="Daily Time Record (DTR)" id="defaultCheck1" />
                    <label class="form-check-label" for="defaultCheck1">
                      Daily Time Record (DTR)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="documentation[]" value="Teaching Appointment" id="defaultCheck1" />
                    <label class="form-check-label" for="defaultCheck1">
                      Teaching Appointment
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="documentation[]" value="Manual Entry" id="defaultCheck1" />
                    <label class="form-check-label" for="defaultCheck1">
                      Manual Entry
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="documentation[]" value="Others" id="defaultCheck1" />
                    <label class="form-check-label" for="defaultCheck1">
                      Others
                    </label>
                </div>
            </div>

            @endif

            <div class="border-top mt-3">
                <div class="d-flex flex-row justify-content-end mt-3 gap-2">
                    <button type="button" class="btn btn-label-danger border-none btn-trash bg-transparent" id="discard"><i class='bx bxs-trash-alt'></i></button>
                    <button type="submit" class="btn btn-primary" id="sendButton"><i class='bx bxs-send'>&nbsp;</i>Send</button>
                </div>
            </div>
        </form>
    </div>
</div>
