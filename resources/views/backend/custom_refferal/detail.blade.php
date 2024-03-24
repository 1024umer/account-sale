@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - User Detail')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel='stylesheet' href='https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css'>

@endsection

@section('page-style')
    <!-- Page -->

@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>

    {{-- <script>
        (function() { // webpackBootstrap
            /******/
            "use strict";
            var __webpack_exports__ = {};
            $('#main-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.customrefferal.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'refferal_name',
                        name: 'refferal_name'
                    },
                    {
                        data: 'refferal_link',
                        name: 'refferal_link'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function(settings) {
                    // feather.replace();
                }
            });

            var __webpack_export_target__ = window;
            for (var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
            if (__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", {
                value: true
            });
            /******/
        })();
    </script> --}}

    <script src='https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js'></script>
<script>
    $(document).ready(function() {
    var dataTable = $('#dtBasicExample').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Searh here...",
            lengthMenu:     "Showing _MENU_",
        },
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        responsive: true,
        'serverMethod': 'get',

    });
});
</script>
@endsection

@section('content')

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Custom Refferal</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalUsers }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Custom Refferal</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-ticket ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Total Visiter</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ count($totalvisiter) }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Visiter</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-ticket ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Users List Table -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Search Filter</h5>
    </div>
        <div class="card-datatable table-responsive">
            <table id="dtBasicExample" class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                  @forelse ($users as $iteration => $user)
                      <tr>
                          <td>{{ $user->id }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->country }}</td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="3">No users found for the referral</td>
                      </tr>
                  @endforelse
              </tbody>
            </table>
        </div>
    </div>

@endsection
