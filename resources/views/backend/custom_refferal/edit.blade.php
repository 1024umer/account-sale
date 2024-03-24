@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Edit Custom Refferal')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#basic-default-fullname1').on('input', function () {
                var referralName = $(this).val();
                var referralLink = 'https://mywebsitedomain.com/?ref=' + referralName;
                $('#refferal-link').val(referralLink);
            });
        });
    </script>
@endsection


@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Custom Refferal </span></h4>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Custom Refferal</h5>
            </div>
            <div class="card-body">
                <form id="identifier" action="{{ route('admin.customrefferal.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <input type="hidden" name="id" value="{{ $custom_refferal->id }}">
                        <label class="form-label" for="basic-default-fullname">Title</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $custom_refferal->title }}" required name="title" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Refferal Name</label>
                        <input type="text" class="form-control" id="basic-default-fullname1"
                            value="{{ $custom_refferal->refferal_name }}" required name="refferal_name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Refferal Link</label>
                        <input type="text" class="form-control"  id="refferal-link"
                            value="{{ $custom_refferal->refferal_link }}" name="refferal_link" />
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection
