<?php
/**
 * Plugin Name: Advance Table Booking PRO with Seat Reservation for WooCommerce
 * Plugin URI: http://smartcmsmarket.net/
 * Description: table booking - online restaurant reservation system
 * Version: 1.6
 * Author: SmartCms Team
 * Author URI: http://smartcmsmarket.net/
 * License: GPLv2 or later
*/

// WP FORMS VARIABLES
$wpf_id_name = 2;
$wpf_id_mail = 3;
$wpf_id_date = 10;
$wpf_id_table = 6;
$wpf_id_booking_id = 17;
$wpf_id_order_id = 11;
$wpf_id_cancel_button = 16;


define ( 'SCWATBWSR_URL', plugin_dir_url(__FILE__));

function scwatbwsr_boot_session(){
	if (session_status() == PHP_SESSION_NONE)
		session_start();
}
add_action('wp_loaded', 'scwatbwsr_boot_session');

register_activation_hook(__FILE__, 'scwatbwsr_install');
global $wnm_db_version;
$wnm_db_version = "1.0";

function scwatbwsr_install(){
	global $wpdb;
	global $wnm_db_version;
	$charset_collate = $wpdb->get_charset_collate();
	
	$roomsTB = $wpdb->prefix . 'scwatbwsr_rooms';
	$typesTB = $wpdb->prefix . 'scwatbwsr_types';
	$schedulesTB = $wpdb->prefix . 'scwatbwsr_schedules';
	$dailyschedulesTB = $wpdb->prefix . 'scwatbwsr_dailyschedules';
	$dailytimesTB = $wpdb->prefix . 'scwatbwsr_dailytimes';
	$pricesTB = $wpdb->prefix . 'scwatbwsr_prices';
	$tablesTB = $wpdb->prefix . 'scwatbwsr_tables';
	$seatsTB = $wpdb->prefix . 'scwatbwsr_seats';
	$productsTb = $wpdb->prefix . 'scwatbwsr_products';
	$ordersTB = $wpdb->prefix . '$ordersTB';
	$bookedTB = $wpdb->prefix . 'scwatbwsr_bookedseats';
	
	$roomsSql = "CREATE TABLE $roomsTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomname` varchar(255) DEFAULT NULL,
		`roomcolor` varchar(255) DEFAULT NULL,
		`roombg` varchar(255) DEFAULT NULL,
		`width` varchar(255) DEFAULT NULL,
		`height` varchar(255) DEFAULT NULL,
		`tbbookedcolor` varchar(255) DEFAULT NULL,
		`seatbookedcolor` varchar(255) DEFAULT NULL,
		`compulsory` varchar(255) DEFAULT NULL,
		`bookingtime` int(11) DEFAULT NULL,
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
		`seatbg` varchar(255) DEFAULT NULL,
		`seatshape` varchar(255) DEFAULT NULL,
		`seatwidth` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";
	
	$schedulesSql = "CREATE TABLE $schedulesTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` int(11) DEFAULT NULL,
		`schedule` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";
	
	$dailyschedulesSql = "CREATE TABLE $dailyschedulesTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` int(11) DEFAULT NULL,
		`daily` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";
	
	$dailytimesSql = "CREATE TABLE $dailytimesTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` int(11) DEFAULT NULL,
		`time` varchar(255) DEFAULT NULL,
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
		`seats` varchar(255) DEFAULT NULL,
		`type` int(11) DEFAULT NULL,
		`tleft` varchar(255) DEFAULT NULL,
		`ttop` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";
	
	$seatsSql = "CREATE TABLE $seatsTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`tbid` int(11) DEFAULT NULL,
		`seat` varchar(255) DEFAULT NULL,
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
		`orderId` varchar(255) DEFAULT NULL,
		`productId` varchar(255) DEFAULT NULL,
		`schedule` varchar(255) DEFAULT NULL,
		`seats` varchar(255) DEFAULT NULL,
		`name` varchar(255) DEFAULT NULL,
		`address` varchar(255) DEFAULT NULL,
		`email` varchar(255) DEFAULT NULL,
		`phone` varchar(255) DEFAULT NULL,
		`note` varchar(255) DEFAULT NULL,
		`total` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";
	
	$bookedSql = "CREATE TABLE $bookedTB (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`roomid` int(11) DEFAULT NULL,
		`tb` varchar(255) DEFAULT NULL,
		`seat` varchar(255) DEFAULT NULL,
		`proid` int(11) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate;";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($roomsSql);
	dbDelta($typesSql);
	dbDelta($schedulesSql);
	dbDelta($dailyschedulesSql);
	dbDelta($dailytimesSql);
	dbDelta($priceSql);
	dbDelta($tablesSql);
	dbDelta($seatsSql);
	dbDelta($productsSql);
	dbDelta($ordersSql);
	dbDelta($bookedSql);
	
	add_option("wnm_db_version", $wnm_db_version);
}

add_action( 'admin_menu', 'scwatbwsr_admin_menu' );
function scwatbwsr_admin_menu(){
    add_menu_page(
        'SCW Table Booking',
        'SCW Table Booking',
        'manage_options',
        'scwatbwsr-table-booking',
        'scwatbwsr_options_page'
    );
}
function scwatbwsr_options_page(){
	?>
	<form action='options.php' method='post'>
		<h2><?php echo esc_html__("Table Booking Management", "scwatbwsr-translate") ?></h2>
		<?php
		settings_fields( 'pluginSCWTBWSRPage' );
		do_settings_sections( 'pluginSCWTBWSRPage' );
		submit_button();
		?>
	</form>
	<?php
}

add_action( 'admin_init', 'scwatbwsr_settings_init' );
function scwatbwsr_settings_init() {
	register_setting( 'pluginSCWTBWSRPage', 'scwatbwsr_settings' );
	add_settings_section(
		'smartcms_pluginPage_section', '', '', 'pluginSCWTBWSRPage'
	);
	add_settings_field( 
		'','',
		'scwatbwsr_parameters', 
		'pluginSCWTBWSRPage', 
		'smartcms_pluginPage_section' 
	);
}
function scwatbwsr_parameters(){
	$options = get_option( 'scwatbwsr_settings' );
	global $wpdb;
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	
	wp_register_style('font-awesome', SCWATBWSR_URL .'css/font-awesome.css');
	wp_enqueue_style('font-awesome');
	
	wp_register_script('datetimepicker', SCWATBWSR_URL .'datetimepicker/jquery.datetimepicker.full.min.js');
	wp_enqueue_script('datetimepicker');
	wp_register_style('datetimepicker', SCWATBWSR_URL .'datetimepicker/jquery.datetimepicker.css');
	wp_enqueue_style('datetimepicker');
	
	wp_register_script('jquery-ui', 'https://code.jquery.com/ui/1.9.2/jquery-ui.js');
	wp_enqueue_script('jquery-ui');
	
	wp_register_script('scwatbwsr-adminscript', SCWATBWSR_URL .'js/admin.js');
	wp_enqueue_script('scwatbwsr-adminscript');
	wp_register_style('scwatbwsr-admincss', SCWATBWSR_URL .'css/admin.css?v=1.0');
	wp_enqueue_style('scwatbwsr-admincss');
	
	$roomsTb = $wpdb->prefix . 'scwatbwsr_rooms';
	$getRoomsSql = $wpdb->prepare("SELECT * from {$roomsTb} where %d", 1);
	$rooms = $wpdb->get_results($getRoomsSql);
	
	$typesTB = $wpdb->prefix . 'scwatbwsr_types';
	$tableSchedules = $wpdb->prefix . 'scwatbwsr_schedules';
	$tableDailySchedules = $wpdb->prefix . 'scwatbwsr_dailyschedules';
	$tableDailyTimes = $wpdb->prefix . 'scwatbwsr_dailytimes';
	$pricesTb = $wpdb->prefix . 'scwatbwsr_prices';
	$tablesTb = $wpdb->prefix . 'scwatbwsr_tables';
	$seatsTb = $wpdb->prefix . 'scwatbwsr_seats';
	$ordersTb = $wpdb->prefix . 'scwatbwsr_orders';
	$proTb = $wpdb->prefix . 'scwatbwsr_products';
	$bookedTB = $wpdb->prefix . 'scwatbwsr_bookedseats';
	?>
	<div class="wrap">
		<div class="scwatbwsr_content">
			<input type="hidden" value="<?php echo get_option('date_format') ?>" class="scw_date_format">
			<div class="scwatbwsr_add">
				<div class="scwatbwsr_add_head"><?php echo esc_html__("Add a Room", "scwatbwsr-translate") ?></div>
				<input class="scwatbwsr_add_name" placeholder="<?php echo esc_html__("Room Name", "scwatbwsr-translate") ?>" type="text">
				<span class="scwatbwsr_add_button"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
			</div>
			<div class="scwatbwsr_rooms">
			<?php
				if($rooms){
					foreach($rooms as $room){
						$getTypesSql = $wpdb->prepare("SELECT * from {$typesTB} where roomid=%d", $room->id);
						$types = $wpdb->get_results($getTypesSql);
						
						$getScheSql = $wpdb->prepare("SELECT * from {$tableSchedules} where roomid=%d", $room->id);
						$schedules = $wpdb->get_results($getScheSql);
						
						$getdailiesSql = $wpdb->prepare("SELECT * from {$tableDailySchedules} where roomid=%d", $room->id);
						$dailies = $wpdb->get_results($getdailiesSql);
						if(isset($dailies[0]->daily)) $dailies = explode(",", $dailies[0]->daily);
						else $dailies = array();
						
						$getTimesSql = $wpdb->prepare("SELECT * from {$tableDailyTimes} where roomid=%d", $room->id);
						$times = $wpdb->get_results($getTimesSql);
						
						$getTablesSql = $wpdb->prepare("SELECT * from {$tablesTb} where roomid=%d", $room->id);
						$tables = $wpdb->get_results($getTablesSql);
						
						$getProSql = $wpdb->prepare("SELECT * from {$proTb} where roomid=%d", $room->id);
						$pro = $wpdb->get_results($getProSql);
						?>
						<div class="scwatbwsr_room">
							<input class="scwatbwsr_room_id" value="<?php echo esc_attr($room->id) ?>" type="hidden">
							<span class="scwatbwsr_room_head">
								<i class="fa fa-angle-double-right" aria-hidden="true"></i>
								<span class="scwatbwsr_room_head_name"><?php echo esc_attr($room->roomname) ?></span>
								<span class="scwatbwsr_room_head_delete"><i class="fa fa-trash" aria-hidden="true"></i></span>
								<span class="scwatbwsr_room_head_copy"><i class="fa fa-files-o" aria-hidden="true"></i></span>
							</span>
							<div class="scwatbwsr_room_content">
								<div class="scwatbwsr_room_content_tabs">
									<input class="scwatbwsr_room_content_tabs_input" id="scwatbwsr_tab1<?php echo esc_attr($room->id) ?>" type="radio" name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
									<label class="scwatbwsr_room_content_tabs_label active" for="scwatbwsr_tab1<?php echo esc_attr($room->id) ?>"><i class="fa fa-cog"></i><span><?php echo esc_html__("Basic Setting", "scwatbwsr-translate") ?></span></label>

									<input class="scwatbwsr_room_content_tabs_input" id="scwatbwsr_tab2<?php echo esc_attr($room->id) ?>" type="radio" name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
									<label class="scwatbwsr_room_content_tabs_label" for="scwatbwsr_tab2<?php echo esc_attr($room->id) ?>"><i class="fa fa-codepen"></i><span><?php echo esc_html__("Table Types", "scwatbwsr-translate") ?></span></label>

									<input class="scwatbwsr_room_content_tabs_input" id="scwatbwsr_tab3<?php echo esc_attr($room->id) ?>" type="radio" name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
									<label class="scwatbwsr_room_content_tabs_label" for="scwatbwsr_tab3<?php echo esc_attr($room->id) ?>"><i class="fa fa-calendar"></i><span><?php echo esc_html__("Schedules", "scwatbwsr-translate") ?></span></label>

									<input class="scwatbwsr_room_content_tabs_input" id="scwatbwsr_tab4<?php echo esc_attr($room->id) ?>" type="radio" name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
									<label class="scwatbwsr_room_content_tabs_label" for="scwatbwsr_tab4<?php echo esc_attr($room->id) ?>"><i class="fa fa-usd"></i><span><?php echo esc_html__("Price", "scwatbwsr-translate") ?></span></label>

									<input class="scwatbwsr_room_content_tabs_input" id="scwatbwsr_tab5<?php echo esc_attr($room->id) ?>" type="radio" name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
									<label class="scwatbwsr_room_content_tabs_label" for="scwatbwsr_tab5<?php echo esc_attr($room->id) ?>"><i class="fa fa-th"></i><span><?php echo esc_html__("Tables", "scwatbwsr-translate") ?></span></label>

									<input class="scwatbwsr_room_content_tabs_input" id="scwatbwsr_tab6<?php echo esc_attr($room->id) ?>" type="radio" name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
									<label class="scwatbwsr_room_content_tabs_label" for="scwatbwsr_tab6<?php echo esc_attr($room->id) ?>"><i class="fa fa-braille"></i><span><?php echo esc_html__("Mapping", "scwatbwsr-translate") ?></span></label>

									<input class="scwatbwsr_room_content_tabs_input" id="scwatbwsr_tab7<?php echo esc_attr($room->id) ?>" type="radio" name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
									<label class="scwatbwsr_room_content_tabs_label" for="scwatbwsr_tab7<?php echo esc_attr($room->id) ?>"><i class="fa fa-file-text-o"></i><span><?php echo esc_html__("Booked Seats", "scwatbwsr-translate") ?></span></label>

									<section id="scwatbwsr_content1<?php echo esc_attr($room->id) ?>" class="tab-content active">
										<span class="scwatbwsr_room_content_editname">
											<span class="scwatbwsr_room_content_editname_head"><?php echo esc_html__("Edit Name", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_room_content_editname_name" value="<?php echo esc_attr($room->roomname) ?>" type="text">
										</span>
										<span class="scwatbwsr_roombg">
											<span class="scwatbwsr_roombg_label"><?php echo esc_html__("Room Background", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_roombg_con">
												<input type="color" id="scwatbwsr_roombg_con_color" class="scwatbwsr_roombg_con_color" value="<?php echo esc_attr("#000000") ?>">
												<label for="scwatbwsr_roombg_con_color" class="scwatbwsr_roombg_con_color_button"><?php echo esc_html__("Pick Color", "scwatbwsr-translate") ?></label>
												<span class="scwatbwsr_roombg_con_or"><?php echo esc_html__("OR", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_roombg_con_bgpreview">
													<?php
														if($room->roombg){
															?><img src="<?php echo esc_attr($room->roombg) ?>"><?php
														}
													?>
												</span>
												<input class="scwatbwsr_roombg_con_image" value="<?php echo esc_attr($room->roombg) ?>" type="text">
												<span class="scwatbwsr_roombg_con_upload scwatbwsr_media_upload"><?php echo esc_html__("Upload Image", "scwatbwsr-translate") ?></span>
											</span>
										</span>
										<span class="scwatbwsr_roomsize">
											<span class="scwatbwsr_roomsize_label"><?php echo esc_html__("Room Size", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_roomsize_width" placeholder="Width (px)" value="<?php echo esc_attr($room->width) ?>" type="text">
											<input class="scwatbwsr_roomsize_height" placeholder="Height (px)" value="<?php echo esc_attr($room->height) ?>" type="text">
										</span>
										<span class="scwatbwsr_bookedpr">
											<span class="scwatbwsr_bookedpr_label"><?php echo esc_html__("Table Booked Color", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_bookedpr_tbcolor" value="<?php echo esc_attr($room->tbbookedcolor) ?>" type="color">
											<span class="scwatbwsr_bookedpr_label"><?php echo esc_html__("Seat Booked Color", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_bookedpr_seatcolor" value="<?php echo esc_attr($room->seatbookedcolor) ?>" type="color">
										</span>
										<span class="scwatbwsr_bktime">
											<span class="scwatbwsr_bktime_label"><?php echo esc_html__("Booking Time (in minutes - the time customers will stay)", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_bktime_ip" value="<?php echo esc_attr($room->bookingtime) ?>" type="text">
										</span>
										<span class="scwatbwsr_compulsory">
											<input class="scwatbwsr_compulsory_ip" <?php if($room->compulsory == "yes") echo "checked" ?> type="checkbox">
											<span class="scwatbwsr_compulsory_label"><?php echo esc_html__("Compulsory choose seats and tables before add product to cart", "scwatbwsr-translate") ?></span>
										</span>
										<span class="scwatbwsr_basesetting_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
									</section>
									
									<section id="scwatbwsr_content2<?php echo esc_attr($room->id) ?>" class="tab-content">
										<span class="scwatbwsr_roomtype_add">
											<span class="scwatbwsr_roomtype_add_head"><?php echo esc_html__("Add a type", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_roomtype_add_name" placeholder="Name of type" type="text">
											<span class="scwatbwsr_roomtype_add_table"><?php echo esc_html__("Table", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_roomtype_add_tbcolor">
													<span class="scwatbwsr_roomtype_add_tbcolor_head"><?php echo esc_html__("Background Color", "scwatbwsr-translate") ?></span>
													<input type="color" class="scwatbwsr_roomtype_add_tbcolor_input" id="scwatbwsr_roomtype_add_tbcolor_input">
													<label class="scwatbwsr_roomtype_add_tbcolor_button" for="scwatbwsr_roomtype_add_tbcolor_input"><?php echo esc_html__("Pick Color", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_roomtype_add_tbshape">
													<span class="scwatbwsr_roomtype_add_tbshape_head"><?php echo esc_html__("Shape", "scwatbwsr-translate") ?></span>
													<span class="scwatbwsr_roomtype_add_tbshape_con">
														<label><?php echo esc_html__("Rectangular", "scwatbwsr-translate") ?></label>
														<input type="radio" class="scwatbwsr_roomtype_add_tbshape_rec" name="scwatbwsr_roomtype_add_tbshape" value="rectangular">
														<input type="text" class="scwatbwsr_roomtype_add_tbshape_rec_width" placeholder="Width (px)">
														<input type="text" class="scwatbwsr_roomtype_add_tbshape_rec_height" placeholder="Height (px)">
													</span>
													<span class="scwatbwsr_roomtype_add_tbshape_con">
														<label><?php echo esc_html__("Circle", "scwatbwsr-translate") ?></label>
														<input type="radio" class="scwatbwsr_roomtype_add_tbshape_cir" name="scwatbwsr_roomtype_add_tbshape" value="circle">
														<input type="text" class="scwatbwsr_roomtype_add_tbshape_cir_width" placeholder="Width (diameter-px)">
													</span>
												</span>
											<span class="scwatbwsr_roomtype_add_seat"><?php echo esc_html__("Seat", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_roomtype_add_seatcolor">
													<span class="scwatbwsr_roomtype_add_seatcolor_head"><?php echo esc_html__("Background Color", "scwatbwsr-translate") ?></span>
													<input type="color" class="scwatbwsr_roomtype_add_seatcolor_input" id="scwatbwsr_roomtype_add_seatcolor_input">
													<label class="scwatbwsr_roomtype_add_seatcolor_button" for="scwatbwsr_roomtype_add_seatcolor_input"><?php echo esc_html__("Pick Color", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_roomtype_add_seatshape">
													<span class="scwatbwsr_roomtype_add_seatshape_head"><?php echo esc_html__("Shape", "scwatbwsr-translate") ?></span>
													<span class="scwatbwsr_roomtype_add_seatshape_con">
														<label><?php echo esc_html__("Rectangular", "scwatbwsr-translate") ?></label>
														<input type="radio" class="scwatbwsr_roomtype_add_seatshape_rec" name="scwatbwsr_roomtype_add_seatshape" value="rectangular">
													</span>
													<span class="scwatbwsr_roomtype_add_seatshape_con">
														<label><?php echo esc_html__("Circle", "scwatbwsr-translate") ?></label>
														<input type="radio" class="scwatbwsr_roomtype_add_seatshape_cir" name="scwatbwsr_roomtype_add_seatshape" value="circle">
													</span>
												</span>
												<input type="text" class="scwatbwsr_roomtype_add_seat_size" placeholder="Width (px)">
											<span class="scwatbwsr_roomtype_add_button"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_roomtype_add_reload"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i class="fa fa-refresh" aria-hidden="true"></i></span>
										</span>
										<span class="scwatbwsr_roomtype_items">
											<span class="scwatbwsr_roomtype_items_head"><?php echo esc_html__("Types", "scwatbwsr-translate") ?></span>
											<?php
												if($types){
													foreach($types as $type){
														?>
														<span class="scwatbwsr_roomtype_item">
															<input value="<?php echo esc_attr($type->id) ?>" type="hidden" class="scwatbwsr_roomtype_item_id">
															<span class="scwatbwsr_roomtype_item_name">
																<span><?php echo esc_attr($type->name) ?></span><br>
																<span class="scwatbwsr_roomtype_item_name_shape"><?php echo esc_html__("Table: ", "scwatbwsr-translate").esc_attr($type->tbshape) ?></span><br>
																<span class="scwatbwsr_roomtype_item_name_shape"><?php echo esc_html__("Seat: ", "scwatbwsr-translate").esc_attr($type->seatshape) ?></span>
															</span>
															<span class="scwatbwsr_roomtype_item_tbbg">
																<label><?php echo esc_html__("Table Color", "scwatbwsr-translate") ?></label>
																<input type="color" class="scwatbwsr_roomtype_item_tbbg_input" value="<?php echo esc_attr($type->tbbg) ?>">
															</span>
															<span class="scwatbwsr_roomtype_item_tbsize <?php echo esc_attr($type->tbshape) ?>">
																<label><?php echo esc_html__("Table Size", "scwatbwsr-translate") ?></label>
																<input type="text" class="scwatbwsr_roomtype_item_tbsize_recwidth" value="<?php echo esc_attr($type->tbrecwidth) ?>">
																<input type="text" class="scwatbwsr_roomtype_item_tbsize_recheight" value="<?php echo esc_attr($type->tbrecheight) ?>">
																<input type="text" class="scwatbwsr_roomtype_item_tbsize_cirwidth" value="<?php echo esc_attr($type->tbcirwidth) ?>">
															</span>
															<span class="scwatbwsr_roomtype_item_seatbg">
																<label><?php echo esc_html__("Seat Color", "scwatbwsr-translate") ?></label>
																<input type="color" class="scwatbwsr_roomtype_item_seatbg_input" value="<?php echo esc_attr($type->seatbg) ?>">
															</span>
															<span class="scwatbwsr_roomtype_item_seatsize <?php echo esc_attr($type->seatshape) ?>">
																<label><?php echo esc_html__("Seat Size", "scwatbwsr-translate") ?></label>
																<input type="text" class="scwatbwsr_roomtype_item_seatsize_width" value="<?php echo esc_attr($type->seatwidth) ?>">
															</span>
															<span class="scwatbwsr_roomtype_item_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
															<span class="scwatbwsr_roomtype_item_del"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
														</span>
														<?php
													}
												}
											?>
										</span>
									</section>
									
									<section id="scwatbwsr_content3<?php echo esc_attr($room->id) ?>" class="tab-content">
										<span class="scwatbwsr_schedules_spec">
											<span class="scwatbwsr_schedules_spec_head"><?php echo esc_html__("Separate Schedules", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_schedules_spec_add">
												<input class="scwatbwsr_schedules_spec_add_input" type="text">
												<span class="scwatbwsr_schedules_spec_button"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_schedules_spec_add_reload"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i class="fa fa-refresh" aria-hidden="true"></i></span>
											</span>
											<span class="scwatbwsr_schedules_spec_list">
												<?php
													if($schedules){
														foreach($schedules as $schedule){
															?>
															<span class="scwatbwsr_schedules_spec_list_item">
																<input type="hidden" value="<?php echo esc_attr($schedule->id) ?>" class="scwatbwsr_schedules_spec_list_item_id">
																<input class="scwatbwsr_schedules_spec_list_item_schedule" value="<?php echo esc_attr($schedule->schedule) ?>" type="text">
																<span class="scwatbwsr_schedules_spec_list_item_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
																<span class="scwatbwsr_schedules_spec_list_item_delete"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
															</span>
															<?php
														}
													}
												?>
											</span>
										</span>
										<span class="scwatbwsr_schedules_or"><?php echo esc_html__("OR", "scwatbwsr-translate") ?></span>
										<span class="scwatbwsr_schedules_right">
											<span class="scwatbwsr_schedules_right_head"><?php echo esc_html__("Daily Schedules", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_daily_schedules">
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if(in_array("monday", $dailies)) echo "checked='checked'" ?> value="monday" type="checkbox" class="scwatbwsr_daily_schedules_monday" id="scwatbwsr_daily_schedules_monday">
													<label for="scwatbwsr_daily_schedules_monday"><?php echo esc_html__("Monday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if(in_array("tuesday", $dailies)) echo "checked='checked'" ?> value="tuesday" type="checkbox" class="scwatbwsr_daily_schedules_tuesday" id="scwatbwsr_daily_schedules_tuesday">
													<label for="scwatbwsr_daily_schedules_tuesday"><?php echo esc_html__("Tuesday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if(in_array("wednesday", $dailies)) echo "checked='checked'" ?> value="wednesday" type="checkbox" class="scwatbwsr_daily_schedules_wednesday" id="scwatbwsr_daily_schedules_wednesday">
													<label for="scwatbwsr_daily_schedules_wednesday"><?php echo esc_html__("Wednesday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if(in_array("thursday", $dailies)) echo "checked='checked'" ?> value="thursday" type="checkbox" class="scwatbwsr_daily_schedules_thursday" id="scwatbwsr_daily_schedules_thursday">
													<label for="scwatbwsr_daily_schedules_thursday"><?php echo esc_html__("Thursday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if(in_array("friday", $dailies)) echo "checked='checked'" ?> value="friday" type="checkbox" class="scwatbwsr_daily_schedules_friday" id="scwatbwsr_daily_schedules_friday">
													<label for="scwatbwsr_daily_schedules_friday"><?php echo esc_html__("Friday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if(in_array("saturday", $dailies)) echo "checked='checked'" ?> value="saturday" type="checkbox" class="scwatbwsr_daily_schedules_saturday" id="scwatbwsr_daily_schedules_saturday">
													<label for="scwatbwsr_daily_schedules_saturday"><?php echo esc_html__("Saturday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if(in_array("sunday", $dailies)) echo "checked='checked'" ?> value="sunday" type="checkbox" class="scwatbwsr_daily_schedules_sunday" id="scwatbwsr_daily_schedules_sunday">
													<label for="scwatbwsr_daily_schedules_sunday"><?php echo esc_html__("Sunday", "scwatbwsr-translate") ?></label>
												</span>
											</span>
											<span class="scwatbwsr_daily_schedules_times">
												<span class="scwatbwsr_daily_schedules_times_add">
													<input class="scwatbwsr_daily_schedules_times_add_input" placeholder="daily time" type="text">
													<span class="scwatbwsr_daily_schedules_times_add_button"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
													<span class="scwatbwsr_daily_schedules_times_refresh_button"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i class="fa fa-refresh" aria-hidden="true"></i></span>
												</span>
												<span class="scwatbwsr_daily_schedules_times_list">
													<?php
														if($times){
															foreach($times as $time){
																?>
																<span class="scwatbwsr_daily_schedules_times_list_item">
																	<input class="scwatbwsr_daily_schedules_times_list_item_id" type="hidden" value="<?php echo esc_attr($time->id) ?>">
																	<input class="scwatbwsr_daily_schedules_times_list_item_input" placeholder="daily time" value="<?php echo esc_attr($time->time) ?>" type="text">
																	<span class="scwatbwsr_daily_schedules_times_list_item_button"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
																	<span class="scwatbwsr_daily_schedules_times_list_item_delete"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
																</span>
																<?php
															}
														}
													?>
												</span>
											</span>
										</span>
									</section>
									
									<section id="scwatbwsr_content4<?php echo esc_attr($room->id) ?>" class="tab-content">
										<span class="scwatbwsr_prices">
											<?php
												if($types){
													foreach($types as $type){
														$getPriceSql = $wpdb->prepare("SELECT * from {$pricesTb} where typeid=%d", $type->id);
														$price = $wpdb->get_results($getPriceSql);
														
														if(isset($price[0]->price)) $pri = $price[0]->price;
														else $pri = 0;
														
														if(isset($price[0]->type)) $itype = $price[0]->type;
														else $itype = "seat";
														?>
														<span class="scwatbwsr_prices_item">
															<span class="scwatbwsr_prices_item_head"><?php echo esc_attr($type->name)." ".esc_html__("price", "scwatbwsr-translate") ?></span>
															<input class="scwatbwsr_prices_item_typeid" type="hidden" value="<?php echo esc_attr($type->id) ?>">
															<input class="scwatbwsr_prices_item_price" type="text" value="<?php echo esc_attr($pri) ?>">
															<select class="scwatbwsr_prices_item_type">
																<option <?php if($itype=="seat") echo "selected" ?> value="seat"><?php echo esc_html__("Per Seat", "scwatbwsr-translate") ?></option>
																<option <?php if($itype=="table") echo "selected" ?> value="table"><?php echo esc_html__("Per Table", "scwatbwsr-translate") ?></option>
																<option <?php if($itype=="time") echo "selected" ?> value="time"><?php echo esc_html__("One Time", "scwatbwsr-translate") ?></option>
															</select>
														</span>
														<?php
													}
												}
											?>
										</span>
										<span class="scwatbwsr_prices_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
									</section>
									
									<section id="scwatbwsr_content5<?php echo esc_attr($room->id) ?>" class="tab-content">
										<span class="scwatbwsr_tables_add">
											<span class="scwatbwsr_tables_add_head"><?php echo esc_html__("Add a table", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_tables_add_label" type="text" placeholder="Label">
											<input class="scwatbwsr_tables_add_seats" type="text" placeholder="Label of seats">
											<select class="scwatbwsr_tables_add_type">
												<option value="">-- <?php echo esc_html__("Choose a type", "scwatbwsr-translate") ?> --</option>
												<?php
												if($types){
													foreach($types as $type){
														?>
														<option value="<?php echo esc_attr($type->id) ?>"><?php echo esc_attr($type->name) ?></option>
														<?php
													}
												}
												?>
											</select>
											<span class="scwatbwsr_tables_add_button"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_tables_add_reload"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i class="fa fa-refresh" aria-hidden="true"></i></span>
										</span>
										<span class="scwatbwsr_tables_list">
											<span class="scwatbwsr_tables_list_head"><?php echo esc_html__("Tables", "scwatbwsr-translate") ?></span>
											<?php
												if($tables){
													foreach($tables as $table){
														?>
														<span class="scwatbwsr_tables_list_item">
															<input type="hidden" value="<?php echo esc_attr($table->id) ?>" class="scwatbwsr_tables_list_item_id">
															<span class="scwatbwsr_tables_list_item_label"><?php echo esc_attr($table->label) ?></span>
															<input type="text" class="scwatbwsr_tables_list_item_seats" value="<?php echo esc_attr($table->seats) ?>">
															<select class="scwatbwsr_tables_list_item_type">
																<option value="">-- <?php echo esc_html__("Choose a type", "scwatbwsr-translate") ?> --</option>
																<?php
																if($types){
																	foreach($types as $type){
																		?>
																		<option <?php if($table->type == $type->id) echo "selected" ?> value="<?php echo esc_attr($type->id) ?>"><?php echo esc_attr($type->name) ?></option>
																		<?php
																	}
																}
																?>
															</select>
															<span class="scwatbwsr_tables_list_item_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
															<span class="scwatbwsr_tables_list_item_del"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
														</span>
														<?php
													}
												}
											?>
										</span>
									</section>
									
									<section id="scwatbwsr_content6<?php echo esc_attr($room->id) ?>" class="tab-content">
										<span class="scwatbwsr_mapping_listpreview">
											<span class="scwatbwsr_mapping_preview" style="width: <?php echo esc_attr($room->width) ?>px; height: <?php echo esc_attr($room->height) ?>px">
												<?php
													if($room->roombg){
														?><img class="scwatbwsr_mapping_preview_image" src="<?php echo esc_attr($room->roombg) ?>"><?php
													}else{
														?><span style="background: <?php echo esc_attr($room->roomcolor) ?>" class="scwatbwsr_mapping_preview_color"><?php echo esc_attr($room->roomcolor) ?></span><?php
													}
												?>
												<span class="scwatbwsr_mapping_preview_tables">
												<?php
													if($tables){
														foreach($tables as $table){
															$getType = $wpdb->prepare("SELECT * from {$typesTB} where id=%d", $table->type);
															$type = $wpdb->get_results($getType);
						
															if($table->tleft) $tleft = $table->tleft;
															else $tleft = 0;
															
															if($table->ttop) $ttop = $table->ttop;
															else $ttop = 0;
															
															$padding = $type[0]->seatwidth + 2;
															
															$style = 'background: '.$type[0]->tbbg .' none repeat scroll 0% 0% padding-box content-box;left: '.$tleft.'px;top: '.$ttop.'px;padding: '.$padding.'px;';
															if($type[0]->tbshape == "rectangular")
																$style .= 'width: '.$type[0]->tbrecwidth .'px; height: '.$type[0]->tbrecheight .'px;line-height: '.($type[0]->tbrecheight + ($type[0]->seatwidth + 2)*2).'px';
															else
																$style .= 'width: '.$type[0]->tbcirwidth .'px; height: '.$type[0]->tbcirwidth .'px;line-height: '.($type[0]->tbcirwidth + ($type[0]->seatwidth + 2)*2).'px;border-radius: '.$type[0]->tbcirwidth .'px';
															
															$seatstyle = 'background: '.$type[0]->seatbg .';';
															if($type[0]->seatshape == "rectangular")
																$seatstyle .= 'width: '.$type[0]->seatwidth .'px; height: '.$type[0]->seatwidth .'px;line-height: '.$type[0]->seatwidth .'px;';
															else
																$seatstyle .= 'width: '.$type[0]->seatwidth .'px; height: '.$type[0]->seatwidth .'px;line-height: '.$type[0]->seatwidth .'px;border-radius: '.$type[0]->seatwidth .'px;';
															
															$seats = explode(",", $table->seats);
															?>
															<span class="scwatbwsr_mapping_table" style="<?php echo esc_attr($style) ?>">
																<span class="scwatbwsr_mapping_table_seats" style="width: calc(100% + <?php echo esc_attr(($type[0]->seatwidth+2)*2) ?>px);
																margin-left: -<?php echo esc_attr($type[0]->seatwidth+2) ?>px;
																height: calc(100% + <?php echo esc_attr(($type[0]->seatwidth+2)*2) ?>px);
																margin-top: -<?php echo esc_attr($type[0]->seatwidth+2) ?>px;
																">
																<?php
																	if($seats){
																		foreach($seats as $seat){
																			$getSeatDt = $wpdb->prepare("SELECT * from {$seatsTb} where tbid=%d and seat=%s", $table->id, $seat);
																			$seatdt = $wpdb->get_results($getSeatDt);
																			if(isset($seatdt[0]->tleft)) $sleft = $seatdt[0]->tleft;
																			else $sleft = 0;
																			
																			if(isset($seatdt[0]->ttop)) $stop = $seatdt[0]->ttop;
																			else $stop = 0;
																			
																			$newseatstyle = $seatstyle.'left: '.$sleft.'px; top: '.$stop.'px';
																			?><span style="<?php echo esc_attr($newseatstyle) ?>" class="scwatbwsr_mapping_table_seat"><?php echo esc_attr($seat) ?></span><?php
																		}
																	}
																?>
																</span>
																<input type="hidden" class="scwatbwsr_mapping_table_id" value="<?php echo esc_attr($table->id) ?>">
																<span class="scwatbwsr_mapping_table_label"><?php echo esc_attr($table->label) ?></span>
																<span style="margin-left: -<?php echo esc_attr($room->width) ?>px; width: <?php echo esc_attr($room->width*2) ?>px" class="topline"></span>
																<span style="margin-top:-<?php echo esc_attr($room->height) ?>px; height: <?php echo esc_attr($room->height*2) ?>px" class="rightline"></span>
																<span style="margin-left:-<?php echo esc_attr($room->width) ?>px; width: <?php echo esc_attr($room->width*2) ?>px" class="botline"></span>
																<span style="margin-top:-<?php echo esc_attr($room->height) ?>px; height: <?php echo esc_attr($room->height*2) ?>px" class="leftline"></span>
															</span>
															<?php
														}
													}
												?>
												</span>
											</span>
											<br>
											<span class="scwatbwsr_mapping_preview_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__("Save Mapping", "scwatbwsr-translate") ?></span>
										</span>
									</section>


									<section id="scwatbwsr_content7<?php echo esc_attr($room->id) ?>" class="tab-content">
                                        <?php
                                        foreach($pro as $event){
                                            $getOrdersSql = $wpdb->prepare("SELECT * from {$ordersTb} where productId=%d", $event->proid);
                                            $orders = $wpdb->get_results($getOrdersSql);
                                            ?>
                                            <div class="scwatbwsr_event" data-id="<?php echo $event->proid; ?>">
                                                <div class="scwatbwsr_event_id"> <?php echo $event->proid; ?>  </div>
                                                <span class="scwatbwsr_orders">
                                                <?php
                                                    if($orders){
                                                        foreach($orders as $order){
                                                            ?>
                                                            <span class="scwatbwsr_orders_item">
                                                                <input class="scwatbwsr_orders_item_oid" type="hidden" value="<?php echo esc_attr($order->id) ?>">
                                                                <span class="scwatbwsr_orders_item_head"><?php echo esc_html__("Order: ", "scwatbwsr-translate") ?></span>
                                                                <span class="scwatbwsr_orders_item_id">
                                                                <?php if($order->orderId){ ?>
                                                                    <a target="_blank" href="<?php echo get_site_url() ?>/wp-admin/post.php?post=<?php echo esc_attr($order->orderId) ?>&action=edit"><?php echo esc_attr($order->orderId) ?></a>
                                                                <?php }else echo "by Form" ?>
                                                                </span>
                                                                <span class="scwatbwsr_orders_item_seats"><?php echo esc_attr(str_replace(",", " ", $order->seats)) ?></span>
                                                                <span class="scwatbwsr_orders_item_schedule"><?php if($order->schedule) echo esc_attr($order->schedule) ?></span>
                                                                <?php if($order->name){ ?>
                                                                <span class="scwatbwsr_orders_item_name"><?php if($order->name) echo esc_attr($order->name) ?></span>
                                                                <?php } ?>
                                                                <?php if($order->address){ ?>
                                                                <span class="scwatbwsr_orders_item_address"><?php if($order->address) echo esc_attr($order->address) ?></span>
                                                                <?php } ?>
                                                                <?php if($order->email){ ?>
                                                                <span class="scwatbwsr_orders_item_email"><?php if($order->email) echo esc_attr($order->email) ?></span>
                                                                <?php } ?>
                                                                <?php if($order->phone){ ?>
                                                                <span class="scwatbwsr_orders_item_phone"><?php if($order->phone) echo esc_attr($order->phone) ?></span>
                                                                <?php } ?>
                                                                <?php if($order->note){ ?>
                                                                <span class="scwatbwsr_orders_item_note"><?php if($order->note) echo esc_attr($order->note) ?></span>
                                                                <?php } ?>
                                                                <?php if($order->total){ ?>
                                                                <span class="scwatbwsr_orders_item_total"><?php if($order->total) echo esc_attr("$".$order->total) ?></span>
                                                                <?php } ?>
                                                                <span class="scwatbwsr_orders_item_del"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
                                                            </span>
                                                            <?php
                                                            }
                                                        }
                                                    ?>
                                                </span>
                                                <span class="scwatbwsr_bktables">
                                                    <?php
                                                        if($tables){
                                                            foreach($tables as $table){
                                                                $seats = explode(",", $table->seats);
                                                                if($seats){
                                                                    foreach($seats as $seat){
                                                                        $getBookedSql = $wpdb->prepare("SELECT * from {$bookedTB} where roomid=%d and tb=%s and seat=%s and proid=%d", $room->id, $table->label, $seat, $event->proid);
                                                                        $bookedseat = $wpdb->get_results($getBookedSql);
                                                                        ?>
                                                                        <span class="scwatbwsr_bktables_seat">
                                                                            <span class="scwatbwsr_bktables_seat_name"><?php echo esc_attr($table->label .".".$seat) ?></span>
                                                                            <span class="scwatbwsr_bktables_seat_make">
                                                                                <label><?php echo esc_html__("Make as booked", "scwatbwsr-translate") ?></label>
                                                                                <input <?php if($bookedseat) echo "checked" ?> type="checkbox" class="scwatbwsr_bktables_seat_make_input">
                                                                            </span>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <span style="float: left;width: 100%;font-weight: bold;">--------------------------------</span>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </span>
                                            </div>
                                        <?php }
                                        ?>

									</section>
									
								</div>
							</div>
						</div>
						<?php
					}
				}
			?>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'add_meta_boxes', 'scwatbwsr_add_tab_admin_product', 10, 2 );
function scwatbwsr_add_tab_admin_product(){
	global $wp_meta_boxes;
	
	$wp_meta_boxes[ 'product' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'title' ] = esc_html__("Table Booking PRO", "scwatbwsr-translate");
	$wp_meta_boxes[ 'product' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'args' ] = "";
	$wp_meta_boxes[ 'product' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'id' ] = "scwatbwsr";
	$wp_meta_boxes[ 'product' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'callback' ] = "scwatbwsr_add_tab_admin_product_display";
}
function scwatbwsr_add_tab_admin_product_display(){
	global $wpdb;
	$postId = $_GET['post'];
	
	if($postId){
		wp_register_script('scwatbwsr-productscript', SCWATBWSR_URL .'js/product.js');
		wp_enqueue_script('scwatbwsr-productscript');
		wp_register_style('scwatbwsr-productcss', SCWATBWSR_URL .'css/product.css');
		wp_enqueue_style('scwatbwsr-productcss');
		
		$roomsTb = $wpdb->prefix . 'scwatbwsr_rooms';
		$getRoomsSql = $wpdb->prepare("SELECT * from {$roomsTb} where %d", 1);
		$rooms = $wpdb->get_results($getRoomsSql);
		
		$productsTb = $wpdb->prefix . 'scwatbwsr_products';
		$getProductsSql = $wpdb->prepare("SELECT * from {$productsTb} where proid=%d", $postId);
		$proInfo = $wpdb->get_results($getProductsSql);
		if(isset($proInfo[0]->roomid)) $currentId = $proInfo[0]->roomid;
		else $currentId = 0;
		
		$roomname = "";
		?>
		<div class="scwatbwsr_content">
			<input type="hidden" class="scwatbwsr_proid" value="<?php echo esc_attr($postId) ?>">
			<div class="scwatbwsr_select">
				<select class="scwatbwsr_select_profile">
					<option value="">-- <?php echo esc_html__("Select a Room", "scwatbwsr-translate") ?> --</option>
					<?php
						if($rooms){
							foreach($rooms as $room){
								if($room->id == $proInfo[0]->roomid) $roomname = $room->roomname;
								?><option <?php if($room->id == $currentId) echo "selected" ?> value="<?php echo esc_attr($room->id) ?>"><?php echo esc_attr($room->roomname) ?></option><?php
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

add_action('woocommerce_after_single_product', 'scwatbwsr_fontend_single');
function scwatbwsr_fontend_single(){
	global $product;
	global $wpdb;
	$proId = $product->get_id();
	$currencyS = get_woocommerce_currency_symbol();

	$tableRooms = $wpdb->prefix . 'scwatbwsr_rooms';
	$tableProducts = $wpdb->prefix . 'scwatbwsr_products';
	$tableTypes = $wpdb->prefix . 'scwatbwsr_types';
	$tableSchedules = $wpdb->prefix . 'scwatbwsr_schedules';
	$pricesTb = $wpdb->prefix . 'scwatbwsr_prices';
	$tablesTb = $wpdb->prefix . 'scwatbwsr_tables';
	$seatsTb = $wpdb->prefix . 'scwatbwsr_seats';
	$ordersTb = $wpdb->prefix . 'scwatbwsr_orders';
	$bookedTB = $wpdb->prefix . 'scwatbwsr_bookedseats';

	$getRoomSql = $wpdb->prepare("SELECT * from {$tableProducts} where proid=%d", $proId);
	$room = $wpdb->get_results($getRoomSql);

	if($room){
		$roomid = $room[0]->roomid;

		wp_register_script('datetimepicker', SCWATBWSR_URL .'datetimepicker/jquery.datetimepicker.full.min.js');
		wp_enqueue_script('datetimepicker');
		wp_register_style('datetimepicker', SCWATBWSR_URL .'datetimepicker/jquery.datetimepicker.css');
		wp_enqueue_style('datetimepicker');

		wp_register_script('panzoom', 'https://cdn.jsdelivr.net/npm/@panzoom/panzoom/dist/panzoom.min.js');
		wp_enqueue_script('panzoom');

		wp_register_script('scwatbwsr-script-frontend', SCWATBWSR_URL .'js/front.js');
		wp_enqueue_script('scwatbwsr-script-frontend');
		wp_register_style('scwatbwsr-style-frontend', SCWATBWSR_URL .'css/front.css?v=1.0');
		wp_enqueue_style('scwatbwsr-style-frontend');

		$getRoomDataSql = $wpdb->prepare("SELECT * from {$tableRooms} where id=%d", $roomid);
		$roomData = $wpdb->get_results($getRoomDataSql);

		$getTypeSql = $wpdb->prepare("SELECT * from {$tableTypes} where roomid=%d", $roomid);
		$types = $wpdb->get_results($getTypeSql);

		$getSchedulesSql = $wpdb->prepare("SELECT * from {$tableSchedules} where roomid=%d", $roomid);
		$checkSchedules = $wpdb->get_results($getSchedulesSql);

		if(isset($roomData[0]->tbbookedcolor))
			$tbbookedcolor = $roomData[0]->tbbookedcolor;
		else
			$tbbookedcolor = "#000";
		if(isset($roomData[0]->seatbookedcolor))
			$seatbookedcolor = $roomData[0]->seatbookedcolor;
		else
			$seatbookedcolor = "#000";

		$getTablesSql = $wpdb->prepare("SELECT * from {$tablesTb} where roomid=%d", $roomid);
		$tables = $wpdb->get_results($getTablesSql);

		$bookedSeats = array();
		$getOrdersSql = $wpdb->prepare("SELECT * from {$ordersTb} where productId=%d", $proId);
		$orders = $wpdb->get_results($getOrdersSql);
		if($orders){
			foreach($orders as $order){
				$oseats = explode(",", $order->seats);
				foreach($oseats as $os){
					array_push($bookedSeats, $os);
				}
			}
		}
		$getBookedSql = $wpdb->prepare("SELECT * from {$bookedTB} where roomid=%d", $roomid);
		$bookeds = $wpdb->get_results($getBookedSql);
		if($bookeds){
			foreach($bookeds as $bk){
				array_push($bookedSeats, $bk->tb .".".$bk->seat);
			}
		}
		$bookedSeats = array_unique($bookedSeats);
		?>
		<div class="scwatbwsr_content" style="display: none">
			<input type="hidden" value="<?php echo esc_attr(SCWATBWSR_URL) ?>" class="scwatbwsr_url">
			<input type="hidden" value="<?php echo esc_attr($proId) ?>" class="product_id">
			<input type="hidden" value="<?php echo esc_attr($roomid) ?>" class="profileid">
			<input type="hidden" value="<?php echo esc_attr($tbbookedcolor) ?>" class="tbbookedcolor">
			<input type="hidden" value="<?php echo esc_attr($seatbookedcolor) ?>" class="seatbookedcolor">
			<input type="hidden" value="<?php echo esc_attr($roomData[0]->compulsory) ?>" class="scw_compulsory">
			<input type="hidden" value="<?php echo esc_attr($roomData[0]->bookingtime) ?>" class="scw_bookingtime">
			<input type="hidden" value="<?php echo esc_attr(get_option('date_format')) ?>" class="scw_date_format">

			<div class="scwatbwsr_types">
				<?php
					if($types){
						foreach($types as $type){
							$getPriceSql = $wpdb->prepare("SELECT * from {$pricesTb} where typeid=%d", $type->id);
							$price = $wpdb->get_results($getPriceSql);
							?>
							<span class="scwatbwsr_types_item">
								<span class="scwatbwsr_types_item_name"><b><?php echo esc_attr($type->name) ?></b></span>
								<span class="scwatbwsr_types_item_bg" style="background: <?php echo esc_attr($type->tbbg) ?>">bg</span>
								<?php
									if($price && $price[0]->price){
										if($price[0]->type == "seat") $pricetype = esc_html__("per seat", "scwatbwsr-translate");
										elseif($price[0]->type == "table") $pricetype = esc_html__("per table", "scwatbwsr-translate");
										elseif($price[0]->type == "time") $pricetype = esc_html__("one time for all", "scwatbwsr-translate");
									?>
									<span class="scwatbwsr_types_item_price">(<?php echo esc_attr($currencyS.$price[0]->price ." ".$pricetype) ?>)</span>
								<?php } ?>
							</span>
							<?php
						}
					}
				?>
				<span class="scwatbwsr_types_item">
					<span class="scwatbwsr_types_item_name"><b><?php echo esc_html__("Booked Table", "scwatbwsr-translate") ?></b></span>
					<span class="scwatbwsr_types_item_bg" style="background: <?php echo esc_attr($tbbookedcolor) ?>">bg</span>
				</span>
			</div>

			<div class="scwatbwsr_schedules <?php if($checkSchedules){ ?>scwatbwsr_schedules_special<?php }else{ ?>scwatbwsr_schedules_daily<?php } ?>">
				<?php
				if($checkSchedules){
					?><div class="scwatbwsr_schedules_header"><?php echo esc_html__("Please choose schedule first!", "scwatbwsr-translate") ?></div><?php
					foreach($checkSchedules as $sche){
						?><span class="scwatbwsr_schedules_item"><?php echo esc_attr($sche->schedule) ?></span><?php
					}
				}else{
					$arroDay = array(0, 1, 2, 3, 4, 5, 6);
					$arrDay = array();
					$arrTime = "";

					$tableDailySchedules = $wpdb->prefix . 'scwatbwsr_dailyschedules';
					$getDSSql = $wpdb->prepare("SELECT * from {$tableDailySchedules} where roomid=%d", $roomid);
					$getDSRs = $wpdb->get_results($getDSSql);
					if(isset($getDSRs[0]->daily)) $dailies = explode(",", $getDSRs[0]->daily);
					else $dailies = array();
					if($dailies){
						foreach($dailies as $dai){
							if($dai == "monday")
								array_push($arrDay, 1);
							elseif($dai == "tuesday")
								array_push($arrDay, 2);
							elseif($dai == "wednesday")
								array_push($arrDay, 3);
							elseif($dai == "thursday")
								array_push($arrDay, 4);
							elseif($dai == "friday")
								array_push($arrDay, 5);
							elseif($dai == "saturday")
								array_push($arrDay, 6);
							elseif($dai == "sunday")
								array_push($arrDay, 0);
						}
					}
					$arrfDay = array_diff($arroDay, $arrDay);

					$tableDailyTimes = $wpdb->prefix . 'scwatbwsr_dailytimes';
					$getDTSql = $wpdb->prepare("SELECT * from {$tableDailyTimes} where roomid=%d", $roomid);
					$times = $wpdb->get_results($getDTSql);
					if($times){
						foreach($times as $time){
							if($arrTime)
								$arrTime .= ",".$time->time;
							else
								$arrTime .= $time->time;
						}
					}

					?>
					<div class="scwatbwsr_schedules_header"><?php echo esc_html__("Please choose schedule first!", "scwatbwsr-translate") ?></div>
					<input class="array_dates" type="hidden" value='<?php echo json_encode($arrfDay, 1) ?>'>
					<input class="array_times" type="hidden" value="<?php echo esc_attr($arrTime) ?>">
					<input id="scwatbwsr_schedules_picker" type="text">
					<?php
				}
				?>
			</div>

			<div class="scwatbwsr_map">
				<div class="scwatbwsr_map_head"><?php echo esc_html__("Choose your Seats", "scwatbwsr-translate") ?></div>
				<div class="scwatbwsr_map_zoom">
					<span id="scwatbwsr_map_zoom-in"><?php echo esc_html__("Zoom In", "scwatbwsr-translate") ?></span>
					<span id="scwatbwsr_map_zoom-out"><?php echo esc_html__("Zoom Out", "scwatbwsr-translate") ?></span>
					<span id="scwatbwsr_map_zoom_reset"><?php echo esc_html__("Reset", "scwatbwsr-translate") ?></span>
				</div>
				<div class="scwatbwsr_map_block">
				<div id="scwatbwsr_map_panzoom">
					<div class="scwatbwsr_map_bg" style="width: <?php echo esc_attr($roomData[0]->width) ?>px; height: <?php echo esc_attr($roomData[0]->height) ?>px">

						<?php
							if(isset($roomData[0]->roombg)){
								?><img class="scwatbwsr_map_bg_img" src="<?php echo esc_attr($roomData[0]->roombg) ?>"><?php
							}else{
								?><span class="scwatbwsr_map_bg_color" style="background: <?php echo esc_attr($roomData[0]->roomcolor) ?>">.</span><?php
							}
						?>
						<div class="scwatbwsr_map_tables">
							<?php
								if($tables){
									foreach($tables as $table){
										$getType = $wpdb->prepare("SELECT * from {$tableTypes} where id=%d", $table->type);
										$type = $wpdb->get_results($getType);

										$seats = explode(",", $table->seats);
										if($seats){
											$tmpArr = array();
											foreach($seats as $seat){
												array_push($tmpArr, $table->label .".".$seat);
											}
											$checkSame = array_intersect($bookedSeats, $tmpArr);
											if(count($seats) == count($checkSame))
												$tbcolor = $tbbookedcolor;
											else
												$tbcolor = $type[0]->tbbg;
										}else
											$tbcolor = $type[0]->tbbg;

										if($table->tleft) $tleft = $table->tleft;
										else $tleft = 0;

										if($table->ttop) $ttop = $table->ttop;
										else $ttop = 0;

										$padding = $type[0]->seatwidth + 2;

										$style = 'background: '.$tbcolor.' none repeat scroll 0% 0% padding-box content-box;left: '.$tleft.'px;top: '.$ttop.'px;padding: '.$padding.'px;';
										$labelStyle = 'top: '.($type[0]->seatwidth + 2).'px;left: '.($type[0]->seatwidth + 2).'px;';
										if($type[0]->tbshape == "rectangular"){
											$style .= 'width: '.($type[0]->tbrecwidth + ($type[0]->seatwidth + 2)*2).'px; height: '.($type[0]->tbrecheight + ($type[0]->seatwidth + 2)*2).'px;line-height: '.($type[0]->tbrecheight + ($type[0]->seatwidth + 2)*2).'px';
											$labelStyle .= 'width: '.$type[0]->tbrecwidth .'px; height: '.$type[0]->tbrecheight .'px; line-height: '.$type[0]->tbrecheight .'px';
										}else{
											$style .= 'width: '.($type[0]->tbcirwidth + ($type[0]->seatwidth + 2)*2).'px; height: '.($type[0]->tbcirwidth + ($type[0]->seatwidth + 2)*2).'px;line-height: '.($type[0]->tbcirwidth + ($type[0]->seatwidth + 2)*2).'px;border-radius: '.$type[0]->tbcirwidth .'px';
											$labelStyle .= 'width: '.$type[0]->tbcirwidth .'px; height: '.$type[0]->tbcirwidth .'px; line-height: '.$type[0]->tbcirwidth .'px;border-radius: '.$type[0]->tbcirwidth .'px';
										}

										$seatstyle = '';
										if($type[0]->seatshape == "rectangular")
											$seatstyle .= 'width: '.$type[0]->seatwidth .'px; height: '.$type[0]->seatwidth .'px;line-height: '.$type[0]->seatwidth .'px;';
										else
											$seatstyle .= 'width: '.$type[0]->seatwidth .'px; height: '.$type[0]->seatwidth .'px;line-height: '.$type[0]->seatwidth .'px;border-radius: '.$type[0]->seatwidth .'px;';

										?>
										<span id="table<?php echo esc_attr($table->label) ?>" class="scwatbwsr_map_tables_table" style="<?php echo esc_attr($style) ?>">
											<input type="hidden" class="scwatbwsr_table_readcolor" value="<?php echo esc_attr($type[0]->tbbg) ?>">
											<input type="hidden" class="scwatbwsr_seat_readcolor" value="<?php echo esc_attr($type[0]->seatbg) ?>">
											<span class="scwatbwsr_map_tables_table_seats" style="width: calc(100% + <?php echo esc_attr(($type[0]->seatwidth+2)*2) ?>px);
											margin-left: -<?php echo esc_attr($type[0]->seatwidth+2) ?>px;
											height: calc(100% + <?php echo esc_attr(($type[0]->seatwidth+2)*2) ?>px);
											margin-top: -<?php echo esc_attr($type[0]->seatwidth+2) ?>px;
											">
											<?php
												if($seats){
													foreach($seats as $seat){
														$getSeatDt = $wpdb->prepare("SELECT * from {$seatsTb} where tbid=%d and seat=%s", $table->id, $seat);
														$seatdt = $wpdb->get_results($getSeatDt);
														if(isset($seatdt[0]->tleft)) $sleft = $seatdt[0]->tleft;
														else $sleft = 0;

														if(isset($seatdt[0]->ttop)) $stop = $seatdt[0]->ttop;
														else $stop = 0;

														$newseatstyle = $seatstyle.'left: '.$sleft.'px; top: '.$stop.'px;';

														if(in_array($table->label .".".$seat, $bookedSeats))
															$newseatstyle .= 'background: '.$seatbookedcolor.';';
														else
															$newseatstyle .= 'background: '.$type[0]->seatbg .';';
														?><span id="seat<?php echo esc_attr($table->label .$seat) ?>" style="<?php echo esc_attr($newseatstyle) ?>" class="scwatbwsr_map_exclude scwatbwsr_map_tables_table_seat <?php if(in_array($table->label .".".$seat, $bookedSeats)) echo "seatbooked" ?>"><?php echo esc_attr($seat) ?></span><?php
													}
												}
											?>
											</span>
											<span style="<?php echo esc_attr($labelStyle) ?>" class="scwatbwsr_map_tables_table_label scwatbwsr_map_exclude"><?php echo esc_attr($table->label) ?></span>
										</span>
										<?php
									}
								}
							?>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

add_filter( 'woocommerce_cart_item_price', 'scwatbwsr_change_product_price_display', 10, 3 );
function scwatbwsr_change_product_price_display( $price, $product ){
	global $wpdb;

	$proId = $product["product_id"];

	$customString = "";
	if(isset($_SESSION["seats".$proId])){
		$customString .= "<br>".esc_html__("Booked Seats", "scwatbwsr-translate").": ".str_replace("@", " ", $_SESSION["seats".$proId]);
	}
	if(isset($_SESSION["schedule".$proId])){
		$customString .= "<br>";
		$customString .= esc_html__("Schedule", "scwatbwsr-translate").": ".$_SESSION["schedule".$proId];
	}
	$allowed_html = ['br' => [], 'span' => []];
	echo wp_kses($price.$customString, $allowed_html);
}

add_action( 'woocommerce_before_calculate_totals', 'scwatbwsr_add_custom_price' );
function scwatbwsr_add_custom_price( $cart_object ){
	global $wpdb;
	global $woocommerce;
	$woove = $woocommerce->version;

    if ( is_admin() && !defined('DOING_AJAX') )
        return;

	foreach ( $cart_object->get_cart() as $cart_item ) {
		if( (float)$woove < 3 ){
			$proId = $cart_item['data']->id;
			$sale_price = $cart_item['data']->price;
		}else{
			$proId = $cart_item['data']->get_id();
			$cuprice = $cart_item['data']->get_data();
			$sale_price = $cuprice["sale_price"];
			if(!$sale_price) $sale_price = $cuprice["regular_price"];
		}

		$proTb = $wpdb->prefix . 'scwatbwsr_products';
		$tablesTb = $wpdb->prefix . 'scwatbwsr_tables';
		$pricesTb = $wpdb->prefix . 'scwatbwsr_prices';

		$getRoomSql = $wpdb->prepare("SELECT * from {$proTb} where proid=%d", $proId);
		$room = $wpdb->get_results($getRoomSql);
		$roomid = $room[0]->roomid;

		$total = 0;

		if(isset($_SESSION["seats".$proId])){
			$seats = explode("@", $_SESSION["seats".$proId]);
			$pertbArr = array();
			$onetimeArr = array();

			foreach($seats as $seat){
				$checkseat = explode(".", $seat);

				$getTypeSql = $wpdb->prepare("SELECT * from {$tablesTb} where roomid=%d and label=%s", $roomid, $checkseat[0]);
				$getType = $wpdb->get_results($getTypeSql);
				$typeid = $getType[0]->type;

				$getPriceSql = $wpdb->prepare("SELECT * from {$pricesTb} where typeid=%d", $typeid);
				$getPrice = $wpdb->get_results($getPriceSql);

				if($getPrice && $getPrice[0]->price){
					if($getPrice[0]->type == "seat"){
						$total += $getPrice[0]->price;
					}elseif($getPrice[0]->type == "table"){
						$pertbArr[] = array(
							'tb'=> $checkseat[0],
							'price' => $getPrice[0]->price
						);
					}else{
						$onetimeArr[] = array(
							'tb'=> $checkseat[0],
							'price' => $getPrice[0]->price
						);
					}
				}
			}

			$pertbArr = array_map("unserialize", array_unique(array_map("serialize", $pertbArr)));
			if($pertbArr)
				$total += $pertbArr[0]["price"] * count($pertbArr);
			if($onetimeArr)
				$total += $onetimeArr[0]["price"];
		}

		if($total)
			$cart_item['data']->set_price( ((float)$total / $cart_item['quantity']) + $sale_price );
	}
}

add_filter( 'woocommerce_order_item_name', 'scwatbwsr_order_complete' , 10, 2 );
function scwatbwsr_order_complete( $link, $item ){
	global $wpdb;
	global $wp;

	$proId = $item["product_id"];
	$order_id  = absint($wp->query_vars['order-received']);

	$customString = "";
	if($proId && $order_id){
		$orderTable = $wpdb->prefix . 'scwatbwsr_orders';

		if(isset($_SESSION["seats".$proId])){
			$checkSeats = explode("@", $_SESSION["seats".$proId]);
			$insetArr = $checkSeats;
			$boughtArr = array();

			$customString .= "<br>".esc_html__("Booked Seats", "scwatbwsr-translate").": ";

			foreach($checkSeats as $ks=>$seat){
				if(isset($_SESSION["schedule".$proId]))
					$checkOrder = $wpdb->prepare("SELECT * from {$orderTable} where FIND_IN_SET(%s, seats) and productId=%d and schedule=%s", $seat, $proId, $_SESSION["schedule".$proId]);
				else
					$checkOrder = $wpdb->prepare("SELECT * from {$orderTable} where FIND_IN_SET(%s, seats) and productId=%d", $seat, $proId);
				$checkOrderRs = $wpdb->get_results($checkOrder);

				if(isset($checkOrderRs[0]->seats)){
					unset($insetArr[$ks]);
					array_push($boughtArr, $seat);
				}
			}
			if($insetArr){
				$wpdb->query($wpdb->prepare("INSERT INTO $orderTable (`productId`, `orderId`, `seats`, `schedule`)
				VALUES (%d, %s, %s, %s)",
				$proId, $order_id, implode(",", $insetArr), $_SESSION["schedule".$proId]));

				$customString .= "<br>".implode(" ", $insetArr);
			}
			if($boughtArr){
				$customString .= "<br>These seats no longer available: ".implode(" ", $boughtArr);
			}

			if(isset($_SESSION["schedule".$proId])){
				$customString .= "<br>";
				$customString .= esc_html__("Schedule", "scwatbwsr-translate").": ".$_SESSION["schedule".$proId];
			}
		}
	}

	$allowed_html = ['br' => [], 'span' => []];
	echo wp_kses($link.$customString, $allowed_html);
}

add_action( 'woocommerce_before_order_itemmeta', 'scwatbwsr_admin_edit_order', 10, 3 );
function scwatbwsr_admin_edit_order( $item_id, $item, $product ){
	global $wpdb;
	$proId = $product->get_id();
    $postId = $_GET['post'];

	$orderSeatTable = $wpdb->prefix . 'scwatbwsr_orders';
	$selectTypeSql = $wpdb->prepare("SELECT * from {$orderSeatTable} where productId=%d and orderId=%s", $proId, $postId);
	$orderSeats = $wpdb->get_results($selectTypeSql);

	if($orderSeats){
		echo "<br>";
		echo esc_html__("Booked Seats", "scwatbwsr-translate").": ".str_replace(",", " ", $orderSeats[0]->seats);

		if($orderSeats[0]->schedule)
			echo "<br>".esc_html__("Schedule", "scwatbwsr-translate").": ".$orderSeats[0]->schedule;
	}
}

function scwatbwsr_cart_updated( $removed_cart_item_key, $cart ) {
    $line_item = $cart->removed_cart_contents[ $removed_cart_item_key ];
    $product_id = $line_item[ 'product_id' ];

	unset($_SESSION["seats".$product_id]);
	unset($_SESSION["schedule".$product_id]);
};
add_action( 'woocommerce_cart_item_removed', 'scwatbwsr_cart_updated', 10, 2 );

// wordpress post
add_action( 'add_meta_boxes', 'scwatbwsr_add_tab_admin_post', 10, 2 );
function scwatbwsr_add_tab_admin_post($post_type, $post){
	global $wp_meta_boxes;
	$wp_meta_boxes[ 'events' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'title' ] = "SCW Table Booking";
	$wp_meta_boxes[ 'events' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'args' ] = "";
	$wp_meta_boxes[ 'events' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'id' ] = "scwatbwsr";
	$wp_meta_boxes[ 'events' ][ 'normal' ][ 'core' ][ 'scwatbwsr' ][ 'callback' ] = "scwatbwsr_add_tab_admin_post_display";
}
function scwatbwsr_add_tab_admin_post_display(){
	global $wpdb;
	$postId = $_GET['post'];
	
	if($postId && get_post_type($postId) == "events"){
		wp_register_script('scwatbwsr-productscript', SCWATBWSR_URL .'js/product.js');
		wp_enqueue_script('scwatbwsr-productscript');
		wp_register_style('scwatbwsr-productcss', SCWATBWSR_URL .'css/product.css');
		wp_enqueue_style('scwatbwsr-productcss');
		
		$roomsTb = $wpdb->prefix . 'scwatbwsr_rooms';
		$getRoomsSql = $wpdb->prepare("SELECT * from {$roomsTb} where %d", 1);
		$rooms = $wpdb->get_results($getRoomsSql);
		
		$productsTb = $wpdb->prefix . 'scwatbwsr_products';
		$getProductsSql = $wpdb->prepare("SELECT * from {$productsTb} where proid=%d", $postId);
		$proInfo = $wpdb->get_results($getProductsSql);
		if(isset($proInfo[0]->roomid)) $currentId = $proInfo[0]->roomid;
		else $currentId = 0;
		
		$roomname = "";
		?>
		<div class="scwatbwsr_content">
			<input type="hidden" class="scwatbwsr_proid" value="<?php echo esc_attr($postId) ?>">
			<div class="scwatbwsr_select">
				<select class="scwatbwsr_select_profile">
					<option value="">-- <?php echo esc_html__("Select a Room", "scwatbwsr-translate") ?> --</option>
					<?php
						if($rooms){
							foreach($rooms as $room){
								if($room->id == $proInfo[0]->roomid) $roomname = $room->roomname;
								?><option <?php if($room->id == $currentId) echo "selected" ?> value="<?php echo esc_attr($room->id) ?>"><?php echo esc_attr($room->roomname) ?></option><?php
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

add_filter( 'the_content', 'scwatbwsr_content' );
function scwatbwsr_content($content){
	global $wpdb;
	global $post;
	$proId = $post->ID;
	
	$currencyS = "$";
	
	$tableRooms = $wpdb->prefix . 'scwatbwsr_rooms';
	$tableProducts = $wpdb->prefix . 'scwatbwsr_products';
	$tableTypes = $wpdb->prefix . 'scwatbwsr_types';
	$tableSchedules = $wpdb->prefix . 'scwatbwsr_schedules';
	$pricesTb = $wpdb->prefix . 'scwatbwsr_prices';
	$tablesTb = $wpdb->prefix . 'scwatbwsr_tables';
	$seatsTb = $wpdb->prefix . 'scwatbwsr_seats';
	$ordersTb = $wpdb->prefix . 'scwatbwsr_orders';
	$bookedTB = $wpdb->prefix . 'scwatbwsr_bookedseats';
	
	$getRoomSql = $wpdb->prepare("SELECT * from {$tableProducts} where proid=%d", $proId);
	$room = $wpdb->get_results($getRoomSql);
	
	if(get_post_type($proId)=="events" && $room && !is_admin()){
		ob_start();
		
		$roomid = $room[0]->roomid;
		
		wp_register_script('datetimepicker', SCWATBWSR_URL .'datetimepicker/jquery.datetimepicker.full.min.js');
		wp_enqueue_script('datetimepicker');
		wp_register_style('datetimepicker', SCWATBWSR_URL .'datetimepicker/jquery.datetimepicker.css');
		wp_enqueue_style('datetimepicker');
		
		wp_register_script('panzoom', 'https://cdn.jsdelivr.net/npm/@panzoom/panzoom/dist/panzoom.min.js');
		wp_enqueue_script('panzoom');
		
		wp_register_script('scwatbwsr-script-frontend', SCWATBWSR_URL .'js/front.js');
		wp_enqueue_script('scwatbwsr-script-frontend');
		wp_register_style('scwatbwsr-style-frontend', SCWATBWSR_URL .'css/front.css?v=1.1');
		wp_enqueue_style('scwatbwsr-style-frontend');
		
		$getRoomDataSql = $wpdb->prepare("SELECT * from {$tableRooms} where id=%d", $roomid);
		$roomData = $wpdb->get_results($getRoomDataSql);
		
		$getTypeSql = $wpdb->prepare("SELECT * from {$tableTypes} where roomid=%d", $roomid);
		$types = $wpdb->get_results($getTypeSql);
		
		$getSchedulesSql = $wpdb->prepare("SELECT * from {$tableSchedules} where roomid=%d", $roomid);
		$checkSchedules = $wpdb->get_results($getSchedulesSql);
		
		if(isset($roomData[0]->tbbookedcolor))
			$tbbookedcolor = $roomData[0]->tbbookedcolor;
		else
			$tbbookedcolor = "#000";
		if(isset($roomData[0]->seatbookedcolor))
			$seatbookedcolor = $roomData[0]->seatbookedcolor;
		else
			$seatbookedcolor = "#000";

		$getTablesSql = $wpdb->prepare("SELECT * from {$tablesTb} where roomid=%d", $roomid);
		$tables = $wpdb->get_results($getTablesSql);
		
		$bookedSeats = array();
		$getOrdersSql = $wpdb->prepare("SELECT * from {$ordersTb} where productId=%d", $proId);
		$orders = $wpdb->get_results($getOrdersSql);
		if($orders){
			foreach($orders as $order){
				$oseats = explode(",", $order->seats);
				foreach($oseats as $os){
					array_push($bookedSeats, $os);
				}
			}
		}
		$getBookedSql = $wpdb->prepare("SELECT * from {$bookedTB} where roomid=%d and proid=%d", $roomid, $proId);
		$bookeds = $wpdb->get_results($getBookedSql);
		if($bookeds){
			foreach($bookeds as $bk){
				array_push($bookedSeats, $bk->tb .".".$bk->seat);
			}
		}
		$bookedSeats = array_unique($bookedSeats);
		?>
		<div class="scwatbwsr_content <?php echo get_post_type($proId) ?>" style="display: none">
			<input type="hidden" value="<?php echo esc_attr(SCWATBWSR_URL) ?>" class="scwatbwsr_url">
			<input type="hidden" value="<?php echo esc_attr($proId) ?>" class="product_id">
			<input type="hidden" value="<?php echo esc_attr($roomid) ?>" class="profileid">
			<input type="hidden" value="<?php echo esc_attr($tbbookedcolor) ?>" class="tbbookedcolor">
			<input type="hidden" value="<?php echo esc_attr($seatbookedcolor) ?>" class="seatbookedcolor">
			<input type="hidden" value="<?php echo esc_attr($roomData[0]->compulsory) ?>" class="scw_compulsory">
			<input type="hidden" value="<?php echo esc_attr($roomData[0]->bookingtime) ?>" class="scw_bookingtime">
			<input type="hidden" value="<?php echo esc_attr(get_option('date_format')) ?>" class="scw_date_format">
			<input type="hidden" value="<?php echo esc_attr(get_post_type($proId)) ?>" class="scw_posttype">

			<div class="scwatbwsr_types">
				<?php
					if($types){
						foreach($types as $type){
							$getPriceSql = $wpdb->prepare("SELECT * from {$pricesTb} where typeid=%d", $type->id);
							$price = $wpdb->get_results($getPriceSql);
							?>
							<span class="scwatbwsr_types_item">
								<span class="scwatbwsr_types_item_name"><b><?php echo esc_attr($type->name) ?></b></span>
								<span class="scwatbwsr_types_item_bg" style="background: <?php echo esc_attr($type->tbbg) ?>">bg</span>
								<?php
									if($price && $price[0]->price){
										if($price[0]->type == "seat") $pricetype = esc_html__("per seat", "scwatbwsr-translate");
										elseif($price[0]->type == "table") $pricetype = esc_html__("per table", "scwatbwsr-translate");
										elseif($price[0]->type == "time") $pricetype = esc_html__("one time for all", "scwatbwsr-translate");
									?>
									<span class="scwatbwsr_types_item_price">(<?php echo esc_attr($currencyS.$price[0]->price ." ".$pricetype) ?>)</span>
								<?php } ?>
							</span>
							<?php
						}
					}
				?>
				<span class="scwatbwsr_types_item">
					<span class="scwatbwsr_types_item_name"><b><?php echo esc_html__("Booked Table", "scwatbwsr-translate") ?></b></span>
					<span class="scwatbwsr_types_item_bg" style="background: <?php echo esc_attr($tbbookedcolor) ?>">bg</span>
				</span>
			</div>

            <?php
            $event_date = get_field("event_date");
            ?>

            <div class="scwatbwsr_schedule_item" style="display: none;" data-date="<?php echo $event_date ?>"> <?php echo $event_date ?> </div>


<!--			<div class="scwatbwsr_schedules --><?php //if($checkSchedules){ ?><!--scwatbwsr_schedules_special--><?php //}else{ ?><!--scwatbwsr_schedules_daily--><?php //} ?><!--">-->
<!--				--><?php
//				if($checkSchedules){
//					?><!--<div class="scwatbwsr_schedules_header">--><?php //echo esc_html__("Please choose schedule first!", "scwatbwsr-translate") ?><!--</div>--><?php
//					foreach($checkSchedules as $sche){
//						?><!--<span class="scwatbwsr_schedules_item">--><?php //echo esc_attr($sche->schedule) ?><!--</span>--><?php
//					}
//				}else{
//					$arroDay = array(0, 1, 2, 3, 4, 5, 6);
//					$arrDay = array();
//					$arrTime = "";
//
//					$tableDailySchedules = $wpdb->prefix . 'scwatbwsr_dailyschedules';
//					$getDSSql = $wpdb->prepare("SELECT * from {$tableDailySchedules} where roomid=%d", $roomid);
//					$getDSRs = $wpdb->get_results($getDSSql);
//					if(isset($getDSRs[0]->daily)) $dailies = explode(",", $getDSRs[0]->daily);
//					else $dailies = array();
//					if($dailies){
//						foreach($dailies as $dai){
//							if($dai == "monday")
//								array_push($arrDay, 1);
//							elseif($dai == "tuesday")
//								array_push($arrDay, 2);
//							elseif($dai == "wednesday")
//								array_push($arrDay, 3);
//							elseif($dai == "thursday")
//								array_push($arrDay, 4);
//							elseif($dai == "friday")
//								array_push($arrDay, 5);
//							elseif($dai == "saturday")
//								array_push($arrDay, 6);
//							elseif($dai == "sunday")
//								array_push($arrDay, 0);
//						}
//					}
//					$arrfDay = array_diff($arroDay, $arrDay);
//
//					$tableDailyTimes = $wpdb->prefix . 'scwatbwsr_dailytimes';
//					$getDTSql = $wpdb->prepare("SELECT * from {$tableDailyTimes} where roomid=%d", $roomid);
//					$times = $wpdb->get_results($getDTSql);
//					if($times){
//						foreach($times as $time){
//							if($arrTime)
//								$arrTime .= ",".$time->time;
//							else
//								$arrTime .= $time->time;
//						}
//					}
//
//					?>
<!--					<div class="scwatbwsr_schedules_header">--><?php //echo esc_html__("Please choose schedule first!", "scwatbwsr-translate") ?><!--</div>-->
<!--					<input class="array_dates" type="hidden" value='--><?php //echo json_encode($arrfDay, 1) ?><!--'>-->
<!--					<input class="array_times" type="hidden" value="--><?php //echo esc_attr($arrTime) ?><!--">-->
<!--					<input id="scwatbwsr_schedules_picker" type="text">-->
<!--					--><?php
//				}
//				?>
<!--			</div>-->
			
			<div class="scwatbwsr_map">
				<div class="scwatbwsr_map_head"><?php echo esc_html__("Choose your Seats", "scwatbwsr-translate") ?></div>
				<div class="scwatbwsr_map_zoom">
					<span id="scwatbwsr_map_zoom-in"><?php echo esc_html__("Zoom In", "scwatbwsr-translate") ?></span>
					<span id="scwatbwsr_map_zoom-out"><?php echo esc_html__("Zoom Out", "scwatbwsr-translate") ?></span>
					<span id="scwatbwsr_map_zoom_reset"><?php echo esc_html__("Reset", "scwatbwsr-translate") ?></span>
				</div>
				<div class="scwatbwsr_map_block">
				<div id="scwatbwsr_map_panzoom">
					<div class="scwatbwsr_map_bg" style="width: <?php echo esc_attr($roomData[0]->width) ?>px; height: <?php echo esc_attr($roomData[0]->height) ?>px">
						
						<?php
							if(isset($roomData[0]->roombg)){
								?><img class="scwatbwsr_map_bg_img" src="<?php echo esc_attr($roomData[0]->roombg) ?>"><?php
							}else{
								?><span class="scwatbwsr_map_bg_color" style="background: <?php echo esc_attr($roomData[0]->roomcolor) ?>">.</span><?php
							}
						?>
						<div class="scwatbwsr_map_tables">
							<?php
								if($tables){
									foreach($tables as $table){
										$getType = $wpdb->prepare("SELECT * from {$tableTypes} where id=%d", $table->type);
										$type = $wpdb->get_results($getType);
										
										$seats = explode(",", $table->seats);
										if($seats){
											$tmpArr = array();
											foreach($seats as $seat){
												array_push($tmpArr, $table->label .".".$seat);
											}
											$checkSame = array_intersect($bookedSeats, $tmpArr);
											if(count($seats) == count($checkSame))
												$tbcolor = $tbbookedcolor;
											else
												$tbcolor = $type[0]->tbbg;
										}else
											$tbcolor = $type[0]->tbbg;
										
										if($table->tleft) $tleft = $table->tleft;
										else $tleft = 0;
										
										if($table->ttop) $ttop = $table->ttop;
										else $ttop = 0;
										
										$padding = $type[0]->seatwidth + 2;
										
										$style = 'background: '.$tbcolor.' none repeat scroll 0% 0% padding-box content-box;left: '.$tleft.'px;top: '.$ttop.'px;padding: '.$padding.'px;';
										$labelStyle = 'top: '.($type[0]->seatwidth + 2).'px;left: '.($type[0]->seatwidth + 2).'px;';
										if($type[0]->tbshape == "rectangular"){
											$style .= 'width: '.($type[0]->tbrecwidth + ($type[0]->seatwidth + 2)*2).'px; height: '.($type[0]->tbrecheight + ($type[0]->seatwidth + 2)*2).'px;line-height: '.($type[0]->tbrecheight + ($type[0]->seatwidth + 2)*2).'px';
											$labelStyle .= 'width: '.$type[0]->tbrecwidth .'px; height: '.$type[0]->tbrecheight .'px; line-height: '.$type[0]->tbrecheight .'px';
										}else{
											$style .= 'width: '.($type[0]->tbcirwidth + ($type[0]->seatwidth + 2)*2).'px; height: '.($type[0]->tbcirwidth + ($type[0]->seatwidth + 2)*2).'px;line-height: '.($type[0]->tbcirwidth + ($type[0]->seatwidth + 2)*2).'px;border-radius: '.$type[0]->tbcirwidth .'px';
											$labelStyle .= 'width: '.$type[0]->tbcirwidth .'px; height: '.$type[0]->tbcirwidth .'px; line-height: '.$type[0]->tbcirwidth .'px;border-radius: '.$type[0]->tbcirwidth .'px';
										}
										
										$seatstyle = '';
										if($type[0]->seatshape == "rectangular")
											$seatstyle .= 'width: '.$type[0]->seatwidth .'px; height: '.$type[0]->seatwidth .'px;line-height: '.$type[0]->seatwidth .'px;';
										else
											$seatstyle .= 'width: '.$type[0]->seatwidth .'px; height: '.$type[0]->seatwidth .'px;line-height: '.$type[0]->seatwidth .'px;border-radius: '.$type[0]->seatwidth .'px;';
										
										?>
										<span id="table<?php echo esc_attr($table->label) ?>" class="scwatbwsr_map_tables_table" style="<?php echo esc_attr($style) ?>">
											<input type="hidden" class="scwatbwsr_table_readcolor" value="<?php echo esc_attr($type[0]->tbbg) ?>">
											<input type="hidden" class="scwatbwsr_seat_readcolor" value="<?php echo esc_attr($type[0]->seatbg) ?>">
											<span class="scwatbwsr_map_tables_table_seats" style="width: calc(100% + <?php echo esc_attr(($type[0]->seatwidth+2)*2) ?>px);
											margin-left: -<?php echo esc_attr($type[0]->seatwidth+2) ?>px;
											height: calc(100% + <?php echo esc_attr(($type[0]->seatwidth+2)*2) ?>px);
											margin-top: -<?php echo esc_attr($type[0]->seatwidth+2) ?>px;
											">
											<?php
												if($seats){
													foreach($seats as $seat){
														$getSeatDt = $wpdb->prepare("SELECT * from {$seatsTb} where tbid=%d and seat=%s", $table->id, $seat);
														$seatdt = $wpdb->get_results($getSeatDt);
														if(isset($seatdt[0]->tleft)) $sleft = $seatdt[0]->tleft;
														else $sleft = 0;
														
														if(isset($seatdt[0]->ttop)) $stop = $seatdt[0]->ttop;
														else $stop = 0;
														
														$newseatstyle = $seatstyle.'left: '.$sleft.'px; top: '.$stop.'px;';
														
														if(in_array($table->label .".".$seat, $bookedSeats))
															$newseatstyle .= 'background: '.$seatbookedcolor.';';
														else
															$newseatstyle .= 'background: '.$type[0]->seatbg .';';
														?><span id="seat<?php echo esc_attr($table->label .$seat) ?>" style="<?php echo esc_attr($newseatstyle) ?>" class="scwatbwsr_map_tables_table_seat <?php if(in_array($table->label .".".$seat, $bookedSeats)) echo "seatbooked" ?>"><?php echo esc_attr($seat) ?></span><?php
													}
												}
											?>
											</span>
											<span style="<?php echo esc_attr($labelStyle) ?>" class="scwatbwsr_map_tables_table_label"><?php echo esc_attr($table->label) ?></span>
										</span>
										<?php
									}
								}
							?>
						</div>
						</div>
					</div>
				</div>
			</div>
			
<!--			<div class="scwatbwsr_form">-->
<!--				<div class="scwatbwsr_total">-->
<!--					<span>--><?php //echo esc_html__("Total: $", "scwatbwsr-translate") ?><!--</span>-->
<!--					<span class="scwatbwsr_total_value">0</span>-->
<!--				</div>-->
<!--				<div class="scwatbwsr_sendform">-->
<!--					<div class="scwatbwsr_form_item scw_form_name">-->
<!--						<label>--><?php //echo esc_html__("Name", "scwatbwsr-translate") ?><!--</label>-->
<!--						<input class="scwatbwsr_form_name_input" type="text">-->
<!--					</div>-->
<!--					<div class="scwatbwsr_form_item scw_form_address">-->
<!--						<label>--><?php //echo esc_html__("Address", "scwatbwsr-translate") ?><!--</label>-->
<!--						<input class="scwatbwsr_form_address_input" type="text">-->
<!--					</div>-->
<!--					<div class="scwatbwsr_form_item scw_form_email">-->
<!--						<label>--><?php //echo esc_html__("Email", "scwatbwsr-translate") ?><!--</label>-->
<!--						<input class="scwatbwsr_form_email_input" type="text">-->
<!--					</div>-->
<!--					<div class="scwatbwsr_form_item scw_form_phone">-->
<!--						<label>--><?php //echo esc_html__("Phone", "scwatbwsr-translate") ?><!--</label>-->
<!--						<input class="scwatbwsr_form_phone_input" type="text">-->
<!--					</div>-->
<!--					<div class="scwatbwsr_form_item scw_form_note">-->
<!--						<label>--><?php //echo esc_html__("Note", "scwatbwsr-translate") ?><!--</label>-->
<!--						<textarea class="scwatbwsr_form_note_input"></textarea>-->
<!--					</div>-->
<!--					<div class="scwatbwsr_form_item"><span class="scwatbwsr_form_submit">--><?php //echo esc_html__("Submit", "scwatbwsr-translate") ?><!--</span></div>-->
<!--				</div>-->
<!--			</div>-->
		</div>
		<?php
		$string = ob_get_contents();
		ob_end_clean();
		$content .= $string;
	}
	return $content;
}


// CUSTOM

function getValueById(int $id, array $array) {
    $value = "";
    foreach($array as $index=>$json) {
        if($json['id'] == $id) {
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
 * @param  array  $fields     Sanitized entry field values/properties.
 * @param  array  $entry      Original $_POST global.
 * @param  array  $form_data  Form data and settings.
 *
 * @return array
 */

function wpf_dev_process_filter( $fields, $entry, $form_data ) {

    // #octo id's von Table Booking Form
    // Erstellt hash (orderid) und fügt sie in die Form
    global $wpf_id_date, $wpf_id_name, $wpf_id_table, $wpf_id_order_id, $wpf_id_cancel_button;
    $name = getValueById($wpf_id_name, $fields);
    $table  = getValueById($wpf_id_table, $fields);
    $date = getValueById($wpf_id_date, $fields);

    $data = $name . $date . $table;
    $order_id = hash("sha256", $data);

    $url = get_home_url() . '/cancelbooking.php?orderid=' . $order_id;
    $button = "<a href='$url'>Buchung stornieren</a>";

    foreach($fields as $index=>$json) {
        if($json['id'] == $wpf_id_order_id) {
            $fields[$index]['value'] = $order_id;
        }
        if($json['id'] == $wpf_id_cancel_button) {
            $fields[$index]['value'] = $button;
        }
    }

    error_log(json_encode($fields));

    return $fields;

}

add_filter( 'wpforms_process_filter', 'wpf_dev_process_filter', 10, 3 );



/**
 * Action that fires during form entry processing after initial field validation.
 *
 * @link   https://wpforms.com/developers/wpforms_process/
 *
 * @param  array  $fields    Sanitized entry field. values/properties.
 * @param  array  $entry     Original $_POST global.
 * @param  array  $form_data Form data and settings.
 *
 */

function wpf_dev_process( $fields, $entry, $form_data ) {

    // #octo id's von Table Booking Form
    // schreibt Werte aus Form in Datenbank
    global $wpf_id_date, $wpf_id_order_id, $wpf_id_mail, $wpf_id_name, $wpf_id_table;
    $name = getValueById($wpf_id_name, $fields);
    $table  = getValueById($wpf_id_table, $fields);
    $date = getValueById($wpf_id_date, $fields);
    $email = getValueById($wpf_id_mail, $fields);
    $order_id =  getValueById($wpf_id_order_id, $fields);


    global $wpdb;
    $table_name = $wpdb->prefix . 'scwatbwsr_orders';
    $wpdb->query($wpdb->prepare("INSERT INTO $table_name (`productId`, `orderId`, `seats`, `schedule`, `name`, `address`, `email`, `phone`, `note`, `total`)
	VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        $entry['post_id'], $order_id, $table, $date, $name, " ", $email, " ", " ", " "));

    //wpforms()->process->errors[ $form_data['id'] ] [ '4' ] = "Some Error occured";
}

add_action( 'wpforms_process', 'wpf_dev_process', 10, 4 );

/**
 * Filter applies to entry fields before a form notification email is sent.
 *
 * @link  https://wpforms.com/developers/wpforms_entry_email_data/
 *
 * @param  array  $fields     Sanitized entry field values/properties.
 * @param  array  $entry      Original $_POST global.
 * @param  array  $form_data  Form data and settings.
 *
 * @return array
 */

function wpf_dev_entry_email_data( $fields, $entry, $form_data ) {

    global $wpdb, $wpf_id_order_id, $wpf_id_booking_id;

    $order_id = getValueById($wpf_id_order_id, $fields);

    $table_name = $wpdb->prefix . 'scwatbwsr_orders';
    $query = $wpdb->prepare("SELECT id from {$table_name} where orderId=%s", $order_id);
    $id_array = $wpdb->get_results($query);
    $id = $id_array[0]->id;

    foreach($fields as $index=>$json) {
        if($json['id'] == $wpf_id_booking_id) {
            $fields[$index]['value'] = $id;
        }
    }


    return $fields;

}
add_filter( 'wpforms_entry_email_data' , 'wpf_dev_entry_email_data', 10, 3  );