$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr('content');

    $("#companies").on("change", function () {
        let company = $(this).find(":selected").val();
        let request = $.ajax({
            url: "/admin/product/comp_shop_list",
            type: "POST",
            data: {
                _token: token,
                company: company,
            },
        })
        request.done(function (msg) {
            $('#shops').html(msg);
            $('#shops').change();
        })
    })


});
