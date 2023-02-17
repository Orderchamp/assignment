require('./bootstrap');

$(document).ready(function () {
    var passwordCheckbox = $('#has-password');
    var passwordField = $('#password-field');

    $('.plus-qty-btn').click(function (event) {
        event.preventDefault();

        var qtyInput = $(this).parent().siblings('.qty-input');
        var newQty = parseInt(qtyInput.val()) + 1;
        qtyInput.val(newQty);
    });

    $('.minus-qty-btn').click(function (event) {
        event.preventDefault();

        var qtyInput = $(this).parent().siblings('.qty-input');
        var newQty = parseInt(qtyInput.val()) - 1;
        if (newQty < 1) {
            newQty = 1;
        }
        qtyInput.val(newQty);
    });

    $('.add-to-cart-btn').click(function (event) {
        event.preventDefault();

        var productId = $(this).data('product-id');
        var qty = $(this).siblings('.d-flex').find('.qty-input').val();
        axios.post('/cart/add-product', {productId: productId, qty: qty})
            .then(function (response) {
                console.log(response.data);
                alert('Product #' + response.data.cart_item.product_id + ' added to cart.');
            })
            .catch(function (error) {
                console.log(error);
                alert('Error adding product to cart.');
            });
    });

    passwordField.hide();

    passwordCheckbox.on('change', function () {
        if ($(this).is(':checked')) {
            passwordField.show();
        } else {
            passwordField.hide();
        }
    });
});
