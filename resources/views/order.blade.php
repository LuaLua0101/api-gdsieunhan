@extends('layouts.customer')
@section('content')
<div class="body-wrap">
    <div class="topHeight"></div>
    <div class="container margin-auto news-body">
        <div class="row center-text">
            <h2 style="margin: -1.5%;"><span style="font-size: 24px; text-transform:uppercase; color:#e50303;"><strong>@lang('messages.title_order') </strong></span></h2>
        </div>
        <div class="h50px"></div>
        <div class=" form-search-order ">
            <div class="form-group"> <label class="">@lang('messages.total_money') :<span id='total-price'> {{ number_format($sum_order)}} VNĐ</span> </label></div>
        </div>
    </div>
    <div class="h50px"></div>
    <div class="container">
        <ul class="pagination">
            <li class="active"><a href="{!! url('order'); !!}">@lang('messages.all')({{$count_order_all}})</a></li>
            <li><a href="{!! url('order/status=1'); !!}">@lang('messages.waiting')({{$count_order_watting}})</a></li>
            <li><a href="{!! url('order/status=2'); !!}">@lang('messages.no_delivery')({{$count_order_no_delivery}})</a></li>
            <li><a href="{!! url('order/status=3'); !!}">@lang('messages.being_delivery')({{$count_order_beging_delivery}})</a></li>
            <li><a href="{!! url('order/status=4'); !!}">@lang('messages.succeeded')({{$count_order_done_delivery}})</a></li>
            <li><a href="{!! url('order/status=5'); !!}">@lang('messages.customer_cancel')({{$count_order_customer_cancel}})</a></li>
            <li><a href="{!! url('order/status=6'); !!}">@lang('messages.iht_cancel')({{$count_order_iht_cancel}})</a></li>
            <li><a href="{!! url('order/status=7'); !!}">@lang('messages.unsuccessful')({{$count_order_fail}})</a></li>
        </ul>
        <div id="load-data">
            @foreach($order as $o)
            <div class="row">
                <div class="col-md-2">
                    <img data-toggle="modal" data-target="#myModal" src={{"./storage/app/public/order/" . $o->id.'_order.png?'.rand()}} alt="No Image" style="width:100%;max-width:300px;height:8em" onerror="this.onerror=null;this.src='public/images/index/notfound.png';">
                </div>
                <div class="col-md-3">
                    <p><a href="order-detail/{{$o->id}}">@if($o->is_speed == 1)<i class="fas fa-rocket"></i>@endif {{ $o->code }}</a></p>
                    <p class="text-justify">@lang('messages.order_name'): {{ $o->name }}</p>
                    <p class="text-justify">@lang('messages.date_created'): {{date("d-m-Y", strtotime($o->created_at))}}</p>
                </div>
                <div class="col-md-3 ">
                    <p>@lang('messages.payer'): @if($o->payer==1)
                        <span class="bage-info">@lang('messages.receicer') </span>
                        @elseif($o->payer==2)
                        <span class="bage-success">@lang('messages.sender') </span>
                        @endif</p>
                    <p>@lang('messages.pay'):
                        @if ($o->is_payment == 0)
                        <span class="bage-basic">@lang('messages.unpaid')</span>
                        @elseif ($o->is_payment == 1)
                        <span class="bage-success"> @lang('messages.paid')</span>
                        @elseif ($o->is_payment == 2)
                        <span class="bage-danger">@lang('messages.debit')</span>
                        @endif
                    </p>
                    <p>@lang('messages.total_money'): {{number_format($o->total_price).' VNĐ'}}</p>

                </div>
                <div class="col-md-3">
                    <p>@lang('messages.case') :
                        @if($o->car_option==1)
                        <span class="bage-warning">@lang('messages.delivery_in_province') </span>
                        @elseif($o->car_option==2)
                        <span class="bage-success">@lang('messages.delivery_of_documents') </span>
                        @elseif($o->car_option==3)
                        <span class="bage-info">@lang('messages.delivery_outside_province') </span>
                        @endif
                    </p>
                    <p class="text-justify">@lang('messages.status'):
                        @if($o->status == 1)
                        <span class="bage-warning">@lang('messages.waiting') </span>
                        @elseif ($o->status == 2)
                        <span class="bage-info">@lang('messages.no_delivery')</span>
                        @elseif ($o->status == 3)
                        <span class="bage-info">@lang('messages.being_delivery') </span>
                        @elseif ($o->status == 4)
                        <span class="bage-success">@lang('messages.succeeded') </span>
                        @elseif ($o->status == 5)
                        <span class="bage-basic">@lang('messages.customer_cancel') </span>
                        @elseif ($o->status == 6)
                        <span class="bage-basic">@lang('messages.iht_cancel') </span>
                        @elseif ($o->status == 7)
                        <span class="bage-danger">@lang('messages.unsuccessful') </span>
                        @endif
                    </p>
                </div>
            </div>
            <hr>
            @endforeach
            <div id="remove-row" style="text-align: center;">
                <button id="btn-more" data-id="{{$o->id}}" class="btn btn-default"> <i class="fas fa-chevron-down"></i> </button>
            </div>
        </div>
    </div>
    <div class="h50px"></div>
</div>
@endsection