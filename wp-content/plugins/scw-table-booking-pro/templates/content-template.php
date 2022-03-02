<?php
$getRoomDataSql = $wpdb->prepare("SELECT * from {$tableRooms} where id=%d", $roomid);
$roomData = $wpdb->get_results($getRoomDataSql);

$getTypeSql = $wpdb->prepare("SELECT * from {$tableTypes} where roomid=%d", $roomid);
$types = $wpdb->get_results($getTypeSql);

$getSchedulesSql = $wpdb->prepare("SELECT * from {$tableSchedules} where roomid=%d", $roomid);
$checkSchedules = $wpdb->get_results($getSchedulesSql);

if (isset($roomData[0]->tbbookedcolor))
    $tbbookedcolor = $roomData[0]->tbbookedcolor;
else
    $tbbookedcolor = "#000";
if (isset($roomData[0]->seatbookedcolor))
    $seatbookedcolor = $roomData[0]->seatbookedcolor;
else
    $seatbookedcolor = "#000";

$getTablesSql = $wpdb->prepare("SELECT * from {$tablesTb} where roomid=%d", $roomid);
$tables = $wpdb->get_results($getTablesSql);

$bookedSeats = array();
$getOrdersSql = $wpdb->prepare("SELECT * from {$ordersTb} where productId=%d", $proId);
$orders = $wpdb->get_results($getOrdersSql);
if ($orders) {
    foreach ($orders as $order) {
        $oseats = explode(",", $order->seats);
        foreach ($oseats as $os) {
            array_push($bookedSeats, $os);
        }
    }
}
$getBookedSql = $wpdb->prepare("SELECT * from {$bookedTB} where roomid=%d and proid=%d", $roomid, $proId);
$bookeds = $wpdb->get_results($getBookedSql);
if ($bookeds) {
    foreach ($bookeds as $bk) {
        array_push($bookedSeats, $bk->tb . "." . $bk->seat);
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
        if ($types) {
            foreach ($types as $type) {
                $getPriceSql = $wpdb->prepare("SELECT * from {$pricesTb} where typeid=%d", $type->id);
                $price = $wpdb->get_results($getPriceSql);
                ?>
                <span class="scwatbwsr_types_item">
							<span class="scwatbwsr_types_item_name"><b><?php echo esc_attr($type->name) ?></b></span>
							<span class="scwatbwsr_types_item_bg"
                                  style="background: <?php echo esc_attr($type->tbbg) ?>">bg</span>
							<?php
                            if ($price && $price[0]->price) {
                                if ($price[0]->type == "seat") $pricetype = esc_html__("per seat", "scwatbwsr-translate");
                                elseif ($price[0]->type == "table") $pricetype = esc_html__("per table", "scwatbwsr-translate");
                                elseif ($price[0]->type == "time") $pricetype = esc_html__("one time for all", "scwatbwsr-translate");
                                ?>
                                <span class="scwatbwsr_types_item_price">(<?php echo esc_attr($currencyS . $price[0]->price . " " . $pricetype) ?>)</span>
                            <?php } ?>
						</span>
                <?php
            }
        }
        ?>
        <span class="scwatbwsr_types_item">
					<span class="scwatbwsr_types_item_name"><b><?php echo esc_html__("Booked Table", "scwatbwsr-translate") ?></b></span>
					<span class="scwatbwsr_types_item_bg"
                          style="background: <?php echo esc_attr($tbbookedcolor) ?>">bg</span>
				</span>
    </div>

    <?php
    $event_date = get_field("event_date");
    ?>

    <div class="scwatbwsr_schedule_item" style="display: none;"
         data-date="<?php echo $event_date ?>"> <?php echo $event_date ?> </div>

    <div class="scwatbwsr_map">
        <div class="scwatbwsr_map_head"><?php echo esc_html__("Choose your Seats", "scwatbwsr-translate") ?></div>
        <div class="scwatbwsr_map_zoom">
            <span id="scwatbwsr_map_zoom-in"><?php echo esc_html__("Zoom In", "scwatbwsr-translate") ?></span>
            <span id="scwatbwsr_map_zoom-out"><?php echo esc_html__("Zoom Out", "scwatbwsr-translate") ?></span>
            <span id="scwatbwsr_map_zoom_reset"><?php echo esc_html__("Reset", "scwatbwsr-translate") ?></span>
        </div>
        <div class="scwatbwsr_map_block">
            <div id="scwatbwsr_map_panzoom">
                <div class="scwatbwsr_map_bg"
                     style="width: <?php echo esc_attr($roomData[0]->width) ?>px; height: <?php echo esc_attr($roomData[0]->height) ?>px">

                    <?php
                    if (isset($roomData[0]->roombg)) {
                        ?><img class="scwatbwsr_map_bg_img"
                               src="<?php echo esc_attr($roomData[0]->roombg) ?>"><?php
                    } else {
                        ?><span class="scwatbwsr_map_bg_color"
                                style="background: <?php echo esc_attr($roomData[0]->roomcolor) ?>">
                            .</span><?php
                    }
                    ?>
                    <div class="scwatbwsr_map_tables">
                        <?php
                        if ($tables) {
                            foreach ($tables as $table) {
                                $getType = $wpdb->prepare("SELECT * from {$tableTypes} where id=%d", $table->type);
                                $type = $wpdb->get_results($getType);

                                $seats = explode(",", $table->seats);
                                if ($seats) {
                                    $tmpArr = array();
                                    foreach ($seats as $seat) {
                                        array_push($tmpArr, $table->label . "." . $seat);
                                    }
                                    $checkSame = array_intersect($bookedSeats, $tmpArr);
                                    if (count($seats) == count($checkSame))
                                        $tbcolor = $tbbookedcolor;
                                    else
                                        $tbcolor = $type[0]->tbbg;
                                } else
                                    $tbcolor = $type[0]->tbbg;

                                if ($table->tleft) $tleft = $table->tleft;
                                else $tleft = 0;

                                if ($table->ttop) $ttop = $table->ttop;
                                else $ttop = 0;

                                $padding = $type[0]->seatwidth + 2;

                                $style = 'background: ' . $tbcolor . ' none repeat scroll 0% 0% padding-box content-box;left: ' . $tleft . 'px;top: ' . $ttop . 'px;padding: ' . $padding . 'px;';
                                $labelStyle = 'top: ' . ($type[0]->seatwidth + 2) . 'px;left: ' . ($type[0]->seatwidth + 2) . 'px;';
                                if ($type[0]->tbshape == "rectangular") {
                                    $style .= 'width: ' . ($type[0]->tbrecwidth + ($type[0]->seatwidth + 2) * 2) . 'px; height: ' . ($type[0]->tbrecheight + ($type[0]->seatwidth + 2) * 2) . 'px;line-height: ' . ($type[0]->tbrecheight + ($type[0]->seatwidth + 2) * 2) . 'px';
                                    $labelStyle .= 'width: ' . $type[0]->tbrecwidth . 'px; height: ' . $type[0]->tbrecheight . 'px; line-height: ' . $type[0]->tbrecheight . 'px';
                                } else {
                                    $style .= 'width: ' . ($type[0]->tbcirwidth + ($type[0]->seatwidth + 2) * 2) . 'px; height: ' . ($type[0]->tbcirwidth + ($type[0]->seatwidth + 2) * 2) . 'px;line-height: ' . ($type[0]->tbcirwidth + ($type[0]->seatwidth + 2) * 2) . 'px;border-radius: ' . $type[0]->tbcirwidth . 'px';
                                    $labelStyle .= 'width: ' . $type[0]->tbcirwidth . 'px; height: ' . $type[0]->tbcirwidth . 'px; line-height: ' . $type[0]->tbcirwidth . 'px;border-radius: ' . $type[0]->tbcirwidth . 'px';
                                }

                                $seatstyle = '';
                                if ($type[0]->seatshape == "rectangular")
                                    $seatstyle .= 'width: ' . $type[0]->seatwidth . 'px; height: ' . $type[0]->seatwidth . 'px;line-height: ' . $type[0]->seatwidth . 'px;';
                                else
                                    $seatstyle .= 'width: ' . $type[0]->seatwidth . 'px; height: ' . $type[0]->seatwidth . 'px;line-height: ' . $type[0]->seatwidth . 'px;border-radius: ' . $type[0]->seatwidth . 'px;';

                                ?>
                                <span id="table<?php echo esc_attr($table->label) ?>"
                                      class="scwatbwsr_map_tables_table" style="<?php echo esc_attr($style) ?>">
											<input type="hidden" class="scwatbwsr_table_readcolor"
                                                   value="<?php echo esc_attr($type[0]->tbbg) ?>">
											<input type="hidden" class="scwatbwsr_seat_readcolor"
                                                   value="<?php echo esc_attr($type[0]->seatbg) ?>">
											<span class="scwatbwsr_map_tables_table_seats"
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

                                                        $newseatstyle = $seatstyle . 'left: ' . $sleft . 'px; top: ' . $stop . 'px;';

                                                        if (in_array($table->label . "." . $seat, $bookedSeats))
                                                            $newseatstyle .= 'background: ' . $seatbookedcolor . ';';
                                                        else
                                                            $newseatstyle .= 'background: ' . $type[0]->seatbg . ';';
                                                        ?><span id="seat<?php echo esc_attr($table->label . $seat) ?>"
                                                                style="<?php echo esc_attr($newseatstyle) ?>"
                                                                class="scwatbwsr_map_tables_table_seat <?php if (in_array($table->label . "." . $seat, $bookedSeats)) echo "seatbooked" ?>"><?php echo esc_attr($seat) ?></span><?php
                                                    }
                                                }
                                                ?>
											</span>
											<span style="<?php echo esc_attr($labelStyle) ?>"
                                                  class="scwatbwsr_map_tables_table_label"><?php echo esc_attr($table->label) ?></span>
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