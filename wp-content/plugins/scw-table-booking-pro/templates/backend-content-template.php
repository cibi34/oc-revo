<?php
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
            <div class="scwatbwsr_add_head"><?php echo esc_html__("Bereich hinzufügen", "scwatbwsr-translate") ?></div>
            <input class="scwatbwsr_add_name"
                   placeholder="<?php echo esc_html__("Bereichsname", "scwatbwsr-translate") ?>" type="text">
            <span class="scwatbwsr_add_button"><i class="fa fa-plus"
                                                  aria-hidden="true"></i> <?php echo esc_html__("Hinzufügen", "scwatbwsr-translate") ?></span>
        </div>
        <div class="scwatbwsr_rooms">
            <?php
            if ($rooms) {
                foreach ($rooms as $room) {
                    $getTypesSql = $wpdb->prepare("SELECT * from {$typesTB} where roomid=%d", $room->id);
                    $types = $wpdb->get_results($getTypesSql);

                    $getScheSql = $wpdb->prepare("SELECT * from {$tableSchedules} where roomid=%d", $room->id);
                    $schedules = $wpdb->get_results($getScheSql);

                    $getdailiesSql = $wpdb->prepare("SELECT * from {$tableDailySchedules} where roomid=%d", $room->id);
                    $dailies = $wpdb->get_results($getdailiesSql);
                    if (isset($dailies[0]->daily)) $dailies = explode(",", $dailies[0]->daily);
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
                                <input class="scwatbwsr_room_content_tabs_input"
                                       id="scwatbwsr_tab1<?php echo esc_attr($room->id) ?>" type="radio"
                                       name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
                                <label class="scwatbwsr_room_content_tabs_label active"
                                       for="scwatbwsr_tab1<?php echo esc_attr($room->id) ?>"><i
                                        class="fa fa-cog"></i><span><?php echo esc_html__("Basic Setting", "scwatbwsr-translate") ?></span></label>

                                <input class="scwatbwsr_room_content_tabs_input"
                                       id="scwatbwsr_tab2<?php echo esc_attr($room->id) ?>" type="radio"
                                       name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
                                <label class="scwatbwsr_room_content_tabs_label"
                                       for="scwatbwsr_tab2<?php echo esc_attr($room->id) ?>"><i
                                        class="fa fa-codepen"></i><span><?php echo esc_html__("Table Types", "scwatbwsr-translate") ?></span></label>

                                <input class="scwatbwsr_room_content_tabs_input"
                                       id="scwatbwsr_tab3<?php echo esc_attr($room->id) ?>" type="radio"
                                       name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
                                <label class="scwatbwsr_room_content_tabs_label"
                                       for="scwatbwsr_tab3<?php echo esc_attr($room->id) ?>"><i
                                        class="fa fa-calendar"></i><span><?php echo esc_html__("Schedules", "scwatbwsr-translate") ?></span></label>

                                <input class="scwatbwsr_room_content_tabs_input"
                                       id="scwatbwsr_tab4<?php echo esc_attr($room->id) ?>" type="radio"
                                       name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
                                <label class="scwatbwsr_room_content_tabs_label"
                                       for="scwatbwsr_tab4<?php echo esc_attr($room->id) ?>"><i
                                        class="fa fa-usd"></i><span><?php echo esc_html__("Price", "scwatbwsr-translate") ?></span></label>

                                <input class="scwatbwsr_room_content_tabs_input"
                                       id="scwatbwsr_tab5<?php echo esc_attr($room->id) ?>" type="radio"
                                       name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
                                <label class="scwatbwsr_room_content_tabs_label"
                                       for="scwatbwsr_tab5<?php echo esc_attr($room->id) ?>"><i
                                        class="fa fa-th"></i><span><?php echo esc_html__("Tables", "scwatbwsr-translate") ?></span></label>

                                <input class="scwatbwsr_room_content_tabs_input"
                                       id="scwatbwsr_tab6<?php echo esc_attr($room->id) ?>" type="radio"
                                       name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
                                <label class="scwatbwsr_room_content_tabs_label"
                                       for="scwatbwsr_tab6<?php echo esc_attr($room->id) ?>"><i
                                        class="fa fa-braille"></i><span><?php echo esc_html__("Mapping", "scwatbwsr-translate") ?></span></label>

                                <input class="scwatbwsr_room_content_tabs_input"
                                       id="scwatbwsr_tab7<?php echo esc_attr($room->id) ?>" type="radio"
                                       name="scwatbwsr_tabs<?php echo esc_attr($room->id) ?>">
                                <label class="scwatbwsr_room_content_tabs_label"
                                       for="scwatbwsr_tab7<?php echo esc_attr($room->id) ?>"><i
                                        class="fa fa-file-text-o"></i><span><?php echo esc_html__("Booked Seats", "scwatbwsr-translate") ?></span></label>

                                <section id="scwatbwsr_content1<?php echo esc_attr($room->id) ?>"
                                         class="tab-content active">
										<span class="scwatbwsr_room_content_editname">
											<span class="scwatbwsr_room_content_editname_head"><?php echo esc_html__("Edit Name", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_room_content_editname_name"
                                                   value="<?php echo esc_attr($room->roomname) ?>" type="text">
										</span>
                                    <span class="scwatbwsr_roombg">
											<span class="scwatbwsr_roombg_label"><?php echo esc_html__("Room Background", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_roombg_con">
												<input type="color" id="scwatbwsr_roombg_con_color"
                                                       class="scwatbwsr_roombg_con_color"
                                                       value="<?php echo esc_attr("#000000") ?>">
												<label for="scwatbwsr_roombg_con_color"
                                                       class="scwatbwsr_roombg_con_color_button"><?php echo esc_html__("Pick Color", "scwatbwsr-translate") ?></label>
												<span class="scwatbwsr_roombg_con_or"><?php echo esc_html__("OR", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_roombg_con_bgpreview">
													<?php
                                                    if ($room->roombg) {
                                                        ?><img src="<?php echo esc_attr($room->roombg) ?>"><?php
                                                    }
                                                    ?>
												</span>
												<input class="scwatbwsr_roombg_con_image"
                                                       value="<?php echo esc_attr($room->roombg) ?>" type="text">
												<span class="scwatbwsr_roombg_con_upload scwatbwsr_media_upload"><?php echo esc_html__("Upload Image", "scwatbwsr-translate") ?></span>
											</span>
										</span>
                                    <span class="scwatbwsr_roomsize">
											<span class="scwatbwsr_roomsize_label"><?php echo esc_html__("Room Size", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_roomsize_width" placeholder="Width (px)"
                                                   value="<?php echo esc_attr($room->width) ?>" type="text">
											<input class="scwatbwsr_roomsize_height" placeholder="Height (px)"
                                                   value="<?php echo esc_attr($room->height) ?>" type="text">
										</span>
                                    <span class="scwatbwsr_bookedpr">
											<span class="scwatbwsr_bookedpr_label"><?php echo esc_html__("Table Booked Color", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_bookedpr_tbcolor"
                                                   value="<?php echo esc_attr($room->tbbookedcolor) ?>" type="color">
											<span class="scwatbwsr_bookedpr_label"><?php echo esc_html__("Seat Booked Color", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_bookedpr_seatcolor"
                                                   value="<?php echo esc_attr($room->seatbookedcolor) ?>" type="color">
										</span>
                                    <span class="scwatbwsr_bktime">
											<span class="scwatbwsr_bktime_label"><?php echo esc_html__("Booking Time (in minutes - the time customers will stay)", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_bktime_ip"
                                                   value="<?php echo esc_attr($room->bookingtime) ?>" type="text">
										</span>
                                    <span class="scwatbwsr_compulsory">
											<input class="scwatbwsr_compulsory_ip" <?php if ($room->compulsory == "yes") echo "checked" ?> type="checkbox">
											<span class="scwatbwsr_compulsory_label"><?php echo esc_html__("Compulsory choose seats and tables before add product to cart", "scwatbwsr-translate") ?></span>
										</span>
                                    <span class="scwatbwsr_basesetting_save"><i class="fa fa-floppy-o"
                                                                                aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
                                </section>

                                <section id="scwatbwsr_content2<?php echo esc_attr($room->id) ?>"
                                         class="tab-content">
										<span class="scwatbwsr_roomtype_add">
											<span class="scwatbwsr_roomtype_add_head"><?php echo esc_html__("Add a type", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_roomtype_add_name" placeholder="Name of type"
                                                   type="text">
											<span class="scwatbwsr_roomtype_add_table"><?php echo esc_html__("Table", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_roomtype_add_tbcolor">
												<span class="scwatbwsr_roomtype_add_tbcolor_head"><?php echo esc_html__("Background Color", "scwatbwsr-translate") ?></span>
												<input type="color" class="scwatbwsr_roomtype_add_tbcolor_input"
                                                       id="scwatbwsr_roomtype_add_tbcolor_input">
												<label class="scwatbwsr_roomtype_add_tbcolor_button"
                                                       for="scwatbwsr_roomtype_add_tbcolor_input"><?php echo esc_html__("Pick Color", "scwatbwsr-translate") ?></label>
											</span>
											<span class="scwatbwsr_roomtype_add_tbshape">
												<span class="scwatbwsr_roomtype_add_tbshape_head"><?php echo esc_html__("Shape", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_roomtype_add_tbshape_con">
													<label><?php echo esc_html__("Rectangular", "scwatbwsr-translate") ?></label>
													<input type="radio" class="scwatbwsr_roomtype_add_tbshape_rec"
                                                           name="scwatbwsr_roomtype_add_tbshape" value="rectangular">
													<input type="text" class="scwatbwsr_roomtype_add_tbshape_rec_width"
                                                           placeholder="Width (px)">
													<input type="text" class="scwatbwsr_roomtype_add_tbshape_rec_height"
                                                           placeholder="Height (px)">
												</span>
												<span class="scwatbwsr_roomtype_add_tbshape_con">
													<label><?php echo esc_html__("Circle", "scwatbwsr-translate") ?></label>
													<input type="radio" class="scwatbwsr_roomtype_add_tbshape_cir"
                                                           name="scwatbwsr_roomtype_add_tbshape" value="circle">
													<input type="text" class="scwatbwsr_roomtype_add_tbshape_cir_width"
                                                           placeholder="Width (diameter-px)">
												</span>
											</span>
											<span class="scwatbwsr_roomtype_add_seat"><?php echo esc_html__("Seat", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_roomtype_add_seatcolor">
												<span class="scwatbwsr_roomtype_add_seatcolor_head"><?php echo esc_html__("Background Color", "scwatbwsr-translate") ?></span>
												<input type="color" class="scwatbwsr_roomtype_add_seatcolor_input"
                                                       id="scwatbwsr_roomtype_add_seatcolor_input">
												<label class="scwatbwsr_roomtype_add_seatcolor_button"
                                                       for="scwatbwsr_roomtype_add_seatcolor_input"><?php echo esc_html__("Pick Color", "scwatbwsr-translate") ?></label>
											</span>
											<span class="scwatbwsr_roomtype_add_seatshape">
												<span class="scwatbwsr_roomtype_add_seatshape_head"><?php echo esc_html__("Shape", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_roomtype_add_seatshape_con">
													<label><?php echo esc_html__("Rectangular", "scwatbwsr-translate") ?></label>
													<input type="radio" class="scwatbwsr_roomtype_add_seatshape_rec"
                                                           name="scwatbwsr_roomtype_add_seatshape" value="rectangular">
												</span>
												<span class="scwatbwsr_roomtype_add_seatshape_con">
													<label><?php echo esc_html__("Circle", "scwatbwsr-translate") ?></label>
													<input type="radio" class="scwatbwsr_roomtype_add_seatshape_cir"
                                                           name="scwatbwsr_roomtype_add_seatshape" value="circle">
												</span>
											</span>
											<input type="text" class="scwatbwsr_roomtype_add_seat_size"
                                                   placeholder="Width (px)">
											<span class="scwatbwsr_roomtype_add_button"><i class="fa fa-plus"
                                                                                           aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_roomtype_add_reload"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i
                                                    class="fa fa-refresh" aria-hidden="true"></i></span>
										</span>
                                    <span class="scwatbwsr_roomtype_items">
											<span class="scwatbwsr_roomtype_items_head"><?php echo esc_html__("Types", "scwatbwsr-translate") ?></span>
											<?php
                                            if ($types) {
                                                foreach ($types as $type) {
                                                    ?>
                                                    <span class="scwatbwsr_roomtype_item">
														<input value="<?php echo esc_attr($type->id) ?>" type="hidden"
                                                               class="scwatbwsr_roomtype_item_id">
														<span class="scwatbwsr_roomtype_item_name">
															<span><?php echo esc_attr($type->name) ?></span><br>
															<span class="scwatbwsr_roomtype_item_name_shape"><?php echo esc_html__("Table: ", "scwatbwsr-translate") . esc_attr($type->tbshape) ?></span><br>
															<span class="scwatbwsr_roomtype_item_name_shape"><?php echo esc_html__("Seat: ", "scwatbwsr-translate") . esc_attr($type->seatshape) ?></span>
														</span>
														<span class="scwatbwsr_roomtype_item_tbbg">
															<label><?php echo esc_html__("Table Color", "scwatbwsr-translate") ?></label>
															<input type="color"
                                                                   class="scwatbwsr_roomtype_item_tbbg_input"
                                                                   value="<?php echo esc_attr($type->tbbg) ?>">
														</span>
														<span class="scwatbwsr_roomtype_item_tbsize <?php echo esc_attr($type->tbshape) ?>">
															<label><?php echo esc_html__("Table Size", "scwatbwsr-translate") ?></label>
															<input type="text"
                                                                   class="scwatbwsr_roomtype_item_tbsize_recwidth"
                                                                   value="<?php echo esc_attr($type->tbrecwidth) ?>">
															<input type="text"
                                                                   class="scwatbwsr_roomtype_item_tbsize_recheight"
                                                                   value="<?php echo esc_attr($type->tbrecheight) ?>">
															<input type="text"
                                                                   class="scwatbwsr_roomtype_item_tbsize_cirwidth"
                                                                   value="<?php echo esc_attr($type->tbcirwidth) ?>">
														</span>
														<span class="scwatbwsr_roomtype_item_seatbg">
															<label><?php echo esc_html__("Seat Color", "scwatbwsr-translate") ?></label>
															<input type="color"
                                                                   class="scwatbwsr_roomtype_item_seatbg_input"
                                                                   value="<?php echo esc_attr($type->seatbg) ?>">
														</span>
														<span class="scwatbwsr_roomtype_item_seatsize <?php echo esc_attr($type->seatshape) ?>">
															<label><?php echo esc_html__("Seat Size", "scwatbwsr-translate") ?></label>
															<input type="text"
                                                                   class="scwatbwsr_roomtype_item_seatsize_width"
                                                                   value="<?php echo esc_attr($type->seatwidth) ?>">
														</span>
														<span class="scwatbwsr_roomtype_item_save"><i
                                                                class="fa fa-floppy-o"
                                                                aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
														<span class="scwatbwsr_roomtype_item_del"><i
                                                                class="fa fa-trash-o"
                                                                aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
													</span>
                                                    <?php
                                                }
                                            }
                                            ?>
										</span>
                                </section>

                                <section id="scwatbwsr_content3<?php echo esc_attr($room->id) ?>"
                                         class="tab-content">
										<span class="scwatbwsr_schedules_spec">
											<span class="scwatbwsr_schedules_spec_head"><?php echo esc_html__("Separate Schedules", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_schedules_spec_add">
												<input class="scwatbwsr_schedules_spec_add_input" type="text">
												<span class="scwatbwsr_schedules_spec_button"><i class="fa fa-plus"
                                                                                                 aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
												<span class="scwatbwsr_schedules_spec_add_reload"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i
                                                        class="fa fa-refresh" aria-hidden="true"></i></span>
											</span>
											<span class="scwatbwsr_schedules_spec_list">
												<?php
                                                if ($schedules) {
                                                    foreach ($schedules as $schedule) {
                                                        ?>
                                                        <span class="scwatbwsr_schedules_spec_list_item">
															<input type="hidden"
                                                                   value="<?php echo esc_attr($schedule->id) ?>"
                                                                   class="scwatbwsr_schedules_spec_list_item_id">
															<input class="scwatbwsr_schedules_spec_list_item_schedule"
                                                                   value="<?php echo esc_attr($schedule->schedule) ?>"
                                                                   type="text">
															<span class="scwatbwsr_schedules_spec_list_item_save"><i
                                                                    class="fa fa-floppy-o"
                                                                    aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
															<span class="scwatbwsr_schedules_spec_list_item_delete"><i
                                                                    class="fa fa-trash-o"
                                                                    aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
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
													<input <?php if (in_array("monday", $dailies)) echo "checked='checked'" ?> value="monday"
                                                                                                                               type="checkbox"
                                                                                                                               class="scwatbwsr_daily_schedules_monday"
                                                                                                                               id="scwatbwsr_daily_schedules_monday">
													<label for="scwatbwsr_daily_schedules_monday"><?php echo esc_html__("Monday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if (in_array("tuesday", $dailies)) echo "checked='checked'" ?> value="tuesday"
                                                                                                                                type="checkbox"
                                                                                                                                class="scwatbwsr_daily_schedules_tuesday"
                                                                                                                                id="scwatbwsr_daily_schedules_tuesday">
													<label for="scwatbwsr_daily_schedules_tuesday"><?php echo esc_html__("Tuesday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if (in_array("wednesday", $dailies)) echo "checked='checked'" ?> value="wednesday"
                                                                                                                                  type="checkbox"
                                                                                                                                  class="scwatbwsr_daily_schedules_wednesday"
                                                                                                                                  id="scwatbwsr_daily_schedules_wednesday">
													<label for="scwatbwsr_daily_schedules_wednesday"><?php echo esc_html__("Wednesday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if (in_array("thursday", $dailies)) echo "checked='checked'" ?> value="thursday"
                                                                                                                                 type="checkbox"
                                                                                                                                 class="scwatbwsr_daily_schedules_thursday"
                                                                                                                                 id="scwatbwsr_daily_schedules_thursday">
													<label for="scwatbwsr_daily_schedules_thursday"><?php echo esc_html__("Thursday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if (in_array("friday", $dailies)) echo "checked='checked'" ?> value="friday"
                                                                                                                               type="checkbox"
                                                                                                                               class="scwatbwsr_daily_schedules_friday"
                                                                                                                               id="scwatbwsr_daily_schedules_friday">
													<label for="scwatbwsr_daily_schedules_friday"><?php echo esc_html__("Friday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if (in_array("saturday", $dailies)) echo "checked='checked'" ?> value="saturday"
                                                                                                                                 type="checkbox"
                                                                                                                                 class="scwatbwsr_daily_schedules_saturday"
                                                                                                                                 id="scwatbwsr_daily_schedules_saturday">
													<label for="scwatbwsr_daily_schedules_saturday"><?php echo esc_html__("Saturday", "scwatbwsr-translate") ?></label>
												</span>
												<span class="scwatbwsr_daily_schedules_week">
													<input <?php if (in_array("sunday", $dailies)) echo "checked='checked'" ?> value="sunday"
                                                                                                                               type="checkbox"
                                                                                                                               class="scwatbwsr_daily_schedules_sunday"
                                                                                                                               id="scwatbwsr_daily_schedules_sunday">
													<label for="scwatbwsr_daily_schedules_sunday"><?php echo esc_html__("Sunday", "scwatbwsr-translate") ?></label>
												</span>
											</span>
											<span class="scwatbwsr_daily_schedules_times">
												<span class="scwatbwsr_daily_schedules_times_add">
													<input class="scwatbwsr_daily_schedules_times_add_input"
                                                           placeholder="daily time" type="text">
													<span class="scwatbwsr_daily_schedules_times_add_button"><i
                                                            class="fa fa-plus"
                                                            aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
													<span class="scwatbwsr_daily_schedules_times_refresh_button"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i
                                                            class="fa fa-refresh" aria-hidden="true"></i></span>
												</span>
												<span class="scwatbwsr_daily_schedules_times_list">
													<?php
                                                    if ($times) {
                                                        foreach ($times as $time) {
                                                            ?>
                                                            <span class="scwatbwsr_daily_schedules_times_list_item">
																<input class="scwatbwsr_daily_schedules_times_list_item_id"
                                                                       type="hidden"
                                                                       value="<?php echo esc_attr($time->id) ?>">
																<input class="scwatbwsr_daily_schedules_times_list_item_input"
                                                                       placeholder="daily time"
                                                                       value="<?php echo esc_attr($time->time) ?>"
                                                                       type="text">
																<span class="scwatbwsr_daily_schedules_times_list_item_button"><i
                                                                        class="fa fa-floppy-o"
                                                                        aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
																<span class="scwatbwsr_daily_schedules_times_list_item_delete"><i
                                                                        class="fa fa-trash-o"
                                                                        aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
															</span>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
												</span>
											</span>
										</span>
                                </section>

                                <section id="scwatbwsr_content4<?php echo esc_attr($room->id) ?>"
                                         class="tab-content">
										<span class="scwatbwsr_prices">
											<?php
                                            if ($types) {
                                                foreach ($types as $type) {
                                                    $getPriceSql = $wpdb->prepare("SELECT * from {$pricesTb} where typeid=%d", $type->id);
                                                    $price = $wpdb->get_results($getPriceSql);

                                                    if (isset($price[0]->price)) $pri = $price[0]->price;
                                                    else $pri = 0;

                                                    if (isset($price[0]->type)) $itype = $price[0]->type;
                                                    else $itype = "seat";
                                                    ?>
                                                    <span class="scwatbwsr_prices_item">
														<span class="scwatbwsr_prices_item_head"><?php echo esc_attr($type->name) . " " . esc_html__("price", "scwatbwsr-translate") ?></span>
														<input class="scwatbwsr_prices_item_typeid" type="hidden"
                                                               value="<?php echo esc_attr($type->id) ?>">
														<input class="scwatbwsr_prices_item_price" type="text"
                                                               value="<?php echo esc_attr($pri) ?>">
														<select class="scwatbwsr_prices_item_type">
															<option <?php if ($itype == "seat") echo "selected" ?> value="seat"><?php echo esc_html__("Per Seat", "scwatbwsr-translate") ?></option>
															<option <?php if ($itype == "table") echo "selected" ?> value="table"><?php echo esc_html__("Per Table", "scwatbwsr-translate") ?></option>
															<option <?php if ($itype == "time") echo "selected" ?> value="time"><?php echo esc_html__("One Time", "scwatbwsr-translate") ?></option>
														</select>
													</span>
                                                    <?php
                                                }
                                            }
                                            ?>
										</span>
                                    <span class="scwatbwsr_prices_save"><i class="fa fa-floppy-o"
                                                                           aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
                                </section>

                                <section id="scwatbwsr_content5<?php echo esc_attr($room->id) ?>"
                                         class="tab-content">
										<span class="scwatbwsr_tables_add">
											<span class="scwatbwsr_tables_add_head"><?php echo esc_html__("Add a table", "scwatbwsr-translate") ?></span>
											<input class="scwatbwsr_tables_add_label" type="text" placeholder="Label">
											<input class="scwatbwsr_tables_add_seats" type="text"
                                                   placeholder="Label of seats">
											<select class="scwatbwsr_tables_add_type">
												<option value="">-- <?php echo esc_html__("Choose a type", "scwatbwsr-translate") ?> --</option>
												<?php
                                                if ($types) {
                                                    foreach ($types as $type) {
                                                        ?>
                                                        <option value="<?php echo esc_attr($type->id) ?>"><?php echo esc_attr($type->name) ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
											</select>
											<span class="scwatbwsr_tables_add_button"><i class="fa fa-plus"
                                                                                         aria-hidden="true"></i> <?php echo esc_html__("ADD", "scwatbwsr-translate") ?></span>
											<span class="scwatbwsr_tables_add_reload"><?php echo esc_html__("Refresh Data", "scwatbwsr-translate") ?> <i
                                                    class="fa fa-refresh" aria-hidden="true"></i></span>
										</span>
                                    <span class="scwatbwsr_tables_list">
											<span class="scwatbwsr_tables_list_head"><?php echo esc_html__("Tables", "scwatbwsr-translate") ?></span>
											<?php
                                            if ($tables) {
                                                foreach ($tables as $table) {
                                                    ?>
                                                    <span class="scwatbwsr_tables_list_item">
														<input type="hidden" value="<?php echo esc_attr($table->id) ?>"
                                                               class="scwatbwsr_tables_list_item_id">
														<span class="scwatbwsr_tables_list_item_label"><?php echo esc_attr($table->label) ?></span>
														<input type="text" class="scwatbwsr_tables_list_item_seats"
                                                               value="<?php echo esc_attr($table->seats) ?>">
														<select class="scwatbwsr_tables_list_item_type">
															<option value="">-- <?php echo esc_html__("Choose a type", "scwatbwsr-translate") ?> --</option>
															<?php
                                                            if ($types) {
                                                                foreach ($types as $type) {
                                                                    ?>
                                                                    <option <?php if ($table->type == $type->id) echo "selected" ?> value="<?php echo esc_attr($type->id) ?>"><?php echo esc_attr($type->name) ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
														</select>
														<span class="scwatbwsr_tables_list_item_save"><i
                                                                class="fa fa-floppy-o"
                                                                aria-hidden="true"></i> <?php echo esc_html__("Save", "scwatbwsr-translate") ?></span>
														<span class="scwatbwsr_tables_list_item_del"><i
                                                                class="fa fa-trash-o"
                                                                aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
													</span>
                                                    <?php
                                                }
                                            }
                                            ?>
										</span>
                                </section>

                                <section id="scwatbwsr_content6<?php echo esc_attr($room->id) ?>"
                                         class="tab-content">
										<span class="scwatbwsr_mapping_listpreview">
											<span class="scwatbwsr_mapping_preview"
                                                  style="width: <?php echo esc_attr($room->width) ?>px; height: <?php echo esc_attr($room->height) ?>px">
												<?php
                                                if ($room->roombg) {
                                                    ?><img class="scwatbwsr_mapping_preview_image"
                                                           src="<?php echo esc_attr($room->roombg) ?>"><?php
                                                } else {
                                                    ?><span style="background: <?php echo esc_attr($room->roomcolor) ?>"
                                                            class="scwatbwsr_mapping_preview_color"><?php echo esc_attr($room->roomcolor) ?></span><?php
                                                }
                                                ?>
												<span class="scwatbwsr_mapping_preview_tables">
													<?php
                                                    if ($tables) {
                                                        foreach ($tables as $table) {
                                                            $getType = $wpdb->prepare("SELECT * from {$typesTB} where id=%d", $table->type);
                                                            $type = $wpdb->get_results($getType);

                                                            if ($table->tleft) $tleft = $table->tleft;
                                                            else $tleft = 0;

                                                            if ($table->ttop) $ttop = $table->ttop;
                                                            else $ttop = 0;

                                                            $padding = $type[0]->seatwidth + 2;

                                                            $style = 'background: ' . $type[0]->tbbg . ' none repeat scroll 0% 0% padding-box content-box;left: ' . $tleft . 'px;top: ' . $ttop . 'px;padding: ' . $padding . 'px;';
                                                            if ($type[0]->tbshape == "rectangular")
                                                                $style .= 'width: ' . $type[0]->tbrecwidth . 'px; height: ' . $type[0]->tbrecheight . 'px;line-height: ' . ($type[0]->tbrecheight + ($type[0]->seatwidth + 2) * 2) . 'px';
                                                            else
                                                                $style .= 'width: ' . $type[0]->tbcirwidth . 'px; height: ' . $type[0]->tbcirwidth . 'px;line-height: ' . ($type[0]->tbcirwidth + ($type[0]->seatwidth + 2) * 2) . 'px;border-radius: ' . $type[0]->tbcirwidth . 'px';

                                                            $seatstyle = 'background: ' . $type[0]->seatbg . ';';
                                                            if ($type[0]->seatshape == "rectangular")
                                                                $seatstyle .= 'width: ' . $type[0]->seatwidth . 'px; height: ' . $type[0]->seatwidth . 'px;line-height: ' . $type[0]->seatwidth . 'px;';
                                                            else
                                                                $seatstyle .= 'width: ' . $type[0]->seatwidth . 'px; height: ' . $type[0]->seatwidth . 'px;line-height: ' . $type[0]->seatwidth . 'px;border-radius: ' . $type[0]->seatwidth . 'px;';

                                                            $seats = explode(",", $table->seats);
                                                            ?>
                                                            <span class="scwatbwsr_mapping_table"
                                                                  style="<?php echo esc_attr($style) ?>">
																<span class="scwatbwsr_mapping_table_seats"
                                                                      style="width: calc(100% + <?php echo esc_attr(($type[0]->seatwidth + 2) * 2) ?>px);
                                                                          margin-left: -<?php echo esc_attr($type[0]->seatwidth + 2) ?>px;
                                                                          height: calc(100% + <?php echo esc_attr(($type[0]->seatwidth + 2) * 2) ?>px);
                                                                          margin-top: -<?php echo esc_attr($type[0]->seatwidth + 2) ?>px;
                                                                          ">
																	<?php
                                                                    if ($seats) {
                                                                        foreach ($seats as $seat) {
                                                                            $getSeatDt = $wpdb->prepare("SELECT * from {$seatsTb} where tbid=%d and seat=%s", $table->id, $seat);
                                                                            $seatdt = $wpdb->get_results($getSeatDt);
                                                                            if (isset($seatdt[0]->tleft)) $sleft = $seatdt[0]->tleft;
                                                                            else $sleft = 0;

                                                                            if (isset($seatdt[0]->ttop)) $stop = $seatdt[0]->ttop;
                                                                            else $stop = 0;

                                                                            $newseatstyle = $seatstyle . 'left: ' . $sleft . 'px; top: ' . $stop . 'px';
                                                                            ?><span
                                                                            style="<?php echo esc_attr($newseatstyle) ?>"
                                                                            class="scwatbwsr_mapping_table_seat"><?php echo esc_attr($seat) ?></span><?php
                                                                        }
                                                                    }
                                                                    ?>
																</span>
																<input type="hidden" class="scwatbwsr_mapping_table_id"
                                                                       value="<?php echo esc_attr($table->id) ?>">
																<span class="scwatbwsr_mapping_table_label"><?php echo esc_attr($table->label) ?></span>
																<span style="margin-left: -<?php echo esc_attr($room->width) ?>px; width: <?php echo esc_attr($room->width * 2) ?>px"
                                                                      class="topline"></span>
																<span style="margin-top:-<?php echo esc_attr($room->height) ?>px; height: <?php echo esc_attr($room->height * 2) ?>px"
                                                                      class="rightline"></span>
																<span style="margin-left:-<?php echo esc_attr($room->width) ?>px; width: <?php echo esc_attr($room->width * 2) ?>px"
                                                                      class="botline"></span>
																<span style="margin-top:-<?php echo esc_attr($room->height) ?>px; height: <?php echo esc_attr($room->height * 2) ?>px"
                                                                      class="leftline"></span>
															</span>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
												</span>
											</span>
											<br>
											<span class="scwatbwsr_mapping_preview_save"><i class="fa fa-floppy-o"
                                                                                            aria-hidden="true"></i> <?php echo esc_html__("Save Mapping", "scwatbwsr-translate") ?></span>
										</span>
                                </section>


                                <section id="scwatbwsr_content7<?php echo esc_attr($room->id) ?>"
                                         class="tab-content">

                                    <label for="event-select">Event auswählen:</label>

                                    <select name="event-selection" id="event-select" data-room="<?php echo esc_attr($room->id) ?>">
                                        <option value="">--Please choose an option--</option>
                                        <?php
                                        $posts_events = get_posts([
                                            'post_type' => 'events',
                                            'numberposts' => -1
                                            // 'order'    => 'ASC'
                                        ]);
                                        foreach($posts_events as $event){
                                            ?>
                                                <option value="<?php echo $event->ID ?>"><?php echo get_the_title($event->ID) ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

<!--                                    <input type="text" id="scwatbwsr_event_datetimepicker" data-room="--><?php //echo esc_attr($room->id) ?><!--"/>-->
                                    <div class="scwatbwsr_content_container"></div>
                                    <a href="<?php echo admin_url( 'admin.php?page=scwatbwsr-table-booking' ) ?>&action=download_csv&_wpnonce=<?php echo wp_create_nonce( 'download_csv' )?>" class="page-title-action"><?php _e('Export to CSV','my-plugin-slug');?></a>
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