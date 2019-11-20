@extends('layouts.customer')
@section('content')
<div class="body-wrap">
    <div class="h80px"></div>
    <div class="container-fluid about-wrap">
        <div class="w100 center-text margin-auto row about-top-image">
            <img src="public/Images/About/gioi thieu.png" />
        </div>
        <div class="h30px"></div>
        <div class="w100 about-contact">
            <div class="col-md-7 ">
                <h2 class="tltHeadingUppercase">@lang('messages.contact_us')</h2>
                <p class="center-text"> @lang('messages.contact_us_detail') </p>
                <form method="POST" action="{{ url('contact-us') }}" class='formModal'>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="margin-auto contact-form">
                        <div class="validation-summary-valid form-group" data-valmsg-summary="true">
                            <ul>
                                <li style="display:none"></li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.name') <span class="text-danger">*</span> <span id="errorContactName" class="validateError"></span></label>
                            <input  type="text" id="contactName" name="name" placeholder="@lang('messages.name')" maxlength="50" />
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.company_name')</label>
                            <input  type="text" id="contactCompany" name="company" maxlength="250" placeholder="@lang('messages.company_detail')" />
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.phone') <span class="text-danger">*</span>
                                <span id="errorContactPhone" class="validateError"></span></label>
                                <input  id="contactPhone" name="phone" data-inputmask="'alias':'number','mask':' 999 999 9999','placeholder':''" data-mask="" type="text" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span> <span id="errorContactEmail" class="validateError"></span></label>
                                <input  id="contactEmail" name="email" type="text" placeholder="my@example.com" />
                        </div>
                            <input class="button button3" type="submit" value="@lang('messages.submit')" />
                    </div>
                </form>
            </div>
            <div class="col-md-5 center-text about-side-image">
                <img src="public/Images/About/Responsive-Design.png" />
            </div>
        </div>
    </div>
</div>
@endsection