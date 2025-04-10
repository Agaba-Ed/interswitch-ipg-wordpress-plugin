<?php
class WC_Interswitch_Response_Handler {
    public function handle_response() {
        $order_id = $_GET['orderId'] ?? '';
        $transaction_reference = $_GET['transactionReference'] ?? '';
        $status = $_GET['status'] ?? '';

        if (!$order_id || !$transaction_reference) {
            wp_die('Invalid response from payment gateway', 'Payment Error');
        }

        $order = wc_get_order($order_id);
        if (!$order) {
            wp_die('Order not found', 'Payment Error');
        }

        if ($status === 'successful') {
            $order->payment_complete($transaction_reference);
            $order->add_order_note('Payment completed via Interswitch. Transaction Reference: ' . $transaction_reference);
            wp_redirect($order->get_checkout_order_received_url());
        } else {
            $order->update_status('failed', 'Payment failed via Interswitch. Transaction Reference: ' . $transaction_reference);
            wp_redirect($order->get_checkout_payment_url());
        }
        exit;
    }
} 