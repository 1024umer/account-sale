@extends('frontendNew.layout.main')


@section('body')
<style>
    .banner {
        height: 200px !important;
    }
</style>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<section class="service  pb-90" data-bg-img="assets/img/media/service-bg.png">
    <div class="container">

        <div class="row">

           
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      History
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-5">
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






        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    // jQuery script to open the Bootstrap modal on button click
    $(document).ready(function() {
        $("#openModalBtn").click(function() {
            $("#staticBackdrop").modal('show');
        });
    });
</script>


@endsection