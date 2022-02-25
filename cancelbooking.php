<?php

include_once 'wp-load.php';


global $wpdb;

if (isset($_GET['orderid'])) {
    $ordersTB = 'wp_scwatbwsr_orders';

    $orderid = $_GET['orderid'];
    echo $orderid;

    $getdtSql = $wpdb->query($wpdb->prepare("DELETE FROM $ordersTB where orderId=%s", $orderid));

} else {
    // Fallback behaviour goes here
}