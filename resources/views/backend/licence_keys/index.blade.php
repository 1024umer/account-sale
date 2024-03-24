@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Licence Keys')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <style>
        .swal-table {
            width: 40vw;
        }
        .swal2-title {
            margin: auto;
        }
    </style>
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

    <script>
        (function() { // webpackBootstrap
            /******/
            "use strict";
            var __webpack_exports__ = {};
            $('#main-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.licencekeys.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        render: function(data, type, row) {
                            var editUrl = "{{ route('admin.licencekeys.edit', ['id' => ':id']) }}";
                            editUrl = editUrl.replace(':id', row.id);

                            return '<a href="' + editUrl + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            if (data == 'active') {
                                return '<span class="badge bg-info text-white">Active</span>';
                            } else {
                                return '<span class="badge bg-secondary">Inactive</span>';
                            }
                        }
                    },
                    {
                        data: 'product_status',
                        render: function(data) {
                            if (data == 'available') {
                                return '<span class="badge bg-info text-white">Available</span>';
                            } else {
                                return '<span class="badge bg-secondary">Sold</span>';
                            }
                        }
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

            // change status
            $('body').on('click', '.change-status-btn', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure you want to change the status?',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        // change the status
                        $.ajax({
                            type: 'GET',
                            url: "".concat(baseUrl, "admin/licencekeys/status/").concat(id),
                            data: {
                                status: status
                            },
                            success: function success() {
                                Swal.fire({
                                    title: 'Status changed successfully!',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary me-3',
                                        cancelButton: 'btn btn-label-secondary'
                                    },
                                    buttonsStyling: false
                                }).then(function(result) {
                                    if (result.value) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function error(_error2) {
                                console.log(_error2);
                            }
                        });

                    }
                });
            });

            // delete user
            $(document).on('click', '.delete-btn', function() {
                var user_id = $(this).data('id'),
                    dtrModal = $('.dtr-bs-modal.show');

                // hide responsive modal in small screen
                if (dtrModal.length) {
                    dtrModal.modal('hide');
                }

                // sweetalert for confirmation of delete
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        // delete the data
                        $.ajax({
                            type: 'GET',
                            url: "".concat(baseUrl, "admin/licencekeys/delete/").concat(
                                user_id),
                            success: function success() {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The licence key has been deleted.',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary me-3',
                                    },
                                    buttonsStyling: false
                                }).then(function(result) {
                                    if (result.value) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function error(_error) {
                                console.log(_error);
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The licence key is not deleted!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.details-btn', function() {
                var dataId = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: "".concat(baseUrl, "admin/licencekeys/details/").concat(
                        dataId),
                    success: function success(response) {
                        let formattedText = "<table class='table text-start swal-table'>";
                        formattedText += "<thead><tr><th scope='col'>Credentials</th><th scope='col'>Status</th></tr></thead><tbody>";

                        response.forEach(function(keyChannel, index) {
                            formattedText += `<tr>`;
                            formattedText += `<td>Key: ${keyChannel.key}<br>Price: ${keyChannel.price}</td>`;
                            formattedText += `<td>${keyChannel.status}<br>${keyChannel.days} days</td>`;
                            formattedText += `</tr>`;
                        });

                        formattedText += "</tbody></table>";
                        Swal.fire({
                            title: 'Licence key details.',
                            html: formattedText,
                            icon: false,
                            customClass: {
                                confirmButton: 'btn btn-primary me-3',
                            },
                            buttonsStyling: false
                        });
                        console.log(response);
                    },
                    error: function error(_error) {
                        console.log(_error);
                    }
                });
            });

            var __webpack_export_target__ = window;
            for (var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
            if (__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", {
                value: true
            });
        })();
    </script>
@endsection

@section('content')

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Licence Keys</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalKeys }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Keys</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-key ti-sm"></i>
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
            <a href="{{ route('admin.licencekeys.new') }}" class="btn btn-primary"> + Add new</a>
        </div>
        <div class="card-datatable table-responsive">
            <table id="main-table" class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Product Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
