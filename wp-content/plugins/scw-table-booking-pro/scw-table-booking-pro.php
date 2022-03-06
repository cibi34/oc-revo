<?php

/**
 * Plugin Name: Revolution Nachtpalast - Tischreservierung
 * Plugin URI: https://www.octo-code.de
 * Description: table booking - online restaurant reservation system
 * Version: 1.6.2
 * Author: octo/code TEAM
 * Author URI: https://www.octo-code.de
 * License: GPLv2 or later
 */

// WP FORMS VARIABLES
$wpf_id_name = 1;
$wpf_id_mail = 2;
$wpf_id_table = 3;
$wpf_id_date = 4;
$wpf_id_phone = 11;
$wpf_id_notes = 12;
$wpf_id_num_ppl = 13;
$wpf_id_booking_id = 5;
$wpf_id_order_id = 6;
$wpf_id_cancel_button = 7;
$wpf_id_event_post_id = 14;
$wpf_id_vodka_amount = 15;
$wpf_id_sum = 16;
$wpf_id_birthday = 17;
$wpf_id_street = 27;
$wpf_id_plz = 28;
$wpf_id_city = 29;


define('SCWATBWSR_URL', plugin_dir_url(__FILE__));

function scwatbwsr_boot_session()
{
    if (session_status() == PHP_SESSION_NONE)
        session_start();
}

add_action('wp_loaded', 'scwatbwsr_boot_session');

register_activation_hook(__FILE__, 'scwatbwsr_install');
global $wnm_db_version;
$wnm_db_version = "1.0";

function scwatbwsr_install()
{
    global $wpdb;
    global $wnm_db_version;
    $charset_collate = $wpdb->get_charset_collate();

    $roomsTB = $wpdb->prefix . 'scwatbwsr_rooms';
    $typesTB = $wpdb->prefix . 'scwatbwsr_types';
    $pricesTB = $wpdb->prefix . 'scwatbwsr_prices';
    $tablesTB = $wpdb->prefix . 'scwatbwsr_tables';
    $productsTb = $wpdb->prefix . 'scwatbwsr_products';
    $ordersTB = $wpdb->prefix . 'scwatbwsr_orders';
    $bookedTB = $wpdb->prefix . 'scwatbwsr_bookedseats';

    $roomsSql = "CREATE TABLE $roomsTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomname` varchar(255) DEFAULT NULL,
		`roomcolor` varchar(255) DEFAULT NULL,
		`roombg` varchar(255) DEFAULT NULL,
		`width` varchar(255) DEFAULT NULL,
		`height` varchar(255) DEFAULT NULL,
		`tbbookedcolor` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";

    $typesSql = "CREATE TABLE $typesTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` varchar(255) DEFAULT NULL,
		`name` varchar(255) DEFAULT NULL,
		`tbbg` varchar(255) DEFAULT NULL,
		`tbshape` varchar(255) DEFAULT NULL,
		`tbrecwidth` varchar(255) DEFAULT NULL,
		`tbrecheight` varchar(255) DEFAULT NULL,
		`tbcirwidth` varchar(255) DEFAULT NULL,
		`maxppl` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";

    $priceSql = "CREATE TABLE $pricesTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`typeid` int(11) DEFAULT NULL,
		`price` varchar(255) DEFAULT NULL,
		`type` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";

    $tablesSql = "CREATE TABLE $tablesTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` int(11) DEFAULT NULL,
		`label` varchar(255) DEFAULT NULL,
		`type` int(11) DEFAULT NULL,
		`tleft` varchar(255) DEFAULT NULL,
		`ttop` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";

    $productsSql = "CREATE TABLE $productsTb (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` int(11) DEFAULT NULL,
		`proid` int(11) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";

    $ordersSql = "CREATE TABLE $ordersTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`productId` varchar(255) DEFAULT NULL,
		`seats` varchar(255) DEFAULT NULL,
		`name` varchar(255) DEFAULT NULL,
		`email` varchar(255) DEFAULT NULL,
		`phone` varchar(255) DEFAULT NULL,
		`birthday` varchar(255) DEFAULT NULL,
		`street` varchar(255) DEFAULT NULL,
		`plz` varchar(255) DEFAULT NULL,
		`city` varchar(255) DEFAULT NULL,
		`note` varchar(255) DEFAULT NULL,
		`numberPersons` varchar(255) DEFAULT NULL,
		`listDrinks` varchar(255) DEFAULT NULL,
		`total` varchar(255) DEFAULT NULL,
		`orderId` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";

    $bookedSql = "CREATE TABLE $bookedTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` int(11) DEFAULT NULL,
		`tb` varchar(255) DEFAULT NULL,
		`proid` int(11) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($roomsSql);
    dbDelta($typesSql);
    dbDelta($priceSql);
    dbDelta($tablesSql);
    dbDelta($productsSql);
    dbDelta($ordersSql);
    dbDelta($bookedSql);

    add_option("wnm_db_version", $wnm_db_version);
}

add_action('admin_menu', 'scwatbwsr_admin_menu');
function scwatbwsr_admin_menu()
{
    add_menu_page(
        'Reservierungen',
        'Reservierungen',
        'manage_options',
        'scwatbwsr-table-booking',
        'scwatbwsr_options_page'
    );
}

function scwatbwsr_options_page()
{
    ?>
    <form action='options.php' method='post'>
        <h2><?php echo esc_html__("Tisch-Reservierungs-Management", "scwatbwsr-translate") ?></h2>
        <?php
        settings_fields('pluginSCWTBWSRPage');
        do_settings_sections('pluginSCWTBWSRPage');
        submit_button();
        ?>
    </form>
    <?php
}

add_action('admin_init', 'scwatbwsr_settings_init');
function scwatbwsr_settings_init()
{
    register_setting('pluginSCWTBWSRPage', 'scwatbwsr_settings');
    add_settings_section(
        'smartcms_pluginPage_section',
        '',
        '',
        'pluginSCWTBWSRPage'
    );
    add_settings_field(
        '',
        '',
        'scwatbwsr_parameters',
        'pluginSCWTBWSRPage',
        'smartcms_pluginPage_section'
    );
}

function scwatbwsr_parameters()
{
    $options = get_option('scwatbwsr_settings');
    global $wpdb;

    wp_enqueue_script('jquery');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');

    wp_register_style('font-awesome', SCWATBWSR_URL . 'css/font-awesome.css');
    wp_enqueue_style('font-awesome');

    wp_register_script('datetimepicker', SCWATBWSR_URL . 'datetimepicker/jquery.datetimepicker.full.min.js');
    wp_enqueue_script('datetimepicker');
    wp_register_style('datetimepicker', SCWATBWSR_URL . 'datetimepicker/jquery.datetimepicker.css');
    wp_enqueue_style('datetimepicker');

    wp_register_script('jquery-ui', 'https://code.jquery.com/ui/1.9.2/jquery-ui.js');
    wp_enqueue_script('jquery-ui');

    wp_register_script('scwatbwsr-adminscript', SCWATBWSR_URL . 'js/admin.js');
    wp_enqueue_script('scwatbwsr-adminscript');
    wp_register_style('scwatbwsr-admincss', SCWATBWSR_URL . 'css/admin.css?v=1.0');
    wp_enqueue_style('scwatbwsr-admincss');

    include('templates/backend-content-template.php');

}

add_action('add_meta_boxes', 'scwatbwsr_add_tab_admin_product', 10, 2);
function scwatbwsr_add_tab_admin_product()
{
    global $wp_meta_boxes;

    $wp_meta_boxes['product']['normal']['core']['scwatbwsr']['title'] = esc_html__("Table Booking PRO", "scwatbwsr-translate");
    $wp_meta_boxes['product']['normal']['core']['scwatbwsr']['args'] = "";
    $wp_meta_boxes['product']['normal']['core']['scwatbwsr']['id'] = "scwatbwsr";
    $wp_meta_boxes['product']['normal']['core']['scwatbwsr']['callback'] = "scwatbwsr_add_tab_admin_product_display";
}

function scwatbwsr_add_tab_admin_product_display()
{
    global $wpdb;
    $postId = $_GET['post'];

    if ($postId) {
        wp_register_script('scwatbwsr-productscript', SCWATBWSR_URL . 'js/product.js');
        wp_enqueue_script('scwatbwsr-productscript');
        wp_register_style('scwatbwsr-productcss', SCWATBWSR_URL . 'css/product.css');
        wp_enqueue_style('scwatbwsr-productcss');

        $roomsTb = $wpdb->prefix . 'scwatbwsr_rooms';
        $getRoomsSql = $wpdb->prepare("SELECT * from {$roomsTb} where %d", 1);
        $rooms = $wpdb->get_results($getRoomsSql);

        $productsTb = $wpdb->prefix . 'scwatbwsr_products';
        $getProductsSql = $wpdb->prepare("SELECT * from {$productsTb} where proid=%d", $postId);
        $proInfo = $wpdb->get_results($getProductsSql);
        if (isset($proInfo[0]->roomid)) $currentId = $proInfo[0]->roomid;
        else $currentId = 0;

        $roomname = "";
        ?>
        <div class="scwatbwsr_content">
            <input type="hidden" class="scwatbwsr_proid" value="<?php echo esc_attr($postId) ?>">
            <div class="scwatbwsr_select">
                <select class="scwatbwsr_select_profile">
                    <option value="">-- <?php echo esc_html__("Select a Room", "scwatbwsr-translate") ?> --</option>
                    <?php
                    if ($rooms) {
                        foreach ($rooms as $room) {
                            if ($room->id == $proInfo[0]->roomid) $roomname = $room->roomname;
                            ?>
                            <option <?php if ($room->id == $currentId) echo "selected" ?>
                            value="<?php echo esc_attr($room->id) ?>"><?php echo esc_attr($room->roomname) ?></option><?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="scwatbwsr_roomname"><?php echo esc_attr($roomname) ?></div>
            <div class="scwatbwsr_booked">

            </div>
        </div>
        <?php
    }
}


// wordpress post
add_action('add_meta_boxes', 'scwatbwsr_add_tab_admin_post', 10, 2);
function scwatbwsr_add_tab_admin_post($post_type, $post)
{
    global $wp_meta_boxes;
    $wp_meta_boxes['events']['normal']['core']['scwatbwsr']['title'] = "SCW Table Booking";
    $wp_meta_boxes['events']['normal']['core']['scwatbwsr']['args'] = "";
    $wp_meta_boxes['events']['normal']['core']['scwatbwsr']['id'] = "scwatbwsr";
    $wp_meta_boxes['events']['normal']['core']['scwatbwsr']['callback'] = "scwatbwsr_add_tab_admin_post_display";
}

function scwatbwsr_add_tab_admin_post_display()
{
    global $wpdb;
    $postId = $_GET['post'];

    if ($postId && get_post_type($postId) == "events") {
        wp_register_script('scwatbwsr-productscript', SCWATBWSR_URL . 'js/product.js');
        wp_enqueue_script('scwatbwsr-productscript');
        wp_register_style('scwatbwsr-productcss', SCWATBWSR_URL . 'css/product.css');
        wp_enqueue_style('scwatbwsr-productcss');

        $roomsTb = $wpdb->prefix . 'scwatbwsr_rooms';
        $getRoomsSql = $wpdb->prepare("SELECT * from {$roomsTb} where %d", 1);
        $rooms = $wpdb->get_results($getRoomsSql);

        $productsTb = $wpdb->prefix . 'scwatbwsr_products';
        $getProductsSql = $wpdb->prepare("SELECT * from {$productsTb} where proid=%d", $postId);
        $proInfo = $wpdb->get_results($getProductsSql);
        if (isset($proInfo[0]->roomid)) $currentId = $proInfo[0]->roomid;
        else $currentId = 0;

        $roomname = "";
        ?>
        <div class="scwatbwsr_content">
            <input type="hidden" class="scwatbwsr_proid" value="<?php echo esc_attr($postId) ?>">
            <div class="scwatbwsr_select">
                <select class="scwatbwsr_select_profile">
                    <option value="">-- <?php echo esc_html__("Select a Room", "scwatbwsr-translate") ?> --</option>
                    <?php
                    if ($rooms) {
                        foreach ($rooms as $room) {
                            if ($room->id == $proInfo[0]->roomid) $roomname = $room->roomname;
                            ?>
                            <option <?php if ($room->id == $currentId) echo "selected" ?>
                            value="<?php echo esc_attr($room->id) ?>"><?php echo esc_attr($room->roomname) ?></option><?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="scwatbwsr_roomname"><?php echo esc_attr($roomname) ?></div>
            <div class="scwatbwsr_booked">

            </div>
        </div>
        <?php
    }
}

add_filter('elementor/frontend/the_content', 'scwatbwsr_content');
function scwatbwsr_content($content)
{
    global $wpdb;
    global $post;
    $proId = $post->ID;

    $currencyS = "€";

    $tableRooms = $wpdb->prefix . 'scwatbwsr_rooms';
    $tableProducts = $wpdb->prefix . 'scwatbwsr_products';
    $tableTypes = $wpdb->prefix . 'scwatbwsr_types';
    $tableSchedules = $wpdb->prefix . 'scwatbwsr_schedules';
    $pricesTb = $wpdb->prefix . 'scwatbwsr_prices';
    $tablesTb = $wpdb->prefix . 'scwatbwsr_tables';
    $ordersTb = $wpdb->prefix . 'scwatbwsr_orders';
    $bookedTB = $wpdb->prefix . 'scwatbwsr_bookedseats';

    $getRoomSql = $wpdb->prepare("SELECT * from {$tableProducts} where proid=%d", $proId);
    $room = $wpdb->get_results($getRoomSql);

    if (get_post_type($proId) == "events" && $room && !is_admin()) {
        ob_start();

        $roomid = $room[0]->roomid;

        wp_register_script('datetimepicker', SCWATBWSR_URL . 'datetimepicker/jquery.datetimepicker.full.min.js');
        wp_enqueue_script('datetimepicker');
        wp_register_style('datetimepicker', SCWATBWSR_URL . 'datetimepicker/jquery.datetimepicker.css');
        wp_enqueue_style('datetimepicker');

        wp_register_script('panzoom', 'https://cdn.jsdelivr.net/npm/@panzoom/panzoom/dist/panzoom.min.js');
        wp_enqueue_script('panzoom');

        wp_register_script('scwatbwsr-script-frontend', SCWATBWSR_URL . 'js/front.js');
        wp_enqueue_script('scwatbwsr-script-frontend');
        wp_register_style('scwatbwsr-style-frontend', SCWATBWSR_URL . 'css/front.css?v=1.1');
        wp_enqueue_style('scwatbwsr-style-frontend');



        include("templates/frontend-content-template.php");

        $string = ob_get_contents();
        ob_end_clean();
        $content .= $string;
    }
    return $content;
}


// CUSTOM

function getValueById(int $id, array $array)
{
    $value = "";
    foreach ($array as $index => $json) {
        if ($json['id'] == $id) {
            $value = $json['value'];
        }
    }
    return $value;
}

/**
 * Fires after all field validation and formatting data.
 *
 * @link  https://wpforms.com/developers/wpforms_process_filter/
 *
 * @param array $fields Sanitized entry field values/properties.
 * @param array $entry Original $_POST global.
 * @param array $form_data Form data and settings.
 *
 * @return array
 */

function wpf_dev_process_filter($fields, $entry, $form_data)
{

    // #octo id's von Table Booking Form
    // Erstellt hash (orderid) und fügt sie in die Form
    global $wpdb,$wpf_id_date, $wpf_id_name, $wpf_id_table, $wpf_id_order_id, $wpf_id_cancel_button;
    $name = getValueById($wpf_id_name, $fields);
    $table = getValueById($wpf_id_table, $fields);
    $date = getValueById($wpf_id_date, $fields);

    $data = $name . $date . $table;
    $order_id = hash("sha256", $data);

    $url = get_home_url() . '/cancelbooking.php?orderid=' . $order_id;
    $button = "<a href='$url'>Buchung stornieren</a>";

    foreach ($fields as $index => $field) {
        // add hash to fields
        if (! empty( $field['id'] ) && $field['id'] == $wpf_id_order_id) {
            $fields[$index]['value'] = $order_id;
        }
        // add cancel button to fields
        if (! empty( $field['id'] ) && $field['id'] == $wpf_id_cancel_button) {
            $fields[$index]['value'] = $button;
        }
    }

    return $fields;
}

add_filter('wpforms_process_filter', 'wpf_dev_process_filter', 20, 3);


/**
 * Action that fires during form entry processing after initial field validation.
 *
 * @link   https://wpforms.com/developers/wpforms_process/
 *
 * @param array $fields Sanitized entry field. values/properties.
 * @param array $entry Original $_POST global.
 * @param array $form_data Form data and settings.
 *
 */

function wpf_dev_process($fields, $entry, $form_data)
{
    // #octo id's von Table Booking Form
    // schreibt Werte aus Form in Datenbank
    global $wpf_id_name, $wpf_id_mail, $wpf_id_table,$wpf_id_date,$wpf_id_phone, $wpf_id_notes, $wpf_id_num_ppl,$wpf_id_order_id,$wpf_id_birthday,$wpf_id_street,$wpf_id_plz,$wpf_id_city;
    $name = getValueById($wpf_id_name, $fields);
    $table = getValueById($wpf_id_table, $fields);
    $date = getValueById($wpf_id_date, $fields);
    $email = getValueById($wpf_id_mail, $fields);
    $order_id = getValueById($wpf_id_order_id, $fields);
    $phone = getValueById($wpf_id_phone, $fields);
    $note = getValueById($wpf_id_notes, $fields);
    $birthday = getValueById($wpf_id_birthday, $fields);
    $street = getValueById($wpf_id_street, $fields);
    $plz = getValueById($wpf_id_plz, $fields);
    $city = getValueById($wpf_id_city, $fields);
    $num_ppl = getValueById($wpf_id_num_ppl, $fields);


    global $wpdb,$wpforms;

    //check whether entry already exists
    $ordersTB = $wpdb->prefix . 'scwatbwsr_orders';
    $orders_sql = $wpdb->prepare("SELECT * from {$ordersTB} where productId=%d and seats=%s", $entry['post_id'], $table);
    $orders = $wpdb->get_results($orders_sql);

    $bookedseatsTB = $wpdb->prefix . 'scwatbwsr_bookedseats';
    $bookedseats_sql = $wpdb->prepare("SELECT * from {$bookedseatsTB} where proid=%d and tb=%s", $entry['post_id'], $table);
    $bookedseats = $wpdb->get_results($bookedseats_sql);

    if(count($orders) == 0 && count($bookedseats)==0) {
        $wpdb->query($wpdb->prepare(
            "INSERT INTO $ordersTB (`productId`, `seats`, `name`, `email`, `phone`, `note`, `total`,`birthday`,`street`,`plz`,`city`,`numberPersons`,`listDrinks`,`orderId`)
	VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            $entry['post_id'],
            $table,
            $name,
            $email,
            $phone,
            $note,
            "",
            $birthday,
            $street,
            $plz,
            $city,
            $birthday,
            $birthday,
            $num_ppl,
            " ",
            $order_id
        ));
    } else {
        error_log(json_encode(count($orders)));
        error_log(json_encode(count($bookedseats)));
        error_log(json_encode($form_data));
        $wpforms()->process->errors[ $form_data['id'] ] [ '4' ] = "Some Error occured";
    }
}

add_action('wpforms_process', 'wpf_dev_process', 10, 4);

/**
 * Filter applies to entry fields before a form notification email is sent.
 *
 * @link  https://wpforms.com/developers/wpforms_entry_email_data/
 *
 * @param array $fields Sanitized entry field values/properties.
 * @param array $entry Original $_POST global.
 * @param array $form_data Form data and settings.
 *
 * @return array
 */

function wpf_dev_entry_email_data($fields, $entry, $form_data)
{

    global $wpdb, $wpf_id_order_id, $wpf_id_booking_id;

    $order_id = getValueById($wpf_id_order_id, $fields);

    $table_name = $wpdb->prefix . 'scwatbwsr_orders';
    $query = $wpdb->prepare("SELECT id from {$table_name} where orderId=%s", $order_id);
    $id_array = $wpdb->get_results($query);
    $id = $id_array[0]->id;

    foreach ($fields as $index => $json) {
        if ($json['id'] == $wpf_id_booking_id) {
            $fields[$index]['value'] = $id;
        }
    }

    return $fields;
}

add_filter('wpforms_entry_email_data', 'wpf_dev_entry_email_data', 10, 3);



// Add action hook only if action=download_csv
if ( isset($_GET['action'] ) && $_GET['action'] == 'download_csv' )  {
    // Handle CSV Export
    add_action( 'admin_init', 'csv_export' );
}

function csv_export()
{
// Check for current user privileges
    if (!current_user_can('manage_options')) {
        return false;
    }

// Check if we are in WP-Admin
    if (!is_admin()) {
        return false;
    }

// Nonce Check
    $nonce = isset($_GET['_wpnonce']) ? $_GET['_wpnonce'] : '';
    if (!wp_verify_nonce($nonce, 'download_csv')) {
        die('Security check error');
    }


    ob_start();

    $domain = $_SERVER['SERVER_NAME'];
    $filename = 'orders-' . $domain . '-' . time() . '.csv';

    $header_row = array(
        'ProductId',
        'Name',
        'Tisch',
        'E-Mail',
        'Telefon',
        'Geburtstag',
        'Straße',
        'PLZ',
        'Ort',
        'Notiz',
        'AnzahlPersonen',
        //'ListeDrinks',
        //'Summe',
        'Hash'
    );

    $data_rows = array();
    global $wpdb;

    $ordersTB = $wpdb->prefix . 'scwatbwsr_orders';

    // Event
    $eventid = isset($_GET['eventid']) ? $_GET['eventid'] : '';
    if ($eventid == "all") {
        $sql = "SELECT * from {$ordersTB}";
        $orders = $wpdb->get_results($sql);
    } else {
        $sql = $wpdb->prepare("SELECT * from {$ordersTB} where productId=%s", $eventid);
        $orders = $wpdb->get_results($sql);
    }


    foreach ($orders as $order) {
        $row = array(
            $order->productId,
            $order->name,
            $order->seats,
            $order->email,
            $order->phone,
            $order->birthday,
            $order->street,
            $order->plz,
            $order->city,
            $order->note,
            $order->numberPersons,
            //$order->listDrinks,
            //$order->total,
            $order->orderId
        );
        $data_rows[] = $row;
    }
    $fh = @fopen('php://output', 'w');
    fprintf($fh, chr(0xEF) . chr(0xBB) . chr(0xBF));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Description: File Transfer');
    header('Content-type: text/csv');
    header("Content-Disposition: attachment; filename={$filename}");
    header('Expires: 0');
    header('Pragma: public');
    fputcsv($fh, $header_row, ";");
    foreach ($data_rows as $data_row) {
        fputcsv($fh, $data_row, ";");
    }
    fclose($fh);

    ob_end_flush();

    die();
}
