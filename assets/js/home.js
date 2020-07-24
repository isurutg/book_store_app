import $ from 'jquery';

$(function () {
    const baseUrl = "http://localhost:8000"

    $('#search').click(function () {
        search();
    });

    $('#category').change(function () {
        search();
    });

    // search book from given criteria
    function search() {
        const category = $('#category').val();
        const text = $('#search-text').val();
        $.ajax({
            url: baseUrl,
            method: 'POST',
            data: {
                category,
                text
            },
            success: function (data) {
                $('#books-list').html(data);
                disableItemsInCart()
            }
        });
    }

    // cart events and functions
    // add to cart
    $('#books-list').on('click', '#add-to-cart', function () {
        const bookId = $(this).data('book-id');
        addToCart(bookId);
    });

    // remove from cart
    $('#shopping-cart').on('click', '.remove-cart', function () {
        const bookId = $(this).data('book-id');
        removeFromCart(bookId);
    });

    // add to cart function
    function addToCart(bookId) {
        let cart = [];
        let itemExist = false;
        if (localStorage.getItem('cart')) {
            cart = JSON.parse(localStorage.getItem('cart'));
        }
        cart.push({bookId});
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(cart);
    }

    // remove from cart function
    function removeFromCart(bookId) {
        let allItems = JSON.parse(localStorage.getItem('cart'));
        let newCart = allItems.filter(cart => cart.bookId !== bookId);
        localStorage.setItem('cart', JSON.stringify(newCart));
        renderCart(newCart);
    }

    // generate cart from current cart values
    function renderCart(cartdata) {
        const cart = cartdata ?? []
        $.ajax({
            url: baseUrl + '/cart',
            method: "POST",
            data: {cart},
            success: function (data) {
                $('#shopping-cart').html(data);
            }
        });
    }
});

