@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Roles')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->

@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
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
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>

    <script>
        (function() { // webpackBootstrap
            /******/
            "use strict";
            var __webpack_exports__ = {};
            $('#main-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.roles.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'permissions',
                        render: function(data) {
                            var temp22 = '';
                            data.forEach(item => {
                                var badgeClass = '';
                                switch (item.type) {
                                    case 'Master':
                                        badgeClass =
                                        'bg-label-success';
                                        break;
                                    case 'Module':
                                        badgeClass =
                                        'bg-label-info';
                                        break;
                                    case 'Category':
                                        badgeClass =
                                        'bg-label-warning';
                                        break;
                                    case 'Sub Category':
                                        badgeClass =
                                        'bg-label-secondary';
                                        break;
                                    case 'Sub Sub Category':
                                        badgeClass =
                                        'bg-label-secondary';
                                        break;
                                    default:
                                        badgeClass =
                                        'bg-label-default';
                                        break;
                                }
                                temp22 += '<span class="badge ' + badgeClass +
                                    ' me-1 rounded">' +
                                    item.name + '</span>';
                            });
                            return temp22;
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
                    text: "You won't be able to revert this! The associated users with this role will be converted to User role.",
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
                            url: "".concat(baseUrl, "admin/roles/delete/").concat(user_id),
                            success: function success() {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The Role has been deleted.',
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
                            text: 'The Role is not deleted!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.edit-btn', function() {
                $('#addNewUserForm').attr('action', `{{ route('admin.roles.update') }}`);
                $('#id').val($(this).data('id'));
                var permissions = $(this).data('permissions');
                permissions.forEach(element => {
                    var tt = $('.permissions').find('option[value="' + element.permission_id + '"]').prop('selected', true);
                });
                $('#name').val($(this).data('name'));
            });

            $(document).on('click', '.addBtn', function() {
                $('#name').val('');
                $('#addNewUserForm').attr('action', `{{ route('admin.roles.add') }}`);
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
                            <span>Roles</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalRoles }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Roles</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-list ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Users List Table -->
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-block d-md-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Search Filter</h5>
                    <button class="btn btn-primary mt-2 mt-md-0 addBtn" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddUser" aria-controls="offcanvasAddUser"> + Add new</button>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="main-table" class="datatables-users table">
                        <thead class="border-top">
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- Offcanvas to add new user -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
                    aria-labelledby="offcanvasAddUserLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Role</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body mx-0 flex-grow-0 pb-5">
                        <form action="{{ route('admin.roles.add') }}" method="post" class="add-new-user pt-0 pb-5"
                            id="addNewUserForm">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="mb-3">
                                <label class="form-label" for="add-user-fullname">Name</label>
                                <input type="text" class="form-control" required value="{{ old('name') }}"
                                    id="name" placeholder="Role name" name="name" aria-label="John Doe" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-user-fullname">Permissions</label>
                                <select id="select2Multiple" name="permissions[]" required class="select2 permissions form-select h-100"
                                    multiple>
                                    @php
                                        $groupedPermissions = $permissions->groupBy('type');
                                    @endphp

                                    @foreach ($groupedPermissions as $type => $permissionGroup)
                                        <optgroup label="{{ ucfirst($type) }}">
                                            @foreach ($permissionGroup as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>

                                <p class="pt-3"><strong>Note: </strong> If you select any from master select one and do
                                    not select any other after that</p>
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
                            <button type="reset" class="btn btn-label-secondary"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Available Permissions</h5>
                    <p>Master</p>
                    @foreach ($permissions as $pr)
                        @if ($pr->type == 'Master')
                            <span class="badge badge-sm bg-label-success mb-1 rounded">
                                {{ $pr->name }}
                            </span>
                            <br>
                        @endif
                    @endforeach
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p>Modules</p>
                            @foreach ($permissions as $pr)
                                @if ($pr->type == 'Module')
                                    <span class="badge badge-sm bg-label-info mb-1 rounded">
                                        {{ $pr->name }}
                                    </span>
                                    <br>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <p>Categories</p>
                            @foreach ($permissions as $pr)
                                @if ($pr->type == 'Category')
                                    <span class="badge badge-sm bg-label-warning mb-1 rounded">
                                        {{ $pr->name }}
                                    </span>
                                    <br>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <p>Sub Categories</p>
                            @foreach ($permissions as $pr)
                                @if ($pr->type == 'Sub Category')
                                    <span class="badge badge-sm bg-label-secondary mb-1 rounded">
                                        {{ $pr->name }}
                                    </span>
                                    <br>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <p>Sub Sub Categories</p>
                            @foreach ($permissions as $pr)
                                @if ($pr->type == 'Sub Sub Category')
                                    <span class="badge badge-sm bg-label-secondary mb-1 rounded">
                                        {{ $pr->name }}
                                    </span>
                                    <br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
