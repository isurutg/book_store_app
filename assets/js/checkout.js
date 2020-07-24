import $ from 'jquery';

$(function () {
    const baseUrl = "http://localhost:8000"
    let couponCode = '';

    // disable cart function in invoice
    $(document).ready(function () {
        $("#shopping-cart").css("pointer-events", "none");
        getInvoice();
    });

    // add coupon code and recalculate invoice
    $('#invoice-container').on('click', '#coupon-code-button', function () {
        couponCode = $("#coupon-code").val();
        if (couponCode.trim()) {
            getInvoice();
        }
    });

    // invoice calculation
    function getInvoice() {
        const cart = JSON.parse(localStorage.getItem('cart'));
        const coupon = couponCode;
        $.ajax({
            url: baseUrl + '/invoice',
            method: "POST",
            data: {
                cart,
                coupon
            },
            success: function (data) {
                $('#invoice-container').html(data);
            }
        });
    }
});

