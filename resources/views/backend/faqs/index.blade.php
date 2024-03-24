@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Faqs')

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
                ajax: '{!! route('admin.faqs.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'answer',
                        name: 'answer'
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

            $(document).on('click', '.edit-btn', function() {
                $('#addNewUserForm').attr('action', `{{ route('admin.faqs.update') }}`);
                $('#id').val($(this).data('id'));
                $('#question').val($(this).data('question'));
                $('#answer').val($(this).data('answer'));
            });

            $(document).on('click', '.addBtn', function() {
                $('#question').val('');
                $('#answer').val('');
                $('#addNewUserForm').attr('action', `{{ route('admin.faqs.add') }}`);
            });


            // delete category
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
                            url: "".concat(baseUrl, "admin/faqs/delete/").concat(user_id),
                            success: function success() {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The faq has been deleted.',
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
                        // success sweetalert
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The faq is not deleted!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            var __webpack_export_target__ = window;
            for (var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
            if (__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", {
                value: true
            });
            /******/
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
                            <span>Faqs</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalCategory }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Faqs</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-question-mark ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header d-block d-md-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Search Filter</h5>
            <button class="btn btn-primary mt-2 mt-md-0 addBtn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser" aria-controls="offcanvasAddUser"> + Add new</button>
        </div>
        <div class="card-datatable table-responsive">
            <table id="main-table" class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add FAQs</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form action="{{ route('admin.faqs.add') }}" method="post" class="add-new-user pt-0" id="addNewUserForm">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="mb-3">
                        <label class="form-label" for="add-user-fullname">Question</label>
                        <input type="text" class="form-control" value="{{ old('question') }}" id="question"
                            name="question" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-fullname">Answer</label>
                        <textarea name="answer" id="answer" class="form-control" cols="30" rows="10"></textarea>
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

@endsection
