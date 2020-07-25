/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

require('popper.js');
require('bootstrap');

$(function () {
    const baseUrl = "http://localhost:8001"

    // load cart at the start from data in localstorage
    $(document).ready(function () {
        let cart = [];
        if (localStorage.getItem('cart')) {
            cart = JSON.parse(localStorage.getItem('cart'));
        }
        renderCart(cart)
    });

    // render cart ajax
    function renderCart(cartdata) {
        const cart = cartdata ?? []
        $.ajax({
            url: baseUrl + '/cart',
            method: "POST",
            data: {cart},
            success: function (data) {
                $('#shopping-cart').html(data);
            },
            error: function () {
                localStorage.clear();
            }
        });
    }
});
