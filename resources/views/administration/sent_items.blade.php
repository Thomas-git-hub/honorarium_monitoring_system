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



@endsection
