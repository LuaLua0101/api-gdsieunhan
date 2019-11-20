//--------------------------------------------
//           MAIN USER JAVASCRIPT
//--------------------------------------------
$(function () {
    //Test browser on window or phone
    console.log(navigator.userAgent.toString());
    //if (!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
    //}

    //----------------------------------------------------
    //                      HEADER
    //----------------------------------------------------
    $("#responsive-bar-menu").click(function () {
        $(".secondheader").slideToggle(400);
    });
    $('.body-wrap, footer').on("touchstart", function () {
        $(".secondheader").slideUp(400);
    });
    //-----Fixed Header with transition-----
    if (window.outerWidth <= 990) {
        $('.secondHeadPhoneFix').wrapAll("<div class='navbar navbar-fixed-top' />");
    }

    //----------------------------------------------------
    //                      FOOTER
    //----------------------------------------------------
    //Scroll to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('#back-to-top').tooltip('show');

    //----------------------------------------------------
    //                      INDEX PAGE
    //----------------------------------------------------
    //--------------Price List--------------
    //Bootstrap carousel swipe
    $(".carousel").on("touchstart", function (event) {
        var xClick = event.originalEvent.touches[0].pageX;
        $(this).one("touchmove", function (event) {
            var xMove = event.originalEvent.touches[0].pageX;
            if (Math.floor(xClick - xMove) > 5) {
                $(this).carousel('next');
            }
            else if (Math.floor(xClick - xMove) < -5) {
                $(this).carousel('prev');
            }
        });
        $(".carousel").on("touchend", function () {
            $(this).off("touchmove");
        });
    });
    //--------------Owl Carousel Section Index-------------
    $('.user-guide').owlCarousel({
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 3,
                nav: false
            },
            1000: {
                items: 4,
                nav: false,
                loop: false
            }
        }
    });
    //----------delegate calls to data-toggle="lightbox"------------------
    $(document).on('click', '[data-toggle="lightbox"]', function (e) {
        e.preventDefault();
        if (window.outerWidth > 600) {
            return $(this).ekkoLightbox();
        }
    });
    //------------------AOS Index-------------------
    AOS.init({
        duration: 1000,
        disable: ['phone', 'tablet', 'mobile'],
    });
    //--------------------------------------------------
    //                     ABOUT PAGE
    //--------------------------------------------------
    $('[data-mask]').inputmask();
    $('#contactEmail').inputmask({
        mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}][@]*{1,20}[.*{2,6}][.*{1,2}]",
        greedy: false,
        onBeforePaste: function (pastedValue, opts) {
            pastedValue = pastedValue.toLowerCase();
            return pastedValue.replace("mailto:", "");
        },
        definitions: {
            '*': {
                validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                casing: "lower"
            }
        },
        placeholder: ""
    });
    //Validate About
    $(document).on('click', '#btnContactSubmit', function () {
        var error = 0;
        var phone = $.trim($("#contactPhone").val());
        var email = $.trim($("#contactEmail").val());
        //contactName
        if ($.trim($('#contactName').val()) == "") {
            $('#errorContactName').text(error_name);
            error++;
        } else {
            $('#errorContactName').text("");
        }
        //contactPhone
        if (phone == "") {
            $('#errorContactPhone').text(error_phone);
            error++;
        } else if (!checkPhoneNumber(phone)) {
            $('#errorContactPhone').text(error_check_phone);
            error++;
        } else {
            $('#errorContactPhone').text("");
        }
        //contactEmail
        if (email == "") {
            $('#errorContactEmail').text(error_email);
            error++;
        } else if (!isEmail(email)) {
            $('#errorContactEmail').text(error_check_email);
            error++;
        } else {
            $('#errorContactEmail').text("");
        }
        return (error != 0) ? false : true;
    });
    //contactName
    $('#contactName').on('change keydown', function () {
        $('#errorContactName').text("");
    });
    $('#contactName').on('focusout blur', function () {
        if ($.trim($('#contactName').val()) == "") {
            $('#errorContactName').text(error_name);
        } else {
            $('#errorContactName').text("");
        }
    });
    //contactPhone
    $('#contactPhone').on('change keydown', function () {
        $('#errorContactPhone').text("");
    });
    $('#contactPhone').on('focusout blur', function () {
        var phone = $.trim($("#contactPhone").val());
        if (phone == "") {
            $('#errorContactPhone').text(error_phone);
        } else if (!checkPhoneNumber(phone)) {
            $('#errorContactPhone').text(error_check_phone);
        } else {
            $('#errorContactPhone').text('');
        }
    });
    //contactEmail
    $('#contactEmail').on('change keydown', function () {
        $('#errorContactEmail').text("");
    });
    $('#contactEmail').on('focusout blur', function () {
        var email = $.trim($("#contactEmail").val());
        if (email == "") {
            $('#errorContactEmail').text(error_email);
            error++;
        } else if (!isEmail(email)) {
            $('#errorContactEmail').text(error_check_email);
            error++;
        } else {
            $('#errorContactEmail').text("");
        }
    });
    //------------------------Raymond edit----------------------

    //validate form login--------------
    $("#btnLogin").click(function () {
        var phone = $.trim($("#phone1").val());
        var password = $.trim($("#password1").val());
        var flag = 0;
        //validate phone
        if (phone == '') {
            $('#error-phone1').text(error_phone);
            flag++;
        } else if (!checkPhoneNumber(phone)) {
            $('#error-phone1').text(error_check_phone);
            flag++;
        } else {
            $('#error-phone1').text('');
        }
        //validate password
        if (password == '') {
            $('#error-password1').text(error_password);
            flag++;
        } else if (password.length < 6) {
            $('#error-password1').text(error_re_password);
            flag++;
        } else {
            $('#error-password1').text('');
        }
        //check validate
        if (flag != 0) {
            return false;
        }
        else {
            return true;
        }
    });
    //validate form register-----------
    $("#btnRegister").click(function () {
        var name = $.trim($("#name2").val());
        var email = $.trim($("#email2").val());
        var phone = $.trim($("#phone2").val());
        var password = $.trim($("#password2").val());
        var re_password = $.trim($("#re-password2").val());
        var province = $.trim($("#registered_province_id").val());
        var district = $.trim($("#registered_district_id").val());

        var flag = 0;
        //name
        if (name == '') {
            $('#error-name2').text(error_name);
            flag++;
        } else {
            $('#error-name2').text('');
        }
        //email
        if (email == '') {
            $('#error-email2').text(error_email);
            flag++;
        } else if (!isEmail(email)) {
            $('#error-email2').text(error_check_email);
            flag++;
        } else {
            $.ajax({
                type: "GET",
                url: 'checkExistEmail/' + email,
                success: function (data) {
                    if (data != 200) {
                        $('#error-email2').text(error_email_has_been_used);
                        flag++;
                    } else {
                        $('#error-email2').text('');
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR);
                }
            })
        }

        //phone
        if (phone == '') {
            $('#error-phone2').text(error_phone);
            flag++;
        } else if (!checkPhoneNumber(phone)) {
            $('#error-phone2').text(error_check_phone);
            flag++;
        }
        else {
            $.ajax({
                type: "GET",
                url: 'checkExistPhone/' + phone,
                success: function (data) {
                    if (data != 200) {
                        $('#error-phone2').text(error_phone_has_been_used);
                        flag++;
                    } else {
                        $('#error-phone2').text('');
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR);
                }
            })
        }
        //password
        if (password == '') {
            $('#error-password2').text(error_password);
            flag++;
        } else if (password.length < 6) {
            $('#error-password2').text(error_length_password);
            flag++;
        } else {
            $('#error-password2').text('');
        }
        //re-password
        if (re_password == '') {
            $('#error-re-password2').text(error_password);
            flag++;
        } else if (re_password.length < 6) {
            $('#error-re-password2').text(error_length_password);
            flag++;
        }
        else if (password != re_password) {
            $('#error-re-password2').text(error_current_password);
            flag++;
        } else {
            $('#error-re-password2').text('');
        }
        //province
        if (province == '' || province == 0) {
            $('#error-registered-province-id').text(error_province);
            flag++;
        } else {
            $('#error-registered-province-id').text('');
        }
        //district
        if (district == '' || district == 0) {
            $('#error-registered-district-id').text(error_district);
            flag++;
        } else {
            $('#error-registered-district-id').text('');
        }
        if (flag == 0) {
            return true;
        } else {
            return false;
        }
    });
    //validate form info user-----------
    $("#btnInfoUser").click(function () {
        var name = $.trim($("#name3").val());
        var address = $.trim($("#address3").val());
        var flag = 0;
        if (name == '') {
            $('#error-name3').text(error_name);
            flag++;
        } else {
            $('#error-name3').text('');
        }
        if (address == '') {
            $('#error-address3').text(error_address);
            flag++;
        } else {
            $('#error-address3').text('');
        }
        //check validate
        if (flag != 0) {
            return false;
        }
        else {
            return true;
        }
    });
    //validate form change password-----------
    $("#btnChangePassword").click(function () {
        var current_password = $.trim($("#current-password4").val());
        var password = $.trim($("#new-password4").val());
        var re_password = $.trim($("#re-password4").val());
        var flag = 0;
        //current password
        if (current_password == '') {
            $('#error-current-password4').text(error_password);
            flag++;
        } else if (current_password.length < 6) {
            $('#error-current-password4').text(error_length_password);
            flag++;
        } else {
            $.ajax({
                type: "GET",
                url: 'checkExistPasswordCurrent/' + current_password,
                success: function (data) {
                    if (data != 200) {
                        $('#error-current-password4').text(error_re_password);
                        flag++;
                    } else {
                        $('#error-current-password4').text('');
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR);
                }
            })
        }
        //password
        if (password == '') {
            $('#error-new-password4').text(error_password);
            flag++;
        } else if (password.length < 6) {
            $('#error-new-password4').text(error_length_password);
            flag++;
        } else {
            $('#error-new-password4').text('');
        }
        // re password
        if (re_password == '') {
            $('#error-re-password4').text(error_password);
            flag++;
        } else if (re_password.length < 6) {
            $('#error-re-password4').text(error_length_password);
            flag++;
        }
        else if (password != re_password) {
            $('#error-re-password4').text(error_current_password);
            flag++;
        } else {
            $('#error-re-password4').text('');
        }
        //check validate
        if (flag != 0) {
            return false;
        } else {
            return true;
        }
    });

    //validate form change search order-----------
    $("#start-date").change(function () {
        var start_date = $.trim($("#start-date").val());
        if (start_date == '') {
            $('#error-start-date').text('Vui lòng chọn ngày bắt đầu');
        } else {
            $('#error-start-date').text('');
        }
    });
    $("#end-date").change(function () {
        var start_date = $.trim($("#start-date").val());
        var end_date = $.trim($("#end-date").val());
        if (end_date == '') {
            $('#error-end-date').text('Vui lòng chọn ngày bắt đầu');
        } else if (start_date > end_date) {
            $('#error-end-date').text('Vui lòng chọn ngày kết thúc lớn hơn ngày bắt đầu');
        }
        else {
            $('#error-end-date').text('');
        }
    });
    $("#formSearchOrder").change(function () {
        var start_date = $.trim($("#start-date").val());
        var end_date = $.trim($("#end-date").val());
        var flag = 0;
        if (start_date != '' && end_date != '') {
            flag++;
        }
        if (start_date < end_date) {
            flag++;
        }
        if (flag == 2) {
            $('#btnSearchOrder').prop("disabled", false);
        }
        else {
            $('#btnSearchOrder').prop("disabled", true);
        }
    });
    //validate form create order-----------
    $("#btnCreateOrder").click(function () {
        var sender_name = $.trim($("#sender_name").val());
        var sender_phone = $.trim($("#sender_phone").val());
        var sender_province_id = $.trim($("#sender_province_id").val());
        var sender_district_id = $.trim($("#sender_district_id").val());
        var sender_address = $.trim($("#sender_address").val());
        var receive_name = $.trim($("#receive_name").val());
        var receive_phone = $.trim($("#receive_phone").val());
        var receive_province_id = $("#receive_province_id").val();
        var receive_district_id = $("#receive_district_id").val();
        var receive_address = $.trim($("#receive_address").val());
        var length = $.trim($("#length").val());
        var width = $.trim($("#width").val());
        var height = $.trim($("#height").val());
        var weight = $.trim($("#weight").val());
        var flag = 0;
        //sender name
        if (sender_name == '') {
            $('#error-sender-name').text(error_name);
            flag++;
        } else {
            $('#error-sender-name').text('');
        }
        //sender phone
        if (sender_phone == '') {
            $('#error-sender-phone').text(error_phone);
            flag++;
        } else if (!checkPhoneNumber(sender_phone)) {
            $('#error-sender-phone').text(error_check_phone);
            flag++;
        }
        else {
            $('#error-sender-phone').text('');
        }
        //sender province
        if (sender_province_id == '' || sender_province_id == 0) {
            $('#error-sender-province-id').text(error_province);
            flag++;
        } else {
            $('#error-sender-province-id').text('');
        }
        //sender district
        if (sender_district_id == '' || sender_district_id == 0) {
            $('#error-sender-district-id').text(error_district);
            flag++;
        } else {
            $('#error-sender-district-id').text('');
        }
        //sender address
        if (sender_address == '') {
            $('#error-sender-address').text(error_address);
            flag++;
        } else {
            $('#error-sender-address').text('');
        }
        //receive name
        if (receive_name == '') {
            $('#error-receive-name').text(error_name);
            flag++;
        } else {
            $('#error-receive-name').text('');
        }
        //receive phone
        if (receive_phone == '') {
            $('#error-receive-phone').text(error_phone);
            flag++;
        } else if (!checkPhoneNumber(receive_phone)) {
            $('#error-receive-phone').text(error_check_phone);
            flag++;
        } else {
            $('#error-receive-phone').text('');
        }
        //receive province
        if (receive_province_id == '' || receive_province_id == 0) {
            $('#error-receive-province-id').text(error_province);
            flag++;
        } else {
            $('#error-receive-province-id').text('');
        }
        //receive district
        if (receive_district_id == '' || receive_district_id == 0) {
            $('#error-receive-district-id').text(error_district);
            flag++;
        } else {
            $('#error-receive-district-id').text('');
        }
        //receive address
        if (receive_address == '') {
            $('#error-receive-address').text(error_address);
            flag++;
        } else {
            $('#error-receive-address').text('');
        }
        //length
        if (length == '') {
            $('#error-length-order').text(error_length);
            flag++;
        } else {
            $('#error-length-order').text('');
        }
        //width
        if (width == '') {
            $('#error-width-order').text(error_width);
            flag++;
        } else {
            $('#error-width-order').text('');
        }
        //height
        if (height == '') {
            $('#error-height-order').text(error_height);
            flag++;
        } else {
            $('#error-height-order').text('');
        }
        //weight
        if (weight == '') {
            $('#error-weight-order').text(error_weight);
            flag++;
        } else {
            $('#error-weight-order').text('');
        }
        if (flag != 0) {
            return false;
        }
        else {
            return true;
        }
    });

    //validate email-----------
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    //validate check phone------
    function checkPhoneNumber(data) {
        var flag = false;
        var phone = data; // ID của trường Số điện thoại
        phone = phone.replace('(+84)', '0');
        phone = phone.replace('+84', '0');
        phone = phone.replace('0084', '0');
        phone = phone.replace(/ /g, '');
        if (phone != '') {
            var firstNumber = phone.substring(0, 2);
            if ((firstNumber == '09' || firstNumber == '08' || firstNumber == '07' || firstNumber == '05' || firstNumber == '03') && phone.length == 10) {
                if (phone.match(/^\d{10}/)) {
                    flag = true;
                }
            } else if ((firstNumber == '02') && phone.length == 11 || phone.length == 12) {
                if ((phone.match(/^\d{11}/)) || (phone.match(/^\d{12}/))) {
                    flag = true;
                }
            }
        }
        return flag;
    }
    // set time show for the alert
    setTimeout(function () {
        $(".alert").alert('close');
    }, 2000);
    //thêm biến token cho ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //hiển thị quận/huyện theo tỉnh/thành phố khi chọn vào (form tạo đơn hàng)
    $('#receive_province_id').change(function () {
        var Id = $('#receive_province_id').val();
        $.ajax({
            type: "GET",
            url: 'districtOfProvince/' + Id,
            success: function (data) {
                $("#receive_district_id").empty();
                data.forEach(function (item) {
                    $("#receive_district_id").append("<option value = '" + item.id + "'>" + item.text + "</option>");
                })
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.log('jqXHR:');
                console.log(jqXHR);

            }
        })
    });
    $('#sender_province_id').change(function () {
        var Id = $('#sender_province_id').val();
        $.ajax({
            type: "GET",
            url: 'districtOfProvince/' + Id,
            success: function (data) {
                $("#sender_district_id").empty();
                data.forEach(function (item) {
                    $("#sender_district_id").append("<option value = '" + item.id + "'>" + item.text + "</option>");
                })
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('jqXHR:');
                console.log(jqXHR);
            }
        })
    });
    $('#registered_province_id').change(function () {
        var Id = $('#registered_province_id').val();
        $.ajax({
            type: "GET",
            url: 'districtOfProvince/' + Id,
            success: function (data) {
                $("#registered_district_id").empty();
                data.forEach(function (item) {
                    $("#registered_district_id").append("<option value = '" + item.id + "'>" + item.text + "</option>");
                })
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('jqXHR:');
                console.log(jqXHR);
            }
        })
    });
    //hiển thị danh sách công ty trên form đăng ký
    $('#rdoCompany').change(function () {
        $('#listCompany').css('display', 'block');
    });

    //hiển thị danh sách công ty trên form thông tin cá nhân
    $('#rdoCompany2').change(function () {
        $('#listCompany2').css('display', 'block');
    });
    //thay đổi trạng thái loại khách hàng trên form đăng ký thành viên
    $('#rdoPersonal').change(function () {
        $('#listCompany').css('display', 'none');
        $("#company_id2").empty();
    });
    //thay đổi trạng thái loại khách hàng trên form thông tin cá nhân
    $('#rdoPersonal2').change(function () {
        $('#listCompany2').css('display', 'none');
        $("#company_id2").empty();
    });
    $('#ckbdelivery_of_documents').change(function () {
        if ($(this).is(":checked")) {
            $('#length').val('1');
            $('#width').val('1');
            $('#height').val('1');
            $('#weight').val('1');
            $('#form-length').css('display', 'none');
            $('#form-width').css('display', 'none');
            $('#form-height').css('display', 'none');
            $('#form-weight').css('display', 'none');

        } else {
            $('#form-length').css('display', 'block');
            $('#form-width').css('display', 'block');
            $('#form-height').css('display', 'block');
            $('#form-weight').css('display', 'block');

        }
    });
    $(document).on('click', '#btn-more', function () {
        var id = $(this).data('id');
        $("#btn-more").html("Loading....");
        $.ajax({
            url: 'loadOrder',
            method: "POST",
            data: {
                id: id,
            },
            dataType: "text",
            success: function (data) {
                console.log(data);
                if (data != '') {
                    $('#remove-row').remove();
                    $('#load-data').append(data);
                } else {
                    $('#btn-more').html("No Data");
                }
            }
        });
    });
    $("#sender_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "loadInfoSender",
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (data) {
                    var resp = $.map(data, function (obj) {
                        $("#sender_name").val(obj.sender_name);
                        $("#sender_phone").val(obj.sender_phone);
                        $("#sender_address").val(obj.sender_address);
                        return obj.sender_name;
                    });
                    response(resp);
                }
            });
        },
        minLength: 1
    });
    $("#receive_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "loadInfoReceive",
                data: {
                    term: request.term
                },
                dataType: "json",
                focus: function (event, ui) {
                    $("#receive_name").val(ui.item.label);
                    return false;
                },
                success: function (data) {
                    var resp = $.map(data, function (obj) {
                        $("#receive_name").val(obj.receive_name);
                        $("#receive_phone").val(obj.receive_phone);
                        $("#receive_address").val(obj.receive_address);
                        return obj.receive_name;
                    });
                    response(resp);
                }
            });
        },
        minLength: 1
    });
});
