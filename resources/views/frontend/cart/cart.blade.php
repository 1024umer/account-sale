@extends('frontend.layout')

@section('content')

    <head>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


        <style>
            .thumbnail {
                position: relative;
                padding: 0px;
                margin-bottom: 20px;
            }

            .thumbnail img {
                width: 80%;
            }

            .thumbnail .caption {
                margin: 7px;
            }

            .main-section {
                background-color: #F8F8F8;
            }

            .dropdown {
                float: right;
                padding-right: 30px;
            }

            .btn {
                border: 0px;
                margin: 10px 0px;
                box-shadow: none !important;
            }

            .dropdown .dropdown-menu {
                padding: 20px;
                top: 30px !important;
                width: 350px !important;
                left: -110px !important;
                box-shadow: 0px 5px 30px black;
            }

            .total-section p {
                margin-bottom: 20px;
            }

            .cart-detail {
                padding: 15px 0px;
            }

            .cart-detail-img img {
                width: 100%;
                height: 100%;
                padding-left: 15px;
            }

            .cart-detail-product p {
                margin: 0px;
                color: #000;
                font-weight: 500;
            }

            .cart-detail .price {
                font-size: 12px;
                margin-right: 10px;
                font-weight: 500;
            }

            .cart-detail .count {
                color: #C2C2DC;
            }

            .checkout {
                border-top: 1px solid #d2d2d2;
                padding-top: 15px;
            }

            .checkout .btn-primary {
                border-radius: 50px;
                height: 50px;
            }

            .dropdown-menu:before {
                content: " ";
                position: absolute;
                top: -20px;
                right: 50px;
                border: 10px solid transparent;
                border-bottom-color: #fff;
            }

            header .navbar {
                position: static !important;
            }
        </style>
        <style>
            .table-wrapper {
                overflow-y: auto;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="table-wrapper">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th style="width: 10%">Quantity</th>
                                    <th class="text-center">Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp
                                @if (session('cart'))
                                    @foreach (session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity']  @endphp

                                        @php
                                            $image = App\Models\GamingAccount::findOrFail($id);

                                        @endphp
                                        <tr data-id="{{ $id }}">
                                            <td data-th="Product">
                                                <div class="row">

                                                    <div class="col-sm-3 hidden-xs"><img src="{{ $image->main_image }}"
                                                            width="100" height="100" class="img-responsive" /></div>
                                                    <div class="col-sm-9">
                                                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-th="Price">${{ $details['price'] }}</td>
                                            <td data-th="Quantity">
                                                <input type="number" value="{{ $details['quantity'] }}"
                                                    class="form-control quantity update-cart" />
                                            </td>
                                            <td data-th="Subtotal" class="text-center">
                                                ${{ $details['price'] * $details['quantity'] }}</td>
                                            <td class="actions" data-th="">
                                                <button class="btn btn-danger btn-sm remove-from-cart"><i
                                                        class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                        @php
                                            $emailch = DB::table('email_channels')
                                                ->where('gaming_account_id', $id)
                                                ->where('status', 'available')
                                                ->count();
                                        @endphp
                                        <script>
                                            $(document).ready(function() {

                                                $(".update-cart").change(function(e) {
                                                    e.preventDefault();

                                                    var ele = $(this);

                                                    var updatedQuantity = ele.val();
                                                    var availableStock = {{ $emailch }}; // Use Blade syntax to print PHP variable

                                                    if (parseInt(updatedQuantity) > availableStock) {
                                                        alert("The quantity exceeds the available stock.");
                                                        ele.val(ele.data("original-quantity"));
                                                        return;
                                                    }


                                                    $.ajax({
                                                        url: '{{ route('update.cart') }}',
                                                        method: "patch",
                                                        data: {
                                                            _token: '{{ csrf_token() }}',
                                                            id: ele.parents("tr").attr("data-id"),
                                                            quantity: ele.parents("tr").find(".quantity").val()
                                                        },
                                                        success: function(response) {
                                                            window.location.reload();
                                                        }
                                                    });
                                                });

                                                $(".remove-from-cart").click(function(e) {
                                                    e.preventDefault();

                                                    var ele = $(this);

                                                    if (confirm("Are you sure want to remove?")) {
                                                        $.ajax({
                                                            url: '{{ route('remove.from.cart') }}',
                                                            method: "DELETE",
                                                            data: {
                                                                _token: '{{ csrf_token() }}',
                                                                id: ele.parents("tr").attr("data-id")
                                                            },
                                                            success: function(response) {
                                                                window.location.reload();
                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        </script>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <h3><strong class="y3">Total ${{ $total }}</strong></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <a href="{{ url('/') }}" class="btn btn-warning y1"><i
                                                class="fa fa-angle-left"></i> Continue Shopping</a>
                                        <a href="{{ route('games.cart_checkout') }}"
                                            class="btn btn-success y2">Checkout</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endsection
