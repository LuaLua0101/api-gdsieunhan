@extends('layouts.customer')
@section('content')
<div class="body-wrap">
    <div class="topHeight"></div>
    <div class="container margin-auto news-body">
        <div class="row center-text">
            <h2 style="margin: -1.5%;"><span style="font-size: 24px; text-transform:uppercase; color:#e50303;"><strong>{{ __('messages.detail_order') }}: #{{$order->code}} @if($order->is_speed==1)
                        <i class="fas fa-rocket"></i>
                        @endif</span></strong></span></h2>
        </div>
        <div class="h50px"></div>
    </div>
    <div class="container" id="formOrderDetail">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="list-group">
                    <span class="list-group-item active">{{ __('messages.sender_information') }}</span>
                    <span class="list-group-item"><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.customer_name') }}:</span> {{$order->sender_name}}</span>
                    <span class="list-group-item"><i class="fas fa-phone"></i><span class="tltHeading">{{ __('messages.phone') }}:</span> {{$order->sender_phone}}</span>
                    <span class="list-group-item"><i class="fas fa-map-marked"></i><span class="tltHeading">{{ __('messages.address') }}:</span>{{$order->sender_address}},{{$order->sender_district_name}}, {{$order->sender_province_name }} </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="list-group">
                    <span class="list-group-item active">{{ __('messages.receiver_information') }}:</span>
                    <span class="list-group-item"><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.customer_name') }}:</span> {{$order->receive_name}}</span>
                    <span class="list-group-item"><i class="fas fa-phone"></i><span class="tltHeading">{{ __('messages.phone') }}:</span> {{$order->receive_phone}}</span>
                    <span class="list-group-item"><i class="fas fa-map-marked"></i><span class="tltHeading">{{ __('messages.address') }}:</span>{{$order->receive_address}}, {{$order->receive_district_name}}, {{$order->receive_province_name }} </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="list-group">
                    <span class="list-group-item active">{{ __('messages.order_information') }}</span>
                    <span class="list-group-item"><i class="fas fa-rocket"></i><span class="tltHeading">{{ __('messages.express_delivery') }}:</span>
                        @if($order->is_speed==1)
                        <span class="bage-success">{{ __('messages.yes') }}</span>
                        @else<span class="bage-basic"> {{ __('messages.no') }}</span>@endif </span>
                    <span class="list-group-item"><i class="fas fa-file-import"></i><span class="tltHeading">{{ __('messages.case') }}:</span>
                        @if($order->car_option=='1')
                        <span class="bage-info">{{ __('messages.delivery_in_province') }}</span>
                        @elseif($order->car_option=='2')
                        <span class="bage-success">{{ __('messages.delivery_of_documents') }} </span>
                        @elseif($order->car_option=='3')
                        <span class="bage-primary">{{ __('messages.delivery_outside_province') }}</span>
                        @endif
                    </span>

                    <span class="list-group-item"><i class="fas fa-money-check-alt"></i><span class="tltHeading">{{ __('messages.pay') }}:</span>
                        @if($order->is_payment==0)
                        <span class="bage-basic"> {{ __('messages.unpaid') }}</span>
                        @elseif($order->is_payment==1)
                        <span class="bage-success"> {{ __('messages.paid') }}</span>
                        @elseif($order->is_payment==2)
                        <span class="bage-danger">{{ __('messages.debit') }}</span>
                        @endif
                    </span>
                    <span class="list-group-item"><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.payer') }}:</span>
                        @if($order->payer==1)
                        <span class="bage-info">{{ __('messages.receicer') }}</span>
                        @elseif($order->payer==2)
                        <span class="bage-success">{{ __('messages.sender') }}</span>
                        @endif
                    </span>
                    <span class="list-group-item"><i class="fas fa-ruler-combined"></i><span class="tltHeading">{{ __('messages.size') }}(cm):</span>{{$order->length}} x {{$order->width}} x {{$order->height}} </span>
                    <span class="list-group-item"><i class="fas fa-balance-scale"></i><span class="tltHeading">{{ __('messages.weight') }}(kg):</span>{{$order->weight}}</span>
                    <span class="list-group-item"><i class="fas fa-hand-holding-usd"></i><span class="tltHeading">{{ __('messages.cash_on_delivery') }}:</span> {{number_format($order->take_money).' VNĐ'}}</span>
                    <span class="list-group-item"><i class="fas fa-hand-holding-usd"></i><span class="tltHeading">{{ __('messages.delivery_charges') }}:</span> {{number_format($order->total_price).' VNĐ'}}</span>
                    <span class="list-group-item"><i class="fas fa-hand-holding-usd"></i><span class="tltHeading">{{ __('messages.total_money') }}:</span> {{number_format($order->total_price + $order->take_money).' VNĐ'}}</span>
                    <span class="list-group-item"><i class="far fa-comment-alt"></i><span class="tltHeading">{{ __('messages.note') }}:</span>{{$order->note}}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="list-group">
                    <span class="list-group-item active">{{ __('messages.shipping_details') }}</span>
                    <span class="list-group-item"><i class="fas fa-info"></i><span class="tltHeading">{{ __('messages.status') }}:</span>
                        <!-- Trạng thái đơn hàng -->
                        @if($order->status==1)
                        <span class="bage-warning">{{ __('messages.waiting') }} </span>
                        @elseif($order->status==2)
                        <span class="bage-info">{{ __('messages.no_delivery') }}</span>
                        @elseif($order->status==3)
                        <span class="bage-info">{{ __('messages.being_delivery') }} </span>
                        @elseif($order->status==4)
                        <span class="bage-success">{{ __('messages.succeeded') }}</span>
                        @elseif($order->status==5)
                        <span class="bage-basic">{{ __('messages.customer_cancel') }} </span>
                        @elseif($order->status==6)
                        <span class="bage-basic">{{ __('messages.iht_cancel') }}</span>
                        @elseif($order->status==7)
                        <span class="bage-danger">{{ __('messages.unsuccessful') }}</span>
                        @endif
                    </span>
                    <span class="list-group-item"><i class="far fa-user"></i><span class="tltHeading">{{ __('messages.driver') }}:</span>{{$order->receive_shipper_name}} </span>
                    <span class="list-group-item"><i class="fas fa-motorcycle"></i><span class="tltHeading">{{ __('messages.license_plates') }}:</span> {{$order->receive__shipper_car}}</span>
                    <span class="list-group-item"><i class="fas fa-phone"></i><span class="tltHeading">{{ __('messages.phone') }}:</span> {{$order->receive__shipper_phone}}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="list-group">
                    <span class="list-group-item active">{{ __('messages.delivery_history') }}</span>
                    <span class="list-group-item"><i class="fas fa-clock"></i><span class="tltHeading">{{ __('messages.date_created') }}:</span>{{$order->created_at}}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="list-group">
                    <span class="list-group-item active">{{ __('messages.photo_order') }}</span>
                    <img data-toggle="modal" data-target="#myModal" id="myImg" src={{"../storage/app/public/order/" . $order->order_id."_order.png?" . rand()}} alt="No Image" style="width:100%;max-width:300px" onerror="this.onerror=null;this.src='../public/images/index/notfound.png';">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <img data-toggle="modal" width="100%" height="100%" data-target="#myModal" id="myImg" src={{"../storage/app/public/order/" . $order->order_id."_order.png?" . rand()}} alt="No Image" onerror="this.onerror=null;this.src='../public/images/index/notfound.png';">
            </div>
        </div>
    </div>
</div>

@endsection