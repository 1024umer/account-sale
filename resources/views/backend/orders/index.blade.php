@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Orders')

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
                ajax: '{!! route('admin.orders.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'product_title',
                        name: 'product_title'
                    },
                    {
                        data: 'product_type',
                        name: 'product_type'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'easy_mode',
                        name: 'easy_mode'
                    },
                     {
                        data: 'ip_address',
                        name: 'ip_address'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'using_proxy',
                        name: 'using_proxy'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            if (data == 'success') {
                                return '<span class="badge rounded-pill bg-label-success">Success</span>';
                            } else if (data == 'pending') {
                                return '<span class="badge rounded-pill bg-label-warning">Pending</span>';
                            } else if (data == 'canceled') {
                                return '<span class="badge rounded-pill bg-label-danger">Canceled</span>';
                            }
                        }
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
                drawCallback: function(settings) {
                    // feather.replace();
                }
            });

        })();
    </script>
       <script>
        $(document).on('click', '.block-proxy-button', function () {
            const userId = $(this).data('user');
            const ipAddress = $(this).data('ip');
            const url = $(this).data('url');

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will block the user with IP address ' + ipAddress,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, block it!'
            }).then((result) => {
                // If the user clicks "Yes"
                if (result.isConfirmed) {
                    // Send an AJAX request to store data in the using_proxy_users table
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: { userId: userId, ipAddress: ipAddress, _token: $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            // Handle success response
                            Swal.fire('Blocked!', 'The user has been blocked.', 'success');
                        },
                        error: function (error) {
                            // Handle error response
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    </script>
  <script>
function openRestockModal(userId) {
    // Make an AJAX request to fetch the total gaming accounts and account details
    $.ajax({
        url: '/admin/orders/account-details/' + userId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Set the user id and total accounts in the modal
            $('#userIdInput').val(userId);
            $('#totalAccounts').text(response.totalGamingAccounts);

            // Display account titles in the modal or show a message if no accounts available
            var accountList = $('#accountList');
            accountList.empty();

            if (response.totalGamingAccounts > 0) {
                response.accounts.forEach(function(account) {
                    accountList.append('<li>' + account.title + '</li>');
                });
                // Show the input field when accounts are available
                $('#number').show();
                // Show the button when accounts are available
                $('#confirmRestockBtn').show(); // Corrected selector
            } else {
                accountList.append('<li>No accounts available</li>');
                // Hide the input field when no accounts are available
                $('#number').hide();
                // Hide the button when no accounts are available
                $('#confirmRestockBtn').hide(); // Corrected selector
            }

            // Show the modal
            $('#restockModal').modal('show');
        },
        error: function(error) {
            console.error('Error fetching total gaming accounts:', error);
        }
    });
}



</script>
{{-- <script>
  $(document).ready(function () {
      $('#restockForm').submit(function (e) {
          e.preventDefault(); // Prevent the default form submission

          var userId = $('#userIdInput').val();
          var quantity = $('[name="number"]').val();

          $.ajax({
              type: 'POST',
              url: '{{ route("admin.orders.update.account.status", ['userid' => ':userid']) }}'.replace(':userid', userId),
              data: {
                  _token: '{{ csrf_token() }}',
                  userId: userId,
                  quantity: quantity
              },
              success: function (data) {
                  if (data.success) {
                      // Display a success message using SweetAlert
                      Swal.fire({
                          title: "Success!",
                          text: "Status updated successfully.",
                          icon: "success",
                          confirmButtonColor: "#3085d6",
                          confirmButtonText: "OK"
                      }).then((result) => {
                          // You can perform additional actions after the user clicks OK
                          if (result.isConfirmed) {
                            $('#restockModal').modal('hide');
                            var emailData = data.emailData;

                            // Use dd() to dump the emailData to Laravel Debugbar (if installed)
                            console.log('Email Data:', emailData);
                          }
                      });
                  } else {
                      // Handle other scenarios if needed
                      console.log('Status update failed. Response:', data);
                  }
              },
              error: function (error) {
                  // Handle the error response here
                  console.log('Error updating status. Error:', error);
              }
          });
      });
  });
</script> --}}

<script>
  document.getElementById('confirmRestockBtn').addEventListener('click', function () {
      var userId = document.getElementById('userIdInput').value;
      var quantity = document.getElementsByName('number')[0].value;

      Swal.fire({
          title: 'Are you sure?',
          text: 'You are about to restock ' + quantity + ' item(s).',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, restock it!'
      }).then((result) => {
          if (result.isConfirmed) {
              // AJAX request to submit the form
              var form = document.getElementById('restockForm');
              var formData = new FormData(form);

              fetch(form.action, {
                  method: 'POST',
                  body: formData,
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      Swal.fire({
                          title: 'Success!',
                          text: 'Status updated successfully',
                          icon: 'success'
                      });

                      // Hide the Bootstrap modal
                      $('#restockModal').modal('hide');
                  } else {
                      Swal.fire({
                          title: 'Error!',
                          text: 'An error occurred while updating the status',
                          icon: 'error'
                      });
                  }
              })
              .catch(error => {
                  console.error('Error:', error);
                  Swal.fire({
                      title: 'Error!',
                      text: 'Something Went Wrong',
                      icon: 'error'
                  });
              });
          }
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
                            <span>Orders</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalOrders }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Orders</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-report-money ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="restockModal" tabindex="-1" role="dialog" aria-labelledby="restockModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="restockModalLabel">Account Details</h5>
              </div>
              <div class="modal-body">
                  <p>Total Accounts: <span id="totalAccounts"></span></p>
                  <p>Accounts Title</p>
                  <ul id="accountList"></ul>

                  <form id="restockForm" method="post" action="{{ route('admin.orders.updateAccountStatus') }}">
                    @csrf
                    <input type="hidden" id="userIdInput" name="userId" value="">
                    <input type="number" name="number" id="number" class="form-control" min="1" value="1">
                    <div id="confirmRestockBtn">
                    <button type="button" id="confirmRestockBtn" class="btn btn-primary confirmRestockBtn">Confirm Restock</button>
                  </div>
                </form>
              </div>
          </div>
      </div>
  </div>

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Search Filter</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table id="main-table" class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>User</th>
                        <th>Product Title</th>
                        <th>Product Type</th>
                        <th>Amount</th>
                        <th>Mode</th>
                        <th>Ip Addres</th>
                        <th>Country</th>
                        <th>Using Proxy</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
