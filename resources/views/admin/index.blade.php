@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="tf-section-2 mb-30">
            <div class="flex gap20 flex-wrap-mobile">
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Total Orders
                                    </div>
                                    <h4>{{$dashboardDatas[0]->Total}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-nepalese-rupee"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Total Amount
                                    </div>
                                    <h4>{{$dashboardDatas[0]->TotalAmount}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Pending
                                        Orders
                                    </div>
                                    <h4>{{$dashboardDatas[0]->TotalOrdered}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-nepalese-rupee"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Pending
                                        Orders
                                        Amount
                                    </div>
                                    <h4>{{$dashboardDatas[0]->TotalOrderedAmount}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Delivered
                                        Orders
                                    </div>
                                    <h4>{{$dashboardDatas[0]->TotalDelivered}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-nepalese-rupee"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Delivered
                                        Orders
                                        Amount
                                    </div>
                                    <h4>{{$dashboardDatas[0]->TotalDeliveredAmount}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Canceled
                                        Orders
                                    </div>
                                    <h4>{{$dashboardDatas[0]->TotalCanceled}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-nepalese-rupee"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">
                                        Canceled
                                        Orders
                                        Amount
                                    </div>
                                    <h4>{{$dashboardDatas[0]->TotalCanceledAmount}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Monthly revenue</h5>
                </div>
                <div class="flex flex-wrap gap40">
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t1"></div>
                                <div class="text-tiny">
                                    Total
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>Rs.{{$TotalAmount}}</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">
                                    Pending
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>Rs.{{$TotalOrderedAmount}}</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t3"></div>
                                <div class="text-tiny">
                                    Delivered
                                </div>
                            </div>
                        </div>
                        <divclass="flex items-center gap10">
                            <h4>Rs.{{$TotalDeliveredAmount}}</h4>
                            </divclass=>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t4"></div>
                                <div class="text-tiny">
                                    Canceled
                                </div>
                            </div>
                        </div>
                        <divclass="flex items-center gap10">
                            <h4>Rs.{{$TotalCanceledAmount}}</h4>
                            </divclass=>
                    </div>
                </div>
                <div id="line-chart-8"></div>
            </div>
        </div>
        <!-- customer0Product Section -->
        <div class="row">
            <!-- Top Customer Section -->
            <div class="col-lg-6 col-md-6 col-sm-12 mb-30 d-flex">
                <div class="wg-box justify-content-center" >
                    <h5>Top Customer</h5>
                      <div class="row top-customer g-4">
                        @foreach ($topCustomers as $topCustomer)
                        <div class="col-lg-4">
                            <div class="customer-card">
                                @php
                                    $user_name = App\Models\User::find($topCustomer->user_id);
                                @endphp
                                @php
                                    $image = \Laravolt\Avatar\Facade::create($user_name->name)->toBase64();
                                @endphp
                                <img src="{{ $image }}" alt="Customer">
                                <div class="customer-info">
                                    
                                    <p>{{$user_name->name}}</p>
                                    <small>Purchase: {{$topCustomer->total_purchase}}x</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Popular Products Section -->
            <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                <div class="wg-box">
                    <h5>Popular Products This Month</h5>
                    <div class="row g-4">
                        @foreach ($popularProducts as $popularProduct)
                        @php
                            $product = App\Models\Product::find($popularProduct->product_id);
                        @endphp
                        <div class="d-flex col-lg-3 col-md-4 col-sm-6">
                            <div class="product-card">
                                <img src="{{asset('uploads/products/thumbnails')}}/{{$product->image}}" alt="{{$product->name}}">
                                <div class="product-info">
                                    <p class="large-text">{{$product->name}}</p>
                                    <p class="small-text">Sold: {{$popularProduct->total_quantity}}x</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>
            </div>
        </div>
        <div class="tf-section mb-30">
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Recent orders</h5>
                    <div class="dropdown default">
                        <a class="btn btn-secondary dropdown-toggle" href="{{route('admin.orders')}}">
                            <span class="view-all">View all</span>
                        </a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:80px;">
                                        #
                                    </th>
                                    <th style="width:80px;" class="text-center">
                                        Order Id
                                    </th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">
                                        Phone
                                    </th>
                                    <th class="text-center">
                                        Subtotal
                                    </th>
                                    <th class="text-center">
                                        Discount
                                    </th>
                                    <th class="text-center">
                                        Total
                                    </th>
                                    <th class="text-center">
                                        Status
                                    </th>
                                    <th class="text-center">
                                        Order Date
                                    </th>
                                    <th class="text-center">
                                        Total Items
                                    </th>
                                    <th class="text-center">
                                        Delivered On
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{$count}}</td>
                                    <td class="text-center">
                                        {{$order->id}}
                                    </td>
                                    <td class="text-center">
                                        {{$order->name}}
                                    </td>
                                    <td class="text-center">
                                        {{$order->phone}}
                                    </td>
                                    <td class="text-center">
                                        Rs.{{$order->subtotal}}
                                    </td>
                                    <td class="text-center">
                                        Rs.{{$order->discount}}
                                    </td>
                                    <td class="text-center">
                                        Rs.{{$order->total}}
                                    </td>
                                    <td class="text-center">
                                        @if ($order->status == 'ordered')
                                        <span class="badge bg-warning">Ordered</span>
                                        @elseif($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                        @else
                                        <span class="badge bg-danger">Canceled</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{$order->created_at}}
                                    </td>
                                    <td class="text-center">
                                        {{$order->orderItems->count()}}
                                    </td>
                                    <td class="text-center">
                                        {{$order->delivered_date}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('admin.order.details',['order_id'=>$order->id])}}">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    (function ($) {
        var tfLineChart = (function () {
            var chartBar = function () {
                var options = {
                    series: [
                        {
                            name: "Total",
                            data: [
                                {{$AmountM}}
                            ],
                        },
                        {
                            name: "Pending",
                            data: [
                                {{$OrderedAmountM}}
                            ],
                        },
                        {
                            name: "Delivered",
                            data: [
                                {{$DeliveredAmountM}}
                            ],
                        },
                        {
                            name: "Canceled",
                            data: [
                                {{$CanceledAmountM}}
                            ],
                        },
                    ],
                    chart: {
                        type: "bar",
                        height: 325,
                        toolbar: {
                            show: false,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "10px",
                            endingShape: "rounded",
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: false,
                    },
                    colors: [
                        "#2377FC",
                        "#FFA500",
                        "#078407",
                        "#FF0000",
                    ],
                    stroke: {
                        show: false,
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: "#212529",
                            },
                        },
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                    },
                    yaxis: {
                        show: false,
                    },
                    fill: {
                        opacity: 1,
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "Rs. " + val + "";
                            },
                        },
                    },
                };

                chart = new ApexCharts(
                    document.querySelector("#line-chart-8"),
                    options
                );
                if ($("#line-chart-8").length > 0) {
                    chart.render();
                }
            };

            /* Function ============ */
            return {
                init: function () {},

                load: function () {
                    chartBar();
                },
                resize: function () {},
            };
        })();

        jQuery(document).ready(function () {});

        jQuery(window).on("load", function () {
            tfLineChart.load();
        });

        jQuery(window).on("resize", function () {});
    })(jQuery);
</script>
@endpush