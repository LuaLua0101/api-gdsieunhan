<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, user-scalable=yes" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('public/Images/Index/logo.png') }}" />

    <!--------------------------------------Bootstrap CSS--------------------------------------------->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!----------------------------------------------------------------------------------->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <!----------------------------------------PagedList----------------------------------------------->
    <link href="{{ URL::asset('public/vendor/PagedList.css" rel="stylesheet') }}" />

    <!-------------------------------------Owl Carousel CSS------------------------------------------>
    <link href="{{ URL::asset('public/vendor/owl carousel 2/assets/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/vendor/owl carousel 2/assets/owl.theme.default.min.css') }}" rel="stylesheet" />

    <!-----------------------------------Ekko lightbox CSS------------------------------------------->
    <link href="{{ URL::asset('public/vendor/ekko lightbox/ekko-lightbox.css') }}" rel="stylesheet" />

    <!----------------------------------------AOS CSS------------------------------------------------>
    <link href="{{ URL::asset('public/vendor/aos/aos.css') }}" rel="stylesheet" />
    <!----------------------------------------Fontawesome CSS---------------------------------------->
    <link href="{{ URL::asset('public/vendor/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!---------------------------------------Custom CSS---------------------------------------------->
    <link href="{{ URL::asset('public/user/css/usercustom.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/css/style.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/shared/common.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/css/bootstrap-select.min.css">
    <!----------------------------------------------------------------------------------------------->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>IHTGO</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        html {
            scrollbar-width: none;
            /* For Firefox */
            -ms-overflow-style: none;
            /* For Internet Explorer and Edge */
        }

        html::-webkit-scrollbar {
            width: 0px;
            /* For Chrome, Safari, and Opera */
        }
    </style>
</head>
<body class="body-container">
    <!---------------------------HEADER------------------------------->
    <header>
        <!---------------------First Header----------------------->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{!! url('/'); !!}"><img class="logo-image" src="{{ URL::asset('public/Images/Index/logo.png') }}" alt="logo" title="logo" /></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::path() == 'contact' ? 'active' : '' }}"><a href="{!! url('contact'); !!}"><strong>@lang('messages.about_us')</strong></a></li>
                        <li class="{{ Request::path() == 'price-list' ? 'active' : '' }}"><a href="{!! url('price-list'); !!}"><strong>@lang('messages.price_list') </strong></a></li>
                        <li class="{{ Request::path() == 'user-manual' ? 'active' : '' }}"><a href="{!! url('user-manual'); !!}"><strong>@lang('messages.user_manual') </strong></a></li>
                        <!-- <li class="{{ Request::path() == 'news' ? 'active' : '' }}"><a href="{!! url('news'); !!}"><strong>@lang('messages.news')</strong></a></li> -->
                        @if(app()->getLocale()=='vi')
                        <li><a href="{{ url('locale/en') }}"><i class="fa fa-language"></i>EN</a></li>
                        @else
                        <li><a href="{{ url('locale/vi') }}"><i class="fa fa-language"></i> VI</a></li>
                        @endif
                        <li><a type="button" class="btn btn-default" href="https://booking.ihtgo.com.vn"><strong>@lang('messages.order_now')</strong> </a></li>
                    </ul>
                    <!-- <ul class="nav navbar-nav navbar-right">
                        @if(Auth::user())
                        <li><a data-toggle="modal" data-target="#createOrder"><strong>@lang('messages.create_order') </strong></a></li>
                        <li class="{{ Request::path() == 'order' ? 'active' : '' }}"><a href="{!! url('order'); !!}"><strong>@lang('messages.order_management') </strong></a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">@lang('messages.hello') {{Auth::user()->name}}<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-toggle="modal" data-target="#InfoUser">@lang('messages.personal_information') </a></li>
                                <li><a href="#" data-toggle="modal" data-target="#ChangePassword">@lang('messages.change_password')</a></li>
                                <li><a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">@lang('messages.log_out')
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                        </li>
                        @else
                        <li><a class=" " data-toggle="modal" data-target="#Login"><span class="glyphicon glyphicon-user"></span> @lang('messages.login') </a></li>
                        <li><a class=" " data-toggle="modal" data-target="#Registered"><span class="fas fa-user-plus"></span> @lang('messages.registration') </a></li>
                        @endif
                    </ul> -->
                </div>
            </div>
        </nav>
    </header>

    <!--  Modal create order -->
    @if(Auth::user())
    <div class="modal fade" id="createOrder" role="dialog">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ url('/create-order') }}" class='formModal' id='formCreateOrder' enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">@lang('messages.create_order')</h3>
                    </div>
                    <div class="modal-body row">
                        <div class="col-sm-6">
                            <h4>@lang('messages.sender_information') (*)</h4>
                            <label>@lang('messages.name'): <span class="text-danger" id='error-sender-name'></span></label>
                            <input type="text" name="sender_name" id="sender_name" placeholder="@lang('messages.name')" require>

                            <label>@lang('messages.phone'): <span class="text-danger" id='error-sender-phone'></span></label>
                            <input type="number" name="sender_phone" id="sender_phone" placeholder="@lang('messages.phone') ">

                            <label>@lang('messages.please_select_province_city'): <span class="text-danger" id='error-sender-province-id'></span></label>
                            <select id="sender_province_id" name="sender_province_id">
                                <option value="0">@lang('messages.please_select_province_city') </option>
                                @foreach($province as $p)
                                <option value="{{$p->province_id}}">{{$p->name}}</option>
                                @endforeach
                            </select>

                            <label> @lang('messages.please_select_district'):<span class="text-danger" id='error-sender-district-id'></span></label>
                            <select id="sender_district_id" name="sender_district_id">
                                <option value="0">@lang('messages.please_select_district') </option>
                            </select>

                            <label>@lang('messages.sender_address'): <span class="text-danger" id='error-sender-address'></span></label>
                            <input type="text" name="sender_address" id="sender_address" placeholder="@lang('messages.sender_address') ">
                        </div>
                        <div class="col-sm-6">
                            <h4>@lang('messages.receiver_information')(*) </h4>
                            <label>@lang('messages.name'):<span class="text-danger" id='error-receive-name'></span> </label>
                            <input type="text" name="receive_name" id="receive_name" placeholder="@lang('messages.name')">

                            <label>@lang('messages.phone'):<span class="text-danger" id='error-receive-phone'></span> </label>
                            <input type="number" name="receive_phone" id="receive_phone" placeholder="@lang('messages.phone')">

                            <label>@lang('messages.please_select_province_city'):<span class="text-danger" id='error-receive-province-id'></span> </label>
                            <select id="receive_province_id" name="receive_province_id">
                                <option value="0">@lang('messages.please_select_province_city')(*)</option>
                                @foreach($province as $p)
                                <option value="{{$p->province_id}}">{{$p->name}}</option>
                                @endforeach
                            </select>

                            <label>@lang('messages.please_select_district'):<span class="text-danger" id='error-receive-district-id'></span> </label>
                            <select id="receive_district_id" name="receive_district_id">
                                <option value="0">@lang('messages.please_select_district')</option>
                            </select>

                            <label>@lang('messages.receiver_address'):<span class="text-danger" id='error-receive-address'></span> </label>
                            <input type="text" id="receive_address" name="receive_address" placeholder="@lang('messages.receiver_address')">
                        </div>
                        <div class="col-sm-12">
                            <h4>@lang('messages.order_information') (*)</h4>
                        </div>
                        <div class="col-sm-6">
                            <label>@lang('messages.order_name')(cm)*:</label>
                            <input type="text" placeholder="@lang('messages.order_name') " id="name" name="name">
                            <div class="row">
                                <div class="col-sm-4" id='form-length'>
                                    <label>@lang('messages.length')(cm)*:<span class="text-danger" id='error-length-order'></span></label>
                                    <input type="number" min="0" max="100" step="0.25" placeholder="@lang('messages.length') (cm)*" id="length" name="length">
                                </div>

                                <div class="col-sm-4" id='form-width'>
                                    <label>@lang('messages.width')(cm)*:<span class="text-danger" id='error-width-order'></span></label>
                                    <input type="number" min="0" max="100" step="0.25" placeholder="@lang('messages.width') (cm)*" id="width" name="width">
                                </div>

                                <div class="col-sm-4" id='form-height'>
                                    <label>@lang('messages.height')(cm)*:<span class="text-danger" id='error-height-order'></span></label>
                                    <input type="number" min="0" max="100" step="0.25" placeholder="@lang('messages.height') (cm)*" id="height" name="height">
                                </div>
                            </div>
                            <div id='form-weight'>
                                <label>@lang('messages.weight')(kg)*: <span class="text-danger" id='error-weight-order'></span></label>
                                <input type="number" min="0" max="100" step="0.25" placeholder="@lang('messages.weight') (*)" id="weight" name="weight">
                            </div>

                            <label>@lang('messages.cash_on_delivery'): </label>
                            <input type="number" step="any" placeholder="@lang('messages.cash_on_delivery') (VND)" id="take_money" name="take_money">


                        </div>
                        <div class="col-sm-6 ">
                            <div class="row">
                                <div class="col-sm-6 ">
                                    <label class="title-form">@lang('messages.payer') :</label>
                                    <div class="form-check">
                                        <label>
                                            <input type="radio" name="payer" value="1" checked> <span class="label-text">@lang('messages.receicer')</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label>
                                            <input type="radio" name="payer" value="2"> <span class="label-text">@lang('messages.sender')</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 ">

                                    <label class="title-form">@lang('messages.service') :</label>
                                    <div class="form-check">
                                        <label>
                                            <input type="checkbox" name="is_speed" value="1" checked> <span class="label-text">@lang('messages.express_delivery')</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label>
                                            <input type="checkbox" name="ckbdelivery_of_documents" id='ckbdelivery_of_documents' value="2"> <span class="label-text">@lang('messages.delivery_of_documents')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if($customer->type == 2)
                            <label class="title-form">@lang('messages.payment_methods') :</label>
                            <div class="form-check">
                                <label>
                                    <input type="radio" name="payment_type" value="1" checked> <span class="label-text">@lang('messages.cash')</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label>
                                    <input type="radio" name="payment_type" value="2"> <span class="label-text">@lang('messages.monthly')</span>
                                </label>
                            </div>
                            @endif

                            <div class="row">
                                <div class="custom-file col-sm-4">
                                    <label>@lang('messages.photo_order') :</label>
                                    <div class="upload-btn-wrapper">
                                        <img id="img1" width="130" src="{{ URL::asset('public/images/Index/notfound.png') }}">
                                        <input type="file" id="customFile" name="image_order" onchange="readURL(event, 1)" />
                                    </div>
                                </div>
                                <div class="form-group col-sm-8">
                                    <label>@lang('messages.note') :</label>
                                    <textarea rows="5" name="note" placeholder="@lang('messages.note')"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button button3" id="btnCreateOrder">@lang('messages.save')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    <!-- Modal login-->
    <div class="modal fade" id="Login" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="{{ route('login') }}" class='formModal' id='formLogin'>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">@lang('messages.login') </h3>
                    </div>
                    <div class="modal-body ">
                        <label>@lang('messages.phone'):<span class="text-danger" id='error-phone1'></span></label>
                        <input type="number" id="phone1" name="phone" placeholder="@lang('messages.phone')..">
                        <label>@lang('messages.password'):<span class="text-danger" id='error-password1'></span></span></label>
                        <input type="password" id='password1' name="password" placeholder="@lang('messages.password')..">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button button3" id='btnLogin'>@lang('messages.login') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Registered-->
    <div class="modal fade" id="Registered" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ url('register') }}" class='formModal' id='formRegister'>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">@lang('messages.become_a_ihtgo_customer_now') </h3>
                    </div>
                    <div class="modal-body row">
                        <div class="col-sm-6">
                            <label> @lang('messages.name'): <span class="text-danger" id='error-name2'></span> </label>
                            <input type="text" placeholder="@lang('messages.name') " id='name2' name='name' required>

                            <label>Email: <span class="text-danger" id='error-email2'></span></label>
                            <input type="mails" placeholder="Email" id='email2' name='email' required>

                            <label> @lang('messages.phone'): <span class="text-danger" id='error-phone2'></span></label>
                            <input type="number" placeholder="@lang('messages.phone') " id='phone2' name=phone required>

                            <label> @lang('messages.password'): <span class="text-danger" id='error-password2'></span></label>
                            <input type="password" placeholder="@lang('messages.password') " name="password" id="password2" required>

                            <label> @lang('messages.confirm_password'): <span class="text-danger" id='error-re-password2'></span></label>
                            <input type="password" placeholder="@lang('messages.confirm_password') " name='re-password' id='re-password2' required>
                        </div>
                        <div class="col-sm-6">
                            <label> @lang('messages.please_select_province_city'): <span class="text-danger" id='error-registered-province-id'></span></label>
                            <select id="registered_province_id" name="province_id" required>
                                <option value="0">@lang('messages.please_select_province_city')</option>
                                @foreach($province as $p)
                                <option value="{{$p->province_id}}">{{$p->name}}</option>
                                @endforeach
                            </select>

                            <label> @lang('messages.please_select_district'): <span class="text-danger" id='error-registered-district-id'></span></label>
                            <select id="registered_district_id" name="district_id" required>
                                <option value="0">@lang('messages.please_select_district') </option>
                            </select>
                            <label> @lang('messages.address'): <span class="text-danger" id='error-sender-address'></span></label>
                            <input type="text" name="address" id="address" placeholder="@lang('messages.address') ">
                            <label class="col-sm-4">@lang('messages.customer_type') : </label>
                            <div class="form-check col-sm-4">
                                <label>
                                    <input type="radio" checked="checked" name="type" id='rdoPersonal' value="1"> <span class="label-text">@lang('messages.personal')</span>
                                </label>
                            </div>
                            <div class="form-check col-sm-4">
                                <label>
                                    <input type="radio" name="type" id='rdoCompany' value="2"> <span class="label-text">@lang('messages.company')</span>
                                </label>
                            </div>
                            <div id="listCompany">
                                <label>@lang('messages.list_of_companies') :</label>
                                <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width: 100%" id="company_id" name="company_id">
                                    @foreach($company as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button button3" id='btnRegister'>@lang('messages.save') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(Auth::user())
    <!-- Modal Info User-->
    <div class="modal fade" id="InfoUser" role="dialog">
        <div class="modal-dialog">
            <form method="POST" action="{{ url('edit-user') }}" class='formModal'>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@lang('messages.personal_information') </h4>
                    </div>
                    <div class="modal-body">
                        <label>@lang('messages.name'):<span class="text-danger" id='error-name3'></span></label>
                        <input type="text" placeholder="@lang('messages.name')" name="name" id="name3" value="{{Auth::user()->name}}">
                        <label>Email:<span class="text-danger" id='error-name3'></span></label>
                        <input type="text" placeholder="Email" disabled value="{{Auth::user()->email}}">
                        <label>@lang('messages.phone'):<span class="text-danger" id='error-phone3'></span></label>
                        <input type="tel" placeholder="@lang('messages.phone') " disabled value="{{Auth::user()->phone}}">
                        <label>@lang('messages.address'):<span class="text-danger" id='error-address3'></span></label>
                        @if($customer==null)
                        <input type="text" name="address" id="address3" placeholder="@lang('messages.address') " value="">
                        @else
                        <input type="text" name="address" id="address3" placeholder="@lang('messages.address') " value="{{$customer->address}}">
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button button3" id='btnInfoUser'>@lang('messages.save') </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    <!-- Modal ChangePassword-->
    <div class="modal fade" id="ChangePassword" role="dialog">
        <div class="modal-dialog">
            <form method="POST" action="{{ url('change-password') }}" class='formModal' id='formChangePassword'>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@lang('messages.change_password')</h4>
                    </div>
                    <div class="modal-body">
                        <label>@lang('messages.current_password') :<span class="text-danger" id='error-current-password4'></span></label>
                        <input type="password" name="current_password" id='current-password4' placeholder="@lang('messages.current_password') ">
                        <label>@lang('messages.password') :<span class="text-danger" id='error-new-password4'></span></label>
                        <input type="password" name='new_password' id='new-password4' placeholder="@lang('messages.password') ">
                        <label>@lang('messages.confirm_password') :<span class="text-danger" id='error-re-password4'></span></label>
                        <input type="password" name='re_password' id='re-password4' placeholder="@lang('messages.confirm_password')">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button button3" id='btnChangePassword'>@lang('messages.save') </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (Session::has('error'))
    <div class="noti">
        <div class="alert alert-danger alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get('error') }}
        </div>
    </div>
    @endif
    @if (Session::has('success'))
    <div class="noti">
        <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get('success') }}
        </div>
    </div>
    @endif
    @yield('content')
    <!---------------------------FOOTER------------------------------->
    <footer>
        <!-- <a id="back-to-top" href="#" class="btn btn-lg back-to-top" role="button" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a> -->
        <div class="footer-imgcontent">
            <div class="w100 footer-imgcontent-inner">
                <div class="col-sm-8 col-md-push-2">
                    <div class="imgcont-headtitle">
                        <h2 data-aos="fade-down">
                            <span style="font-weight:700;">@lang('messages.download_now_IHTGo_app')</span>
                        </h2>
                        <p data-aos="fade-up">@lang('messages.download_now_IHTGo_app_detail')</p>
                    </div>
                </div>
                <div class="w100 col-sm-12 imgcont-icon">
                    <div class="imgcont-icon-innner">
                        <a href="https://itunes.apple.com/vn/app/iht-giao-h%C3%A0ng/id1451150698?mt=8&ign-mpt=uo%3D4">
                            <i class="fab fa-apple fa-inverse fa-3x" aria-hidden="true"></i>

                            <span>App Store</span>
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.yousoft.giaohang&hl=vi">
                            <i class="fab fa-android fa-inverse fa-3x" aria-hidden="true"></i>
                            <span>Google Play</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid footer-middle">
            <div class="w100">
                <div class="col-sm-6 footMid1stCol">
                    <p class="text-uppercase"><strong>IHT Go</strong></p>
                    <ul class="list-unstyled">
                        <li>@lang('messages.address') : @lang('messages.address_hcm_5') </li>
                        <li>@lang('messages.phone') : <a href="tel:0902926925">0902.926.925</a></li>
                        <li>@lang('messages.tax_code') : 0310212371</li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <ul class="nav navbar-nav social-footer">
                        <li><a href="https://www.facebook.com/ihtgo"><i class="fab fa-facebook-square"></i></a></li>
                        <li><a href="tel:0902926925"><i class="fas fa-phone-square"></i></a></li>
                        <li><a href="mailto:ihtgo.vn@gmail.com?Subject=Hello%20again"> <i class="fas fa-envelope"></i></a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <p class="text-uppercase"><strong> @lang('messages.branch_system') </strong></p>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                        @lang('messages.hcm_branch')
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_hcm_8_ba_trieu') }}">@lang('messages.address_hcm_5') </a></li>
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_hcm_6') }}">@lang('messages.address_hcm_6') </a></li>
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_hcm_12') }}">@lang('messages.address_hcm_12') </a></li>
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_hcm_binh_chanh') }}">@lang('messages.address_hcm_binh_chanh') </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                        @lang('messages.bd_branch')
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_bd_my_phuoc') ">@lang('messages.address_bd_my_phuoc') </a></li>
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_bd_td1') ">@lang('messages.address_bd_td1') </a></li>
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_bd_thuan_an') ">@lang('messages.address_bd_thuan_an') </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                        @lang('messages.dn_branch')
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_dn_bien_hoa') ">@lang('messages.address_dn_bien_hoa') </a></li>
                                        <li class="list-group-item"><a href="http://maps.google.com/?q=@lang('messages.address_dn_nhon_trach')">@lang('messages.address_dn_nhon_trach') </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div><!-- panel-group -->
                </div>
            </div>
        </div>
        <div class="container-fluid center-text footer-bottom" style="background: #dcdcdc; padding-top: 10px;">
            <p style="color:#707070;">Copyright &#9400; 2019 IHTGO. Design by IHT</p>
        </div>
    </footer>

    <!-- The scroll to top feature -->
    <div class="scroll-top-wrapper ">
        <span class="scroll-top-inner">
            <i class="fa fa-2x fa-arrow-up" style="color:white"></i>
        </span>
    </div>
    <script>
        var error_name = "@lang('messages.error_name')";
        var error_phone = "@lang('messages.error_phone')";
        var error_check_phone = "@lang('messages.error_check_phone')";
        var error_phone_has_been_used = "@lang('messages.error_phone_has_been_used')";
        var error_email = "@lang('messages.error_email')";
        var error_check_email = "@lang('messages.error_check_email')";
        var error_email_has_been_used = "@lang('messages.error_email_has_been_used')";
        var error_password = "@lang('messages.error_password')";
        var error_re_password = "@lang('messages.error_re_password')";
        var error_current_password = "@lang('messages.error_current_password')";
        var error_length_password = "@lang('messages.error_length_password')";
        var error_address = "@lang('messages.error_address')";
        var error_province = "@lang('messages.error_province')";
        var error_district = "@lang('messages.error_district')";
        var error_length = "@lang('messages.error_length')";
        var error_width = "@lang('messages.error_width')";
        var error_height = "@lang('messages.error_height')";
        var error_weight = "@lang('messages.error_weight')";
    </script>
    <!---------------------------------Jquery JS------------------------------------------>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <!--------------------------------Bootstrap JS---------------------------------------->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!--------------------------------Ekko lightbox JS-------------------------------------->
    <script src="{{ URL::asset('public/vendor/ekko lightbox/ekko-lightbox.js') }}"></script>

    <!--------------------------------Owl Carousel JS---------------------------------------->
    <script src="{{ URL::asset('public/vendor/owl carousel 2/owl.carousel.min.js') }}"></script>

    <!-------------------------------------AOS JS------------------------------------------>
    <script src="{{ URL::asset('public/vendor/aos/aos.js') }}"></script>

    <!-----------------------------------Inputmask JS------------------------------------------>
    <script src="{{ URL::asset('public/vendor/inputmask/jquery.inputmask.bundle.min.js') }}"></script>

    <!------------------------------------Custom JS---------------------------------------->
    <script src="{{ URL::asset('public/user/js/usercustom.js') }}"></script>

    <!-- <script src="{{ URL::asset('public/js/fontawesome.min.js') }}"></script> -->


</body>

</html>

<script type="text/javascript">
    function readURL(event, id) {
        var output = document.getElementById('img' + id);
        output.src = URL.createObjectURL(event.target.files[0]);
    };

    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>