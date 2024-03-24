@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Users')

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
                ajax: '{!! route('admin.volume.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            if (data == 'active') {
                                return '<span class="badge bg-label-info">Active</span>';
                            } else {
                                return '<span class="badge bg-label-secondary">Used</span>';
                            }
                        }
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
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
                            url: "".concat(baseUrl, "admin/users/status/").concat(id),
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
                            url: "".concat(baseUrl, "admin/users/delete/").concat(user_id),
                            success: function success() {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The User has been deleted.',
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
                            error: function error(_error) {
                                console.log(_error);
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The User is not deleted!',
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
                window.location.href = '{{ url('/admin/users/details/') }}' + '/' + dataId;
            });

            var __webpack_export_target__ = window;
            for (var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
            if (__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", {
                value: true
            });
            /******/
        })();
    </script>

    <script></script>
@endsection

@section('content')
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Search Filter</h5>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"
                aria-controls="offcanvasAddUser"> + Add new</button>
        </div>
        <div class="card-datatable table-responsive">
            <table id="main-table" class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Quantity</th>
                        <th>Price (%)</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Volume Discount</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form action="{{ route('admin.volume.add') }}" class="add-new-user pt-0" method="post"
                    id="addNewUserForm">
                    @csrf
                    <div id="items-container">
                        <div class="mb-3">
                            <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" name="price[]" class="form-control" placeholder="Price" required>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success add-item">+</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3" role="alert">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                    <br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Add fields dynamically
            $('.add-item').click(function() {
                $('#items-container').append(
                    '<div class="mb-3">' +
                    '<input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>' +
                    '</div>' +
                    '<div class="mb-3">' +
                    '<input type="number" name="price[]" class="form-control" placeholder="Price" required>' +
                    '</div>' +
                    '<div class="mb-3">' +
                    '<button type="button" class="btn btn-danger remove-item">-</button>' +
                    '</div>' +
                    '</div>'
                );
            });

            // Remove fields
            $('#items-container').on('click', '.remove-item', function() {
                $(this).parent().remove();
            });
        });
    </script>

@endsection
