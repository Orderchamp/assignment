require('./bootstrap');

$(document).ready(function () {
    var passwordCheckbox = $('#has-password');
    var passwordField = $('#password-field');

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

    passwordField.hide();

    passwordCheckbox.on('change', function () {
        if ($(this).is(':checked')) {
            passwordField.show();
        } else {
            passwordField.hide();
        }
    });
});
