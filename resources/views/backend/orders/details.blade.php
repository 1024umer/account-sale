@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - User ' . $user->name)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-user-view.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/modal-edit-user.js') }}"></script>
    <script src="{{ asset('assets/js/app-user-view.js') }}"></script>
    <script src="{{ asset('assets/js/app-user-view-account.js') }}"></script>
@endsection

@section('content')

    <h4 class="fw-bold py-3 mb-4 d-block d-md-flex justify-content-between align-items-center">
        <div>

            <span class="text-muted fw-light">Maunal Order / Details /</span> {{ $user->user->name }}
        </div>
        {{-- <div>
            <button onclick="window.location.href = '/admin/manualorders/';" class="btn btn-primary">Back</button>
        </div> --}}
    </h4>

    <div class="row">
        <!-- User Content -->
        <div class="col-xl-12 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Pills -->
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                            class="ti ti-user-check ti-xs me-1"></i>Manual Orders</a></li>
            </ul>
            <!--/ User Pills -->

            <!-- Project table -->
            <div class="card mb-4">
                <h5 class="card-header">User's Details</h5>
                <div class="card-body">
                    <form action="{{ route('admin.manualorders.update') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="id">
                        <div class="mb-3">
                            <label class="form-label" for="add-user-email">Name</label>
                            <input type="text" id="email" value="{{ $user->user->name }}" readonly class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="add-user-email">Payment Proof</label><br>
                            <img src="{{asset('public/'.$user->image)}}" alt="Image" height="400px" width="400px">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="user-role">Payment Status</label>
                            <select id="user-role" name="status" class="form-select">
                                @if($user->status == 'pending')
                                <option value="active">{{ $user->status }}</option>
                                <option value="success">Approve</option>
                                <option value="canceled">Cancel</option>
                                @else
                                <option value="active" selected>{{ $user->status }}</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Update</button>
                    </form>
                </div>
            </div>
            <!-- /Project table -->
        </div>
        <!--/ User Content -->
    </div>
@endsection
