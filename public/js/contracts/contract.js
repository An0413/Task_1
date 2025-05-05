$(document).ready(function () {


    let token = $('meta[name="csrf-token"]').attr('content');


    $('.confirm').on('click', function () {
        let confirm_val = $(this).data('confirm');
        let tr = $(this).parents('tr');
        let td = $(this).parents('td');
        let request_confirm = $.ajax({
            url: '/admin/contract_request_confirm',
            type: "POST",
            data: {
                _token: token,
               confirm_val:confirm_val,
            },
        });
        request_confirm.done(function (msg){
            $(tr).removeClass('unread');
            $(td).empty();
            $(td).next().empty();

        })
    })
    $('.reject').on('click', function () {
        let tr = $(this).parents('tr');
        let td = $(this).parents('td');
        let reject_val = $(this).data('reject');
        let request_reject = $.ajax({
            url: '/admin/contract_request_cansel',
            type: "POST",
            data: {
                _token: token,
                reject_val:reject_val,
            },
        });
        request_reject.done(function (msg){
            $(tr).removeClass('unread');
            $(tr).addClass('deleted');
            $(td).empty();
            $(td).prev().empty();

        })
    })


});


