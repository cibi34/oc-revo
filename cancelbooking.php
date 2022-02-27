<?php

include_once 'wp-load.php';

global $wpdb;

if (isset($_GET['orderid'])) {
    $ordersTB = 'wp_scwatbwsr_orders';
    $orderid = $_GET['orderid'];
    $getdtSql = $wpdb->query($wpdb->prepare("DELETE FROM $ordersTB where orderId=%s", $orderid));
    echo "Stornierung erfolgreich";
} else {
    // Fallback behaviour goes here
    echo "Buchung konnte nicht gefunden werden. Bitte kontaktiere uns per Mail.";
}