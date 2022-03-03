<?php
$roomsTb = $wpdb->prefix . 'scwatbwsr_rooms';
$getRoomsSql = $wpdb->prepare("SELECT * from {$roomsTb} where %d", 1);
$rooms = $wpdb->get_results($getRoomsSql);

$typesTB = $wpdb->prefix . 'scwatbwsr_types';
$pricesTb = $wpdb->prefix . 'scwatbwsr_prices';
$tablesTb = $wpdb->prefix . 'scwatbwsr_tables';
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
                                            class="fa fa-file-text-o"></i><span><?php echo esc_html__("Booked Tables", "scwatbwsr-translate") ?></span></label>

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
                                                    else $itype = "table";
                                                    ?>
                                                    <span class="scwatbwsr_prices_item">
														<span class="scwatbwsr_prices_item_head"><?php echo esc_attr($type->name) . " " . esc_html__("price", "scwatbwsr-translate") ?></span>
														<input class="scwatbwsr_prices_item_typeid" type="hidden"
                                                               value="<?php echo esc_attr($type->id) ?>">
														<input class="scwatbwsr_prices_item_price" type="text"
                                                               value="<?php echo esc_attr($pri) ?>">
														<select class="scwatbwsr_prices_item_type">
															<option checked <?php if ($itype == "table") echo "selected" ?> value="table"><?php echo esc_html__("Per Table", "scwatbwsr-translate") ?></option>
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

                                                            $style = 'background: ' . $type[0]->tbbg . ' none repeat scroll 0% 0% padding-box content-box;left: ' . $tleft . 'px;top: ' . $ttop . 'px;';
                                                            if ($type[0]->tbshape == "rectangular")
                                                                $style .= 'width: ' . $type[0]->tbrecwidth . 'px; height: ' . $type[0]->tbrecheight . 'px;line-height: ' . ($type[0]->tbrecheight) . 'px';
                                                            else
                                                                $style .= 'width: ' . $type[0]->tbcirwidth . 'px; height: ' . $type[0]->tbcirwidth . 'px;line-height: ' . ($type[0]->tbcirwidth) . 'px;border-radius: ' . $type[0]->tbcirwidth . 'px';
                                                            ?>
                                                            <span class="scwatbwsr_mapping_table"
                                                                  style="<?php echo esc_attr($style) ?>">

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

                                    <a href="<?php echo admin_url('admin.php?page=scwatbwsr-table-booking') ?>&action=download_csv&_wpnonce=<?php echo wp_create_nonce('download_csv') ?>&eventid=all" class="page-title-action">CSV Download Alle Bestellungen</a>

                                    <label for="event-select">Event auswählen:</label>

                                    <select name="event-selection" id="event-select"
                                            data-room="<?php echo esc_attr($room->id) ?>">
                                        <option value="">--Please choose an option--</option>
                                        <?php
                                        $posts_events = get_posts([
                                            'post_type' => 'events',
                                            'numberposts' => -1
                                        ]);
                                        foreach ($posts_events as $event) {
                                            ?>
                                            <option value="<?php echo $event->ID ?>"><?php echo get_the_title($event->ID) ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <?php

                                    $posts_events = get_posts([
                                        'post_type' => 'events',
                                        'numberposts' => -1
                                    ]);
                                    foreach ($posts_events as $event) {
                                        $proID = $event->ID;
                                        //orders
                                        $getOrdersSql = $wpdb->prepare("SELECT * from {$ordersTb} where productId=%s", $proID);
                                        $orders = $wpdb->get_results($getOrdersSql);

                                        //tables
                                        $tablesTb = $wpdb->prefix . 'scwatbwsr_tables';
                                        $getTablesSql = $wpdb->prepare("SELECT * from {$tablesTb} where roomid=%d", $room->id);
                                        $tables = $wpdb->get_results($getTablesSql);

                                        ?>
                                        <div class="scwatbwsr_event" data-id="<?php echo $proID; ?>">
                                            <div class="scwatbwsr_event_name"> <?php echo $event->post_title . "(" . $proID . ")";?> </div>
                                            <span class="scwatbwsr_orders">
                                            <?php
                                            foreach ($orders as $order) {
                                                ?>
                                                <span class="scwatbwsr_orders_item">
                                                <input class="scwatbwsr_oitem scwatbwsr_orders_item_oid" type="hidden" value="<?php echo esc_attr($order->id) ?>">
                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_head"><?php echo esc_html__("Order: ", "scwatbwsr-translate") ?></span>

                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_id"><?php echo esc_attr(str_replace(",", " ", $order->id)) ?></span>
                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_seats"><?php echo esc_attr(str_replace(",", " ", $order->seats)) ?></span>
                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_name"><?php echo esc_attr(str_replace(",", " ", $order->name)) ?></span>
                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_email"><?php echo esc_attr(str_replace(",", " ", $order->email)) ?></span>
                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_numPersons"><?php echo esc_attr(str_replace(",", " ", $order->numberPersons)) ?></span>
                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_total"><?php echo esc_attr(str_replace(",", " ", $order->total)) ?></span>
                                                <span class="scwatbwsr_oitem scwatbwsr_orders_item_del"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
                                                </span>
                                                <?php
                                            }
                                            ?>
                                            </span>
                                            <span class="scwatbwsr_bktables">
                                            <?php
                                            if ($tables) {
                                                foreach ($tables as $table) {

                                                    $getBookedSql = $wpdb->prepare("SELECT * from {$bookedTB} where roomid=%d and tb=%s and proid=%d", $room->id, $table->label, $proID);
                                                    $bookedseat = $wpdb->get_results($getBookedSql);
                                                    ?>
                                                    <span class="scwatbwsr_bktables_seat">
                                                        <span class="scwatbwsr_bktables_seat_name"><?php echo esc_attr($table->label) ?></span>
                                                        <span class="scwatbwsr_bktables_seat_make">
                                                            <label><?php echo esc_html__("Mark as booked", "scwatbwsr-translate") ?></label>
                                                            <input <?php if ($bookedseat) echo "checked" ?> type="checkbox"
                                                                                                            class="scwatbwsr_bktables_seat_make_input">
                                                        </span>
                                                    </span>
                                                    <span style="float: left;width: 100%;font-weight: bold;">--------------------------------</span>
                                                    <?php
                                                }
                                            }
                                            ?>
                                             </span>
                                            <a href="<?php echo admin_url('admin.php?page=scwatbwsr-table-booking') ?>&action=download_csv&_wpnonce=<?php echo wp_create_nonce('download_csv') ?>&eventid=<?php echo $proID ?>" class="page-title-action">CSV Download <?php echo $event->post_title ?> </a>
                                        </div>
                                        <?php
                                    }
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