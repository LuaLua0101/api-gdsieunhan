<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$order->code}}</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('public/Images/Index/logo.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ URL::asset('public/css/bootstrap.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
</head>
<style>
    @page {
        size: A5 landscape;
        margin: 0;
        margin-top: 0px;
        padding: 0px;
    }

    body {
        background-color: #FAFAFA;
        font-size: 8px;
    }

    .logo-image {
        width: 10em
    }

    .tltContact {
        font-size: 1.5em;
    }

    .tltExpress {
        font-weight: bold;
        font-size: 4em !important;
        text-align: left
    }

    i {
        padding-right: 1em
    }

    .tltHeading {
        font-weight: bold;
    }

    .table>thead>tr>th {
        border-bottom: 0px !important;
    }

    .info>thead>tr>th {
        border-bottom: 2px solid red !important;
    }

    .info th {
        font-weight: bold;
        font-size: 10px;
        text-transform: uppercase;
        color: white !important;
        background-color: red !important;
        -webkit-print-color-adjust: exact;

    }

    .info {
        border-bottom: 1px solid red;
    }

    .info>thead:first-child>tr:first-child>th {
        border-top: 1px solid red !important;
    }

    .info>thead>tr>th {
        border-bottom: 1px solid red;
    }

    .info>thead>tr>th,
    .info>tbody>tr>td {
        border-left: 1px solid red;
        border-right: 1px solid red;
        border-top: 1px dashed #ddd !important;
    }

    @media print {
        @page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
        }
    }
</style>

<body class="A5 landscape">
    <section class="sheet container">
        <!-- Write HTML just like a web page -->
        <article>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:10%">
                            <img class="logo-image" src="{{ URL::asset('public/Images/Index/logo.png') }}" alt="logo" title="logo" />
                        </th>
                        <th style="width:40%">
                            <span class="tltExpress">EXPRESS</span>
                        </th>
                        <th style="width:25%">
                            <p class="tltContact"><i class="fas fa-phone-volume"></i>0902 926 925</p>
                            <p class="tltContact"><i class="fas fa-globe"></i>ihtgo.com.vn</p>
                        </th>
                        <th style="width:25%">
                            <p class="tltContact"><i class="fas fa-barcode"></i>{{$order->code}}</p>
                            <p class="tltContact"><i class="fas fa-calendar-alt"></i><span id="date"></span></p>
                        </th>

                    </tr>
                </thead>
            </table>
            <table class="table info">
                <thead>
                    <tr>
                        <th style="width:50%">{{ __('messages.sender_information') }}</th>
                        <th style="width:50%">{{ __('messages.receiver_information') }} </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.customer_name') }}:</span> {{$order->sender_name}}</td>
                        <td><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.customer_name') }}:</span> {{$order->receive_name}}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-phone-volume"></i><span class="tltHeading">{{ __('messages.phone') }}:</span> {{$order->sender_phone}}</td>
                        <td><i class="fas fa-phone-volume"></i><span class="tltHeading">{{ __('messages.phone') }}:</span> {{$order->receive_phone}}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-map-marked"></i><span class="tltHeading">{{ __('messages.address') }}:</span>{{$order->sender_address}},{{$order->sender_district_name}}, {{$order->sender_province_name }}</td>
                        <td><i class="fas fa-map-marked"></i><span class="tltHeading">{{ __('messages.address') }}:</span>{{$order->receive_address}}, {{$order->receive_district_name}}, {{$order->receive_province_name }} </td>
                    </tr>
                </tbody>
            </table>
            <table class="table info">
                <thead>
                    <tr>
                        <th style="width:50%">{{ __('messages.order_information') }}</th>
                        <th style="width:50%">{{ __('messages.shipping_details') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fas fa-rocket"></i><span class="tltHeading">{{ __('messages.express_delivery') }}:</span>
                            @if($order->is_speed==1)
                            {{ __('messages.yes') }}
                            @else {{ __('messages.no') }}@endif
                        </td>
                        <td><i class="fas fa-info"></i><span class="tltHeading">{{ __('messages.status') }}:</span>
                            <!-- Trạng thái đơn hàng -->
                            @if($order->status==1)
                            {{ __('messages.waiting') }}
                            @elseif($order->status==2)
                            {{ __('messages.no_delivery') }}
                            @elseif($order->status==3)
                            {{ __('messages.being_delivery') }}
                            @elseif($order->status==4)
                            {{ __('messages.succeeded') }}
                            @elseif($order->status==5)
                            {{ __('messages.customer_cancel') }}
                            @elseif($order->status==6)
                            {{ __('messages.iht_cancel') }}
                            @elseif($order->status==7)
                            {{ __('messages.unsuccessful') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-file-import"></i><span class="tltHeading">{{ __('messages.case') }}:</span>
                            @if($order->car_option=='1')
                            {{ __('messages.delivery_in_province') }}
                            @elseif($order->car_option=='2')
                            {{ __('messages.delivery_of_documents') }}
                            @elseif($order->car_option=='3')
                            {{ __('messages.delivery_outside_province') }}
                            @endif</td>
                        <td><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.driver') }}:</span>{{$order->receive_shipper_name}} </td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-money-check-alt"></i><span class="tltHeading">{{ __('messages.pay') }}:</span>
                            @if($order->is_payment==0)
                            {{ __('messages.unpaid') }}
                            @elseif($order->is_payment==1)
                            {{ __('messages.paid') }}
                            @elseif($order->is_payment==2)
                            {{ __('messages.debit') }}
                            @endif</td>
                        <td><i class="fas fa-motorcycle"></i><span class="tltHeading">{{ __('messages.license_plates') }}:</span> {{$order->receive__shipper_car}}</td>
                    </tr>
                    <tr>
                        <td><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.payer') }}:</span>
                            @if($order->payer==1)
                            <span class="bage-info">{{ __('messages.receicer') }}</span>
                            @elseif($order->payer==2)
                            <span class="bage-success">{{ __('messages.sender') }}</span>
                            @endif</td>
                        <td style="border-bottom: 1px solid red;">
                            <i class="fas fa-phone-volume"></i><span class="tltHeading">{{ __('messages.phone') }}:</span> {{$order->receive__shipper_phone}}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-ruler-combined"></i><span class="tltHeading">{{ __('messages.size') }}(cm):</span> </td>
                        
                    </tr>
                    <tr>
                        <td><i class="fas fa-balance-scale"></i><span class="tltHeading">{{ __('messages.weight') }}(kg):</span>{{$order->weight}}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-hand-holding-usd"></i><span class="tltHeading">{{ __('messages.cash_on_delivery') }}:</span> {{number_format($order->take_money).' VNĐ'}}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-hand-holding-usd"></i><span class="tltHeading">{{ __('messages.delivery_charges') }}:</span> {{number_format($order->total_price).' VNĐ'}}</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-hand-holding-usd"></i><span class="tltHeading">{{ __('messages.total_money') }}:</span> {{number_format($order->total_price + $order->take_money).' VNĐ'}}</td>
                    </tr>
                    <tr>
                        <td><i class="far fa-comment-alt"></i><span class="tltHeading">{{ __('messages.note') }}:</span>{{$order->note}}</td>
                    </tr>
                </tbody>
            </table>
        </article>
    </section>
</body>

</html>
<script>
    $(document).ready(function() {
        window.print();
    });
    var d = new Date();
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = day + "/" + month + "/" + year;
    document.getElementById("date").innerHTML = date;
</script>