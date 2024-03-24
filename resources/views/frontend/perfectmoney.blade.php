@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . '')
    @section('meta_keyowrds', $data->meta_keyowrds)
    @section('meta_description', $data->meta_description)
@endif

@section('page-styles')

@endsection

@section('content')
<form action="https://perfectmoney.is/api/step1.asp" method="POST" id="perfectmoney_form">
    @csrf
    <input type="hidden" name="PAYEE_ACCOUNT" value="{{ $PAYEE_ACCOUNT }}">
    <input type="hidden" name="PAYEE_NAME" value="{{ $PAYEE_NAME }}">
    <input type="hidden" name="PAYMENT_AMOUNT" value="{{ $PAYMENT_AMOUNT }}">
    <input type="hidden" name="PAYMENT_UNITS" value="{{ $PAYMENT_UNITS }}">
    <input type="hidden" name="PAYMENT_URL" value="{{ $PAYMENT_URL }}">
    <input type="hidden" name="NOPAYMENT_URL" value="{{ $NOPAYMENT_URL }}">
    
    <input type="submit" value="Proceed">
</form>

<script defer>
    document.addEventListener("DOMContentLoaded", function(event) {
        var idOfYourForm = "perfectmoney_form";
        document.getElementById(idOfYourForm).submit();
    });
</script>
@endsection
