$(document).ready(function () {
    let ctrlDown = false,
        ctrlKey = 17,
        cmdKey = 91,
        vKey = 86,
        cKey = 67,
        spaceKey = 32;

    $(document).keydown(function (e) {
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
    }).keyup(function (e) {
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
    });

    let strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    //check admin password is correct or no.
    // $("#current_pwd").on('keyup', function () {
    //     let current_pwd = $("#current_pwd").val();
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'post',
    //         url: '/admin/check-current-password',
    //         data: {current_pwd: current_pwd},
    //         success: function (resp) {
    //             if (resp == "false") {
    //                 $("#verifyCurrentPwd").html("Current Password is incorrect");
    //             } else if (resp == "true") {
    //                 $("#verifyCurrentPwd").html("Current Password is Correct");
    //
    //             }
    //         }, error: function () {
    //             alert("Error");
    //         }
    //     })
    // });
    $("#current_pwd").on('keydown', function (e) {
        if (ctrlDown && (e.keyCode == vKey /*|| e.keyCode == cKey*/)) {
            return false;
        }
        if (e.originalEvent.keyCode == spaceKey) {
            return false;
        }
        let pwd = $(this).val();
        if (pwd.length > 7 && strongRegex.test(pwd)) {
            $("#rules_pwd").hide();
        } else {
            $("#rules_pwd").show();
        }
    });

    //Image select

    $("#image").on('change', function (e) {

        let reader = new FileReader();

        reader.onload = function (r) {
            $('#img_select').attr('src', r.target.result);
        }

        reader.readAsDataURL(e.target.files[0]);

    });
    // Paid changes

    let paid_td = '';
    $(".paid_val").on('click', function (e) {
        paid_td = $(this);
        let paid_val = $(this).text();
        let company_id = $(this).data('comp');
        $('#comp_val').val(company_id);
        $('#paid_sum').val(paid_val);
    });

    $('#send_paid_val').on('click', function () {
        let paid_val = $('#paid_sum').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        let company_id = $('#comp_val').val();
        let request = $.ajax({
            url: '/admin/change_paid_val',
            type: "POST",
            data: {
                _token: token,
                paid_val: paid_val,
                company_id: company_id,
            },
        });
        request.done(function (msg) {
            if (msg == 1) {
                $(paid_td).text(paid_val);
            }
        })
    });


    if ($('#dataTable').length) {
        $('#dataTable').DataTable();
    }


    $('.region').on('change', function () {
        let region_val = $(this).val();
        let return_type = $(this).data('type') ?? 'option';
        let token = $('meta[name="csrf-token"]').attr('content');
        let request_city = $.ajax({
            url: '/admin/city_select',
            type: "POST",
            data: {
                _token: token,
                region_val: region_val,
                return_type: return_type,
            },
        });
        request_city.done(function (msg) {
            $('.city').html(msg);
        });


        if (region_val == 1) {
            $('.city_select').text('Ընտրել վարչական շրջանը');
        } else {
            $('.city_select').text('Ընտրել քաղաքը');
        }
    });

    $('#filter_region_select').on('change', function () {
        let region_val = $(this).val();
        let cat_select_val = $('#category_inp').val();
        let prod_types_val = $('#product_type_inp').val();
        let return_type = $(this).data('type') ?? 'option';
        let token = $('meta[name="csrf-token"]').attr('content');
        let page = $('#page_val').val();
        let user = $('#user').val();
        let request_city = $.ajax({
            url: '/admin/city_select_by_product',
            type: "POST",
            data: {
                _token: token,
                region_val: region_val,
                page: page,
                user: user,
                return_type: return_type,
                cat_select_val: cat_select_val,
                prod_types_val: prod_types_val,
            },
        });
        request_city.done(function (msg) {
            $('.city').html(msg);
        });

        if (region_val == 1) {
            $('.city_select').text('Ընտրել վարչական շրջանը');
        } else {
            $('.city_select').text('Ընտրել քաղաքը');
        }
    });

    $('.category_prod').on('change', function () {
        let category_val = $(this).val();
        let token = $('meta[name="csrf-token"]').attr('content');
        let request = $.ajax({
            url: '/admin/category_prod_types',
            type: "POST",
            data: {
                _token: token,
                category_val: category_val,
            },
        });
        request.done(function (msg) {
            $('.prod_type').html(msg);
        })
    });
    $("#catalog_toggle").click(function () {
        $("#catalog_hide").toggle();
        $(".product_img_size").toggleClass('col-md-4 col-md-3');
        $(".col_change").toggleClass('col-lg-9 col-lg-12', 'col-md-8 col-md-12', 'col-sm-8 col-sm-12');

    });

    let comp = $("#user_select");
    if (comp.val() == 2) {
        $("#shops").hide();
        $(".shop").hide();
    }

    $("#user_select").on("change", function () {
        if ($(this).val() == 2) {
            $("#shops").hide();
            $(".shop").hide();
        } else {
            $("#shops").show();
            $(".shop").show();
        }
    });

    $('.notific').on('click', function (e) {
        let title = $(this).find('h6').text();
        let text = $(this).find('.message').text();
        let not_id = $(this).data('value');

        $('.modal_h').text(title);
        $('.modal_m').html(text);

        if ($(this).data('status') == 0) {
            $(this).data('status', 1);
            let not_div = $(this);
            let token = $('meta[name="csrf-token"]').attr('content');
            let requset = $.ajax({
                type: 'POST',
                url: '/change_notifiaction_status',
                data: {
                    _token: token,
                    notification: not_id
                }
            });
            requset.done(function (msg) {
                let not_title = $(not_div).find('.not_title');
                $(not_title).html( $(not_title).html() + ' <span class="checkmark">&#10003;\n' +
                    '                                        <span class="second_mark">&#10003;</span>\n' +
                    '                                    </span>');

                $('.not_num').text($('.not_num').text() - 1);
                if ($('.not_num').text() == 0) {
                    $('.not_num').hide();
                }
            });
        }
    });

    $(document).ready(function (){
        let token = $('meta[name="csrf-token"]').attr('content');

        $('.shop_select').on("change", function (){
            let shops = $(this).find(':selected').val();
            let request = $.ajax({
                url:"/admin/notification/find_shop_admin",
                type: "POST",
                data: {
                    _token:token,
                    shops: shops
                },
            })
            request.done(function (msg){
                $('.shop_admin_select').html(msg);
            })
        })
    })

});



