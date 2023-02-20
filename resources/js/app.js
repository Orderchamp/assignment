require('./bootstrap');

$(document).ready(function () {
    var passwordCheckbox = $('#has-password');
    var passwordField = $('#password-field');
    var redeemCodeBtn = $('#redeem-code-btn');

    $('.add-to-cart-btn').click(function (event) {
        event.preventDefault();

        var productId = $(this).data('product-id');

        axios.post('/cart/add-product', {productId: productId})
            .then(function (response) {
                console.log(response.data);
                alert('Product #' + response.data.cart_item.product_id + ' added to cart.');
            })
            .catch(function (error) {
                console.log(error);
                alert('Error adding product to cart.');
            });
    });

    redeemCodeBtn.click(function (event) {
        event.preventDefault();

        var inputField = $('#discount_code');
        var discountCode = inputField.val();
        var form = $(this).closest('form');
        var hiddenInput = $('#discount_code_hidden');

        axios.post('/discount_code/apply', {discount_code: discountCode})
            .then(function (response) {
                console.log(response.data);

                if (response.data.success === true) {
                    alert('Discount code found and will be applied to your order.');
                    inputField.attr('disabled', 'disabled');
                    redeemCodeBtn.attr('disabled', 'disabled');
                    form.append('<span style="text-align: center; padding-top: 10px;">Promo code applied!</span>');
                    hiddenInput.val(discountCode);
                } else {
                    alert('The selected discount code is invalid.');
                }

            })
            .catch(function (error) {
                console.log(error);
                alert('The selected discount code is invalid.');
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
