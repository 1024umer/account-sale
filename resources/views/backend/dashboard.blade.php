@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Home')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/charts-apex.js') }}"></script> --}}
    <script>
        let cardColor, labelColor, headingColor, borderColor, legendColor;

        if (isDarkStyle) {
            cardColor = config.colors_dark.cardColor;
            labelColor = config.colors_dark.textMuted;
            legendColor = config.colors_dark.bodyColor;
            headingColor = config.colors_dark.headingColor;
            borderColor = config.colors_dark.borderColor;
        } else {
            cardColor = config.colors.cardColor;
            labelColor = config.colors.textMuted;
            legendColor = config.colors.bodyColor;
            headingColor = config.colors.headingColor;
            borderColor = config.colors.borderColor;
        }
        // Donut Chart Colors
        const chartColors = {
            donut: {
                series1: '#28c76f',
                series2: '#ff9f43',
                series3: '#ea5455',
            }
        };
        const generatedLeadsChartEl = document.querySelector('#generatedLeadsChart1');
        if (generatedLeadsChartEl) {
            const activeUsersCount = {{ $activeUsersCount }};
            const inactiveUsersCount = {{ $inactiveUsersCount }};
            const deletedUsersCount = {{ '0' }};

            const generatedLeadsChartConfig = {
                chart: {
                    height: 147,
                    width: 130,
                    parentHeightOffset: 0,
                    type: 'donut',
                },
                labels: ['Active Users', 'Inactive Users', 'Deleted Users'],
                series: [activeUsersCount, inactiveUsersCount, deletedUsersCount],
                colors: [chartColors.donut.series1, chartColors.donut.series2, chartColors.donut.series3],
                stroke: {
                    width: 0
                },
                dataLabels: {
                    enabled: false,
                    formatter: function(val, opt) {
                        return parseInt(val) + '%';
                    }
                },
                legend: {
                    show: false
                },
                tooltip: {
                    theme: false
                },
                grid: {
                    padding: {
                        top: 15,
                        right: -20,
                        left: -20
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                value: {
                                    fontSize: '1.375rem',
                                    fontFamily: 'Public Sans',
                                    color: headingColor,
                                    fontWeight: 600,
                                    offsetY: -15,
                                    formatter: function(val) {
                                        return parseInt(val) + '%';
                                    }
                                },
                                name: {
                                    offsetY: 20,
                                    fontFamily: 'Public Sans'
                                },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    color: config.colors.success,
                                    fontSize: '.8125rem',
                                    label: 'Total',
                                    fontFamily: 'Public Sans',
                                    formatter: function(w) {
                                        return '{{ $totalUsers }}';
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                        breakpoint: 1025,
                        options: {
                            chart: {
                                height: 172,
                                width: 160
                            }
                        }
                    },
                    {
                        breakpoint: 769,
                        options: {
                            chart: {
                                height: 178
                            }
                        }
                    },
                    {
                        breakpoint: 426,
                        options: {
                            chart: {
                                height: 147
                            }
                        }
                    }
                ]
            };
            const generatedLeadsChart = new ApexCharts(generatedLeadsChartEl, generatedLeadsChartConfig);
            generatedLeadsChart.render();
        }
    </script>
@endsection

@section('content')

    <div class="row">
        <!-- Statistics -->
        <div class="col-xl-8 mb-4 col-lg-7 col-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title mb-0">Statistics</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">${{ $revenueToday }}</h5>
                                    <small>Sales Today</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">${{ $revenueThisMonth }}</h5>
                                    <small>Sales Last Month</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">${{ $revenueLastMonth }} </h5>
                                    <small>Sales This Month</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">${{ $revenueTotal }}</h5>
                                    <small>Total Revenue</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $totalUsers }}</h5>
                                    <small>Total Users</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $usersToday }}</h5>
                                    <small>Users Today</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i
                                        class="ti ti-report-money ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $ordersTotal }}</h5>
                                    <small>Total Orders</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i
                                        class="ti ti-report-money ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $ordersToday }}</h5>
                                    <small>Orders Today</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-danger me-3 p-2"><i
                                        class="ti ti-shopping-cart ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $productsTotal }}</h5>
                                    <small>Products</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-warning me-3 p-2"><i class="ti ti-ticket ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $ticketsToday }}</h5>
                                    <small>Tickets Today</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics -->
        <div class="col-xl-4 mb-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <div class="card-title mb-auto">
                                <h5 class="mb-1 text-nowrap">Users</h5>
                                <small>Monthly Report</small>
                            </div>
                            <div class="chart-statistics">
                                <h3 class="card-title mb-1">{{ $lastMonthUsers }}</h3>
                                <small class="text-success text-nowrap fw-semibold"><i class='ti ti-chevron-up me-1'></i>
                                    {{ $percentageLastMonthUsers }}%</small>
                            </div>
                        </div>
                        <div id="generatedLeadsChart1" style="color: white"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 my-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Users</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalUsers }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <a href="{{ route('admin.users.') }}" class="btn mt-2 btn-sm btn-outline-primary">View</a>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-user ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Orders</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalOrders }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <a href="{{ route('admin.orders.') }}" class="btn mt-2 btn-sm btn-outline-primary">View</a>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti  ti-zoom-money ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Accounts</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalGamingAccounts }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <a href="{{ route('admin.gamingaccounts.') }}"
                                class="btn mt-2 btn-sm btn-outline-primary">View</a>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-device-gamepad ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Total Tickets</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalTickets }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <a href="{{ route('admin.tickets.') }}" class="btn mt-2 btn-sm btn-outline-primary">View</a>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-ticket ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Tickets Pending</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $ticketsPending }}</h3>
                                <small class="text-warning">(100%)</small>
                            </div>
                            <a href="{{ route('admin.tickets.') }}" class="btn mt-2 btn-sm btn-outline-primary">View</a>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-ticket ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
