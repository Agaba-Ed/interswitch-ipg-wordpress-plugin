<?php
if (!defined('ABSPATH')) {
    exit;
}

$order_id = get_query_var('order_pay_ipg');
$order = wc_get_order($order_id);
$checkout_data = get_post_meta($order_id, '_interswitch_checkout_data', true);
?>

<div class="interswitch-payment-form">
    <script>
        const checkoutData = <?php echo json_encode($checkout_data); ?>;

        function checkout(jsonData) {
            const checkoutForm = document.createElement("form");
            checkoutForm.style.display = "none";
            checkoutForm.method = "POST";
            checkoutForm.action = "https://gatewaybackend.quickteller.co.ke/ipg-backend/api/checkout";

            for (const key in jsonData) {
                const formField = document.createElement("input");
                formField.name = key;
                formField.value = jsonData[key];
                checkoutForm.appendChild(formField);
            }

            document.body.appendChild(checkoutForm);
            checkoutForm.submit();
            document.body.removeChild(checkoutForm);
        }

        function payNow() {
            checkout(checkoutData);
        }

        // Auto-submit the form
        document.addEventListener("DOMContentLoaded", payNow);
    </script>
</div> 