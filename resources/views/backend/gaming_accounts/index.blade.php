@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Gaming Accounts')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


@endsection

@section('page-style')
    <!-- Page -->
    <style>
        .swal2-popup {
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
                ajax: '{!! route('admin.gamingaccounts.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        render: function(data, type, row) {
                            var editUrl = "{{ route('admin.gamingaccounts.edit', ['id' => ':id']) }}";
                            editUrl = editUrl.replace(':id', row.id);

                            return '<a href="' + editUrl + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'price',
                        name: 'price'
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
                    // {
                    //     data: 'product_status',
                    //     render: function(data) {
                    //         if (data == 'available') {
                    //             return '<span class="badge bg-info text-white">Available</span>';
                    //         } else {
                    //             return '<span class="badge bg-secondary">Sold</span>';
                    //         }
                    //     }
                    // },
                    {
                        data: 'available_channels_count',
                        render: function(data) {
                            if (data > 0) {
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
                            url: "".concat(baseUrl, "admin/gamingaccounts/status/").concat(id),
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
                            url: "".concat(baseUrl, "admin/gamingaccounts/delete/").concat(
                                user_id),
                            success: function success() {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The Gaming account has been deleted.',
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
                            text: 'The gaming account is not deleted!',
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
                url: "".concat(baseUrl, "admin/gamingaccounts/details/").concat(dataId),
                success: function(response) {
                    let formattedText = "<table class='table text-start'>";
                    formattedText += "<thead><tr><th scope='col'>Credentials</th><th scope='col'>Status</th></tr></thead><tbody>";

                    response.forEach(function(emailChannel, index) {
                        formattedText += '<tr>';
                        formattedText += '<td>';
                        formattedText += '<strong>' + (emailChannel.format || 'No format available') + '</strong><br>';
                        formattedText += '<strong>' + (emailChannel.value1 || 'No value1 available') + '</strong><br>';
                        formattedText += '</td>';
                        formattedText += '<td>' + (emailChannel.status || 'No status available') + '</td>';
                        formattedText += '</tr>';
                    });

                    formattedText += "</tbody></table>";
                    Swal.fire({
                        title: 'Account details.',
                        html: formattedText,
                        icon: false,
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                        },
                        buttonsStyling: false
                    });
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
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
          }
          else {
              $("#custom_stock_field").empty();
              $("#custom_stock_field").remove();
          }
      }
  </script>
    <script>
    $(document).on('click', '.restock-btn', function() {
              var accountId = $(this).data('id');
              $('#accountid').val(accountId);
              $('#exampleModal').modal('show');

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
                            <span>Gaming Accounts</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalAccount }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Accounts</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-device-gamepad ti-sm"></i>
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
            <a href="{{ route('admin.gamingaccounts.new') }}" class="btn btn-primary"> + Add new</a>
            <a href="{{ route('export') }}" class="btn btn-secondary"> Download</a>
        </div>
        <div class="card-datatable table-responsive">
            <table id="main-table" class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Status</th>
                        <!--<th>Product Status</th>-->
                        <th>Account Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Account Credentials Serials</h5>
          </div>
          <div class="modal-body">
            <form id="restockForm" action="{{ route('admin.gamingaccounts.restock') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="mb-3" id="stock_field">
                    <label class="form-label" for="">Stock Delimiter</label>
                    <input type="hidden" id="accountid" name="accountid" value="">
                    <select name="stock_delimiter" class="form-control" id="" onchange="stock_delimiter_change(this.value)">
                        <option value="comma">Comma</option>
                        <option value="newline">New line</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="basic-default-phone">Format</label>
                  <input type="text" id="format" class="form-control" name="format" required />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="">Serials List</label>
                    <textarea name="stock_list" class="form-control p-1" id="stock_list" required id="" rows="5" style="width: 100%"></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-check-label" for="manual">Account</label>
                  <input type="checkbox" id="check_box_value" name="check_box_value" value="1">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Restock</button>
            </div>
            </form>
          </div>

        </div>
      </div>
    </div>
@endsection
