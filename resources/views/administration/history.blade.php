@extends('components.app')

@section('content')
    <div class="row mt-4">
        <h4 class="card-title text-secondary">History</h4>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="historyTable" class="table table-borderless table-hover" style="width:100%">
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
@endsection
