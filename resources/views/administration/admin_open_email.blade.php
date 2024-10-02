@extends('components.app')

@section('content')

        {{-- @include('administration.toast') --}}
        <!-- Toast Container -->

        <div class="row">
            <div class="col">
                <div class="card border-none shadow-none">
                    <div class="card-body">
                        <div class="row"><a class=""><i class='bx bx-left-arrow-alt text-primary' id="navigatePrevious" style="font-size: 2em; cursor: pointer;"></i></a></div>
                        <div class="row mt-4"><h2 class="fw-light">{{ $data->subject}}</h2></div>
                        <div class="row"><small>{{$data->employee->first_name. ' ' .$data->employee->last_name}} <div class="fst-italic">({{$data->employee->email}})</div></small></div>
                    </div>
                    <div class="card-body">
                        <p class="border-bottom">{{$data->message}}</p>

                        @if(is_array($docuJson) || is_countable($docuJson) > 0)

                        <p><strong>Missing Documents:</strong></p>
                        <ul>
                            @foreach($docuJson as $document)
                                <li>{{ $document }}</li>
                            @endforeach
                        </ul>

                        @endif
                        <!-- End Offcanvas -->
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd"><i class='bx bx-reply' >&nbsp;</i>Reply</button>
                    </div>
                </div>
            </div>
        </div>

@include('administration.email_toast')


@endsection

@section('components.specific_page_scripts')
<script>
     $(function () {
        var send_to_id = {!! json_encode($data->employee->employee_id) !!};
        var facultyName = {!! json_encode($data->employee->first_name) !!};
        var facultyEmail = {!! json_encode($data->employee->email) !!};
        console.log(send_to_id);

        $('#user_id').val(send_to_id);
        $('.card-body .text-dark').html(`<b>To:&nbsp;</b> ${facultyName}&nbsp;<small class="text-secondary" style="font-style: italic;">${facultyEmail}</small>`);


        $('#sendButton').on('click', function(event) {
            event.preventDefault();
            $('#spinner').show();

            var formData = {
                user_id: $('#user_id').val(),
                subject: $('#floatingInput').val(),
                message: $('#emailTextArea').val(),
                date_of_trans: $('#dateReceived').val(),
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('send_reply') }}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    if(response.success){
                        $('#spinner').hide();
                        $('#toastSuccess').toast('show');

                    }else{
                        $('#spinner').hide();
                        $('#sendingFailed').toast('show');
                    }
                },
                error: function(xhr, status, error) {
                    $('#spinner').hide();
                    $('#sendingFailed').toast('show');

                    console.error('AJAX Error:', status, error);
                }

            });



        });
     })
</script>

@endsection


