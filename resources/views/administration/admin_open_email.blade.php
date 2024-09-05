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
                        <!-- End Offcanvas -->
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd"><i class='bx bx-reply' >&nbsp;</i>Reply</button>
                        @include('administration.send_email')
                    </div>
                </div>
            </div>
        </div>

@endsection
