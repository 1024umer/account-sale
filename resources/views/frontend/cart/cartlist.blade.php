@extends('frontend.layout')

@section('page-styles')
    <style>
        .text_card {
            background-color: #67696d !important;
            color: #fff !important;
        }

        .make_money td,
        .make_money th {
            padding-bottom: 20px !important;
            padding-top: 20px !important;
            padding-left: 15px !important;
            border-bottom: 0px !important;
        }

        .make_money td {
            background-color: #515253 !important;
            color: #fff !important;
        }

        .make_money th {
            background-color: #626468 !important;
            color: #fff !important;
        }

        .quantity {
            display: flex;
            margin-bottom: 10px;
        }

        .quantity-sub {
            margin-left: 10px;
            padding: 5px 5px;
            background-color: #fff;
        }

        .minus {
            border-radius: 50%;
            background-color: #000;
            cursor: pointer;
            padding-right: 7px;
            width: 26px;
            height: 26px;
            padding-left: 9px;

        }

        .plus {
            border-radius: 50%;
            background-color: #000;
            padding-left: 7px;
            padding-top: 0px;
            width: 25px;
            height: 25px;
            cursor: pointer;
        }

        .num {
            margin: 0px 7px;
            color: #000;
        }
    </style>
@endsection



@section('content')
    <section class="make_money pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-4">
                    <div class="table-responsive mt-5">
                        <table class="table container">
                            <thead>
                                <tr>
                                    <th scope="col" style="border-top-left-radius: 15px !important;">Item</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col" style="border-top-right-radius: 15px !important;">Remove</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($cartItems as $collection)
                                    @foreach ($collection->services as $product)
                                        <tr>
                                            <td style="border-bottom-left-radius: 15px !important;">
                                                <img src="{{ $product->main_image }}" alt="Details" style="width: 50px">
                                            </td>
                                            <td>{{ $product->title }}</td>
                                            <td id="totalPrice{{ $product->id }}">
                                                {{ $product->price - ($product->price * $product->discount) / 100 }}$
                                            </td>
                                            <td>
                                                <div class="quantity">
                                                    <div class="quantity-sub d-flex">
                                                        <div class="minus {{ $product->id }}"
                                                            onclick="decrease{{ $product->id }}()">-</div>
                                                        <span class="num{{ $product->id }}"
                                                            style="margin: 0px 7px;color: #000;"> 1 </span>
                                                        <div class="plus {{ $product->id }}"
                                                            onclick="increase{{ $product->id }}()">+</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="border-bottom-right-radius: 15px !important;">
                                                <a href="#" class="removeFromCart"
                                                    data-id="{{ $collection->session_id }}" style="color: #FFF;">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $totalPrice += $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <script>
                                            let price{{ $product->id }} = {{ $product->price - ($product->price * $product->discount) / 100 }};
                                            let quantity{{ $product->id }} = 1;

                                            function increase{{ $product->id }}() {



                                                quantity{{ $product->id }}++;
                                                document.querySelector('.num{{ $product->id }}').innerText = quantity{{ $product->id }};
                                                let currentTotalPrice{{ $product->id }} = price{{ $product->id }} * quantity{{ $product->id }};
                                                document.getElementById('totalPrice{{ $product->id }}').innerText = currentTotalPrice{{ $product->id }} +
                                                    "$";
                                                updateTotalPrice();
                                                console.log();

                                                let numValue = document.querySelector('.num{{ $product->id }}').innerText;
                                                let totalPriceElement = document.getElementById('totalPrice{{ $product->id }}');
                                                let totalPriceValue = totalPriceElement.innerText.trim(); // Retrieve the total price value
                                                console.log(totalPriceValue);

                                                $.ajax({

                                                    type: 'POST',
                                                    url: "{{ route('updateQuantity') }}",
                                                    data: {
                                                        productId: {{ $product->id }},
                                                        newQuantity: numValue,
                                                        _token: "{{ csrf_token() }}" // Include the CSRF token
                                                    },
                                                    success: function(response) {
                                                        console.log(response.message); // Log the success message
                                                        // Perform any additional actions on success
                                                    },
                                                    error: function(error) {
                                                        console.error(error.responseJSON.message); // Log the error message
                                                        // Handle the error appropriately
                                                    }
                                                });
                                            }

                                            function decrease{{ $product->id }}() {

                                                if (quantity{{ $product->id }} > 1) {

                                                    quantity{{ $product->id }}--;
                                                    document.querySelector('.num{{ $product->id }}').innerText = quantity{{ $product->id }};
                                                    let currentTotalPrice{{ $product->id }} = price{{ $product->id }} * quantity{{ $product->id }};
                                                    document.getElementById('totalPrice{{ $product->id }}').innerText =
                                                        currentTotalPrice{{ $product->id }} + "$";
                                                    updateTotalPrice();
                                                    let numValue = document.querySelector('.num{{ $product->id }}').innerText;
                                                    let totalPriceElement = document.getElementById('totalPrice{{ $product->id }}');
                                                    let totalPriceValue = totalPriceElement.innerText.trim(); // Retrieve the total price value
                                                    console.log(totalPriceValue);
                                                    $.ajax({


                                                        type: 'POST',
                                                        url: "{{ route('updateQuantity') }}",
                                                        data: {
                                                            productId: {{ $product->id }},
                                                            newQuantity: numValue,
                                                            _token: "{{ csrf_token() }}" // Include the CSRF token
                                                        },
                                                        success: function(response) {
                                                            console.log(response.message); // Log the success message
                                                            // Perform any additional actions on success
                                                        },
                                                        error: function(error) {
                                                            console.error(error.responseJSON.message); // Log the error message
                                                            // Handle the error appropriately
                                                        }
                                                    });
                                                }
                                            }

                                            function updateTotalPrice() {
                                                let totalPrice = 0;
                                                @foreach ($cartItems as $coll)
                                                    @foreach ($coll->services as $prod)
                                                        let currentPrice{{ $prod->id }} = price{{ $prod->id }} * quantity{{ $prod->id }};
                                                        totalPrice += currentPrice{{ $prod->id }};
                                                    @endforeach
                                                @endforeach
                                                document.getElementById('totalPriceInput').value = totalPrice;
                                            }
                                        </script>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-end my-5">
                <div class="col-lg-4">
                    <div class="card p-3" style="background: #515253">
                        <p style="color: white">Coupon id:</p>
                        <form action="{{ route('games.details') }}" method="GET">
                            <input type="text" name="coupon" placeholder="coupon id" class="my-3 p-2" value=""
                                style="border-radius: 3px; border:none">
                            <input type="text" id="totalPriceInput" name="totalPrice" value="{{ $totalPrice }}">
                            <button type="submit"
                                style="box-shadow: 8px 12px 20px 4px lightblue;border: 0px;font-weight: 600;font-size: 13px;line-height: 26px;"
                                class="text-center d-inline-block btn btn-info p-2 my-1 mb-2">Buy Now</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function() {
            $('.removeFromCart').click(function(e) {
                e.preventDefault();
                var sessionId = $(this).data('id');

                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/remove-from-cart') }}',
                    data: {
                        sessionId: sessionId,
                        _token: token, // pass the CSRF token
                    },
                    success: function(response) {
                        console.log(response);
                        // Handle success, such as updating the UI
                        // Check if the response status is 'success'
                        if (response.status === 'success') {
                            // Display a success message with SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'SUCCESS',
                                text: response
                                    .message, // Use the message from the response
                            }).then(() => {
                                // Reload the page after the success message is closed
                                window.location.reload();
                            });
                        }
                    },
                    error: function(error) {
                        // Handle error, such as displaying an error message
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
