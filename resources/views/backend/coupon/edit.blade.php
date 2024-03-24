@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - User ')

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
                    <form action="{{ route('admin.coupon.update') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $setting->id }}" name="id">
                        <div class="mb-3">
                            <label class="form-label" for="add-user-email">Name</label>
                            <input type="text" id="email" value="{{ $setting->name }}" readonly
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Account Credentials Serials</h5>
                            </div>
                            <div class="mb-3" id="stock_field">
                                <label class="form-label" for="">Stock Delimiter</label>
                                <select name="stock_delimiter" class="form-control" id=""
                                    onchange="stock_delimiter_change(this.value)">
                                    <option value="comma">Comma</option>
                                    <option value="newline">New line</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="">Serials List</label>
                                <textarea name="stock_list" class="form-control p-1" placeholder="1, 2, 3, 4 ..." id="" rows="5"
                                    style="width: 100%">{{$setting->settings}}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Update</button>
                    </form>
                </div>
            </div>
            <!-- /Project table -->
        </div>
        <!--/ User Content -->
    </div>
    <script>
        function stock_delimiter_change(value) {
            if (value == 'custom') {
                $("#stock_field").after(
                    `<div class="mb-3" id="custom_stock_field">
                        <label class="form-label" for="">Custom Stock Delimiter</label>
                        <input type="text" required class="form-control" value=""
                                name="custom_stock_delimiter">
                    </div>`
                );
            } else {
                $("#custom_stock_field").empty();
                $("#custom_stock_field").remove();
            }
        }
    </script>
@endsection
