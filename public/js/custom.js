$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#total-price').text(calculatingPriceOrder());

    // Enter to search product
    $('#search-box').keypress(function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == '13') {
            window.location.href = '/menu/search/' + $(this).val();
        }
    });

    // Preview image when create or update
    $('#img-upload').change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);

            reader.onload = function (e) {
                $('#img-upload-tag').attr('src', reader.result);
            }
        }
    });

    // Reset price when product quantity changes
    $('.input-product-order').change(function () {
        var quantity = $(this).val();
        var price = $(this).data('price');
        var productId = $(this).data('product-id');

        $.ajax({
            url: "/order/invoiceDetail",
            type: "PUT",
            data: {
                "productId": productId,
                "quantity": quantity
            },
            success: function (data) {
                var payoutId = '#payout' + productId;
                var payout = quantity * price;

                $(payoutId).text(payout * 1000);
                $('#total-item-cart').text(data);
                $('#total-price').text(calculatingPriceOrder());
            }
        });
    });

    // Calculating total price
    function calculatingPriceOrder() {
        var totalPrice = 0;
        $('#table-order').find('tr').each(function () {
            $(this).find('td').each(function () {
                if ($(this).attr('class') === 'payout') {
                    totalPrice += parseInt($(this).text())
                }
            });
        });
        return totalPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }
});
