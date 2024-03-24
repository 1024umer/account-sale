@extends('frontendNew.layout.main')


@section('body')
<style>
    .banner {
        height: 200px !important;
    }
</style>




<section class="service  pb-90" data-bg-img="assets/img/media/service-bg.png">
    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Affiliates System

                    </div>
                    <div class="card-body">
                        <p>- Share your reffral link and get 5% comminssion from the user payments you invite, you can
                            spend
                            your earnings on the panel.</p>
                        <p>- All you have to do is to add members to our site via your Invite link. Remember, you will
                            only
                            earn bonuses from memberships that register through
                            the link defined in your account. Theere is no invitation limit, you reach as many users as
                            you
                            want and share your reference link.
                        </p>

                        <ul class="ps-3">
                            <li>Only newly recruited users are paid.</li>
                            <li>No payment is made for those who are self-referential and their accounts on the site are
                                closed when they are noticed, as soon as the service is provided!</li>
                            <li>You cannaot submit a request without earning $10 on referrals.</li>
                            <li>You get 5% bonus from every payment your reffrals make.</li>
                            <li>When the minimum payment amount is reached, the "Send Payment Request" button will
                                appear on
                                the screen.</li>
                        </ul>


                    </div>
                </div>




            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Referral Link
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="border-top-left-radius: 15px !important;">Reffral Link
                                        </th>
                                        <th scope="col" style="border-top-right-radius: 15px !important;">Commission rate</th>
                                        {{-- <th scope="col" style="border-top-right-radius: 15px !important;">Minimum Payout
                                        </th> --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td style="border-bottom-left-radius: 15px !important;">
                                            <a href="{{url('signup/' . $user->username)}}" target="_blank" style=" text-decoration:none"> {{url('signup/' . $user->username) }} </a> <i class="fa-solid fa-clone"></i>
                                        </td>
                                        <td style="border-bottom-right-radius: 15px !important;">
                                            {{ $data['referral_percentage'] }}% (amount you will get from order)
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Earning with Referrals
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="border-top-left-radius: 15px !important;" scope="col">Reffrals</th>
                                        <th scope="col">Referral Names</th>
                                        <th scope="col" style="border-top-right-radius: 15px !important;">Available
                                            earnings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border-bottom-left-radius: 15px !important;">{{ $refferal }}</td>
                                        <td>
                                            @foreach ($refferals as $refferal)
                                            {{ $refferal->username }},
                                            @endforeach
                                        </td>
                                        <td style="border-bottom-right-radius: 15px !important;">{{ Auth::user()->referral_balance }}$</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Withdraw
                    </div>
                    <div class="card-body">


                        <form action="{{ route('profile.withdraw') }}" id="withdrawform" method="post">
                            @csrf

                            <div class="text-center">
                                <label for="referral_balance" class="mb-1 font-weight-bold text-white">Referral Balance ($)</label>
                                <div class="input input-icon">
                                    <input type="text" name="referral_balance" value="{{ $user->referral_balance }}" readonly class="form-control" />
                                </div>

                                <label for="secret_key" class="mb-1 font-weight-bold text-white">Crypto Address</label>
                                <div class="input input-icon">
                                    <input type="text" class="form-control" name="secret_key" placeholder="Enter Crypto Address" required />
                                </div>

                                <button class="btn btn-large btn-primary">Withdraw</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      History
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead >
                                    <tr >
                                        <th scope="col" >Payout Date
                                        </th>
                                        <th scope="col">Payout amount</th>
                                        <th scope="col">Payout method</th>
                                        <th scope="col" >Payout status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdraw as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $item->amount}}</td>
                                        <td>{{ $item->payment_method}}</td>
                                        <td>{{ $item->status}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
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