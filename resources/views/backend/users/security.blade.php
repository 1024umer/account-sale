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

        <span class="text-muted fw-light">User / Details /</span> {{ $user->name }}
    </div>
    <div>
        <button onclick="window.location.href = '/admin/users/';" class="btn btn-primary">Back</button>
    </div>
</h4>

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset('assets/img/avatars/13.png') }}"
                                height="100" width="100" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $user->name }}</h4>
                                <span class="badge bg-label-secondary mt-1">{{ $user->role->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                        <div class="d-flex align-items-start me-4 mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-checkbox ti-sm'></i></span>
                            <div>
                                <p class="mb-0 fw-semibold">{{ count($user->transactions) }}</p>
                                <small>Transactions</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-briefcase ti-sm'></i></span>
                            <div>
                                <p class="mb-0 fw-semibold">{{ count($user->orders) }}</p>
                                <small>Orders</small>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 small text-uppercase text-muted">Details</p>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-semibold me-1">Username:</span>
                                <span>{{ $user->username }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Email:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Status:</span>
                                @if ($user->status == 'active')
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-warning">Inactive</span>
                                @endif
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Contact:</span>
                                <span>{{ $user->phone }}</span>
                            </li>
                            <li class="pt-1">
                                <span class="fw-semibold me-1">Country:</span>
                                <span>{{ $user->country }}</span>
                            </li>
                            <li class="pt-1">
                                <span class="fw-semibold me-1">State:</span>
                                <span>{{ $user->state }}</span>
                            </li>
                            <li class="pt-1">
                                <span class="fw-semibold me-1">City:</span>
                                <span>{{ $user->city }}</span>
                            </li>
                            <li class="pt-1">
                                <span class="fw-semibold me-1">Postal Code:</span>
                                <span>{{ $user->postal_code }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Pills -->
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.details', ['id' => $user->id]) }}"><i
                            class="ti ti-user-check ti-xs me-1"></i>Account</a></li>
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                            class="ti ti-lock ti-xs me-1"></i>Security</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="{{ url('app/user/view/billing') }}"><i
                            class="ti ti-currency-dollar ti-xs me-1"></i>Transaction</a></li> --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.orders', ['id' => $user->id]) }}"><i
                            class="ti ti-bell ti-xs me-1"></i>Orders</a></li>
            </ul>
            <!--/ User Pills -->

            <!-- Project table -->
            <div class="card mb-4">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <form id="formChangePassword" method="POST" action="{{ route('admin.users.security.update') }}">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="id">
                        <div class="alert alert-warning" role="alert">
                            <h5 class="alert-heading mb-2">Ensure that these requirements are met</h5>
                            <span>Minimum 8 characters long</span>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <label class="form-label" for="newPassword">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="newPassword" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" name="password_confirmation"
                                        id="confirmPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
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
                            <div>
                                <button type="submit" class="btn btn-primary me-2">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Project table -->
        </div>
        <!--/ User Content -->
    </div>
@endsection
