@extends('layouts.customer')
@section('content')


<div class="body-wrap">
    <!--Body Index-->
    <div class="body-index">
        <!--First Banner-->
        <!----------------------Carousel Top Banner---------------------->
        <div class="container-fluid">
            <div class="row-fluid carousel slide" id="bannerTop-carousel-slide" data-ride="carousel" data-interval="5000" data-pause="hover">
                <!--Wrapper for slide-->
                <div class="carousel-inner">
                    <div class="item active">
                        <img id="firstBanner" class="firstbannerimg" src="public/Images/FileUpload/images/TrangChu/index_banner.jpg" alt="banner" title="banner" />
                    </div>
                </div>
                <!--Left & Right control-->
            </div>
        </div>
        <!----------------------END Carousel Top Banner---------------------->
        <div class="three-col-serv-wrap">
            <!-------------Three Col IHT Service-------------->
            <!-- <div class="row-fluid center-text">
                <h2 class="tltHeadingUppercase">@lang('messages.service_ihtgo')</h2>
                <p>@lang('messages.ihtgo_connection_options_for_shop_owners_and_customers')</p><br />
            </div>
            <div class="container serviceIHTGO">
                <div class="col-sm-4 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">@lang('messages.delivery_in_province')</div>
                        <div class="panel-body">
                            <h6>@lang('messages.only_from')</h6>
                            <h2 class="price-order" >70,000Đ/@lang('messages.orders')</h2>
                            <p class="list-provinces">@lang('messages.delivery_in_province_detail')</p>
                            <h5>@lang('messages.delivery_in_province_time')</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">@lang('messages.delivery_outside_province')</div>
                        <div class="panel-body">
                            <h6>@lang('messages.only_from')</h6>
                            <h2 class="price-order">140,000Đ/@lang('messages.orders')</h2>
                            <p class="list-provinces">@lang('messages.delivery_outside_province_detail')</p>
                            <h5>@lang('messages.delivery_outside_province_time')</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">@lang('messages.express_delivery')</div>
                        <div class="panel-body">
                            <h6>@lang('messages.only_from')</h6>
                            <h2 class="price-order">140,000Đ/@lang('messages.orders')</h2>
                            <p class="list-provinces">@lang('messages.express_delivery_detail')</p>
                            <h5>@lang('messages.express_delivery_time')</h5>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-------------END Three Col IHT Service-------------->
            <!--Second Banner-->
            <div class="row-fluid">
                <a href="#!">
                    <img src="public/Images/FileUpload/images/TrangChu/middle-2.png" alt="banner-01.png" title="banner-01.png" style="width:100%;height:80%;">
                </a>
            </div>

            <!-----------------Octopus Section----------------->
            <div class="features-area">
                <div style="padding-bottom:2%;">
                    <br />
                    <h2 class="tltHeadingUppercase">@lang('messages.why_do_you_have_to_choose_IHT_Go')</h2><br />
                </div>
                <!--Octopus Section show on computer-->
                <div class="container">
                    <div class="col-sm-6 display-flex">
                        <div class="col-sm-2 single-item-icon">
                            <img src="public/Images/Index/1.png" />
                        </div>
                        <div class="col-sm-8 ">
                            <div class="whyChooseText"><strong>@lang('messages.track_orders')</strong></div>
                            <p>@lang('messages.track_orders_detail')</p>
                        </div>
                    </div>
                    <div class="col-sm-6 display-flex">
                        <div class="col-sm-3 single-item-icon">
                            <img src="public/Images/Index/2.png" alt="" />
                        </div>
                        <div class="col-sm-9 ">
                            <div class="whyChooseText"><strong>@lang('messages.take_the_place')</strong></div>
                            <p>@lang('messages.take_the_place_detail') </p>
                        </div>
                    </div>
                    <div class="col-sm-6 display-flex">
                        <div class="col-sm-3 single-item-icon">
                            <img src="public/Images/Index/3.png" alt="" />
                        </div>
                        <div class="col-sm-9 ">
                            <div class="whyChooseText"><strong>@lang('messages.cash_on_delivery')</strong></div>
                            <p>@lang('messages.cash_on_delivery_detail')</p>
                        </div>
                    </div>
                    <div class="col-sm-6 display-flex">
                        <div class="col-sm-3 single-item-icon">
                            <img src="public/Images/Index/4.png" alt="" />
                        </div>
                        <div class="col-sm-9 ">
                            <div class="whyChooseText"><strong>@lang('messages.automatic_cost_calculation')</strong></div>
                            <p>@lang('messages.automatic_cost_calculation_detail') </p>
                        </div>
                    </div>
                    <div class="col-sm-6 display-flex">
                        <div class="col-sm-3 single-item-icon">
                            <img src="public/Images/Index/5.png" alt="" />
                        </div>
                        <div class="col-sm-9">
                            <div class="whyChooseText"><strong>@lang('messages.container_holds_heat')</strong></div>
                            <p>@lang('messages.container_holds_heat_detail') </p>
                        </div>
                    </div>
                </div>
                <!--End octopus Section show on computer-->
            </div>
            <!--END Octopus Section----------------->
        </div>
        <!--END Three Col IHT Service-->
    </div>
    <div class="clearfix"></div>
    <!--END Price List------------------->
    <!-------------------User Guide--------------------->
    <div class="container">
        <div class="row-fluid center-text">
            <h2><span class="text-uppercase" style="font-size: 24px;"><strong>@lang('messages.user_manual')</strong></span></h2>
        </div>
        <div class="user-guide-wrap">
            <div class="user-guide owl-carousel owl-theme animated">
                <div class="user-guide-images">
                    <a href="public/Images/FileUpload/images/1.JPEG" data-toggle="lightbox" data-gallery="example-gallery">
                        <div class="user-guide-images-inner">
                            <img src="public/Images/FileUpload/images/1.JPEG" />
                            <div class="hover"></div>
                        </div>
                    </a>
                </div>
                <div class="user-guide-images">
                    <a href="public/Images/FileUpload/images/2.JPEG" data-toggle="lightbox" data-gallery="example-gallery">
                        <div class="user-guide-images-inner">
                            <img src="public/Images/FileUpload/images/2.JPEG" />
                            <div class="hover"></div>
                        </div>
                    </a>
                </div>
                <div class="user-guide-images">
                    <a href="public/Images/FileUpload/images/3.JPEG" data-toggle="lightbox" data-gallery="example-gallery">
                        <div class="user-guide-images-inner">
                            <img src="public/Images/FileUpload/images/3.JPEG" />
                            <div class="hover"></div>
                        </div>
                    </a>
                </div>
                <div class="user-guide-images">
                    <a href="public/Images/FileUpload/images/4.JPEG" data-toggle="lightbox" data-gallery="example-gallery">
                        <div class="user-guide-images-inner">
                            <img src="public/Images/FileUpload/images/4.JPEG" />
                            <div class="hover"></div>
                        </div>
                    </a>
                </div>
                <div class="user-guide-images">
                    <a href="public/Images/FileUpload/images/5.JPEG" data-toggle="lightbox" data-gallery="example-gallery">
                        <div class="user-guide-images-inner">
                            <img src="public/Images/FileUpload/images/5.JPEG" />
                            <div class="hover"></div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!--END User Guide--------------------->
    <div class="h50px"></div>
</div>
@endsection