<span class="scwatbwsr_orders_item">
    <input class="scwatbwsr_orders_item_oid" type="hidden"
           value="<?php echo esc_attr($order->id) ?>">
    <span class="scwatbwsr_orders_item_head"><?php echo esc_html__("Order: ", "scwatbwsr-translate") ?></span>

    <span class="scwatbwsr_orders_item_seats"><?php echo esc_attr(str_replace(",", " ", $order->seats)) ?></span>
    <span class="scwatbwsr_orders_item_schedule"><?php if ($order->schedule) echo esc_attr($order->schedule) ?></span>
    <?php if ($order->name) { ?>
        <span class="scwatbwsr_orders_item_name"><?php if ($order->name) echo esc_attr($order->name) ?></span>
    <?php } ?>
    <?php if ($order->address) { ?>
        <span class="scwatbwsr_orders_item_address"><?php if ($order->address) echo esc_attr($order->address) ?></span>
    <?php } ?>
    <?php if ($order->email) { ?>
        <span class="scwatbwsr_orders_item_email"><?php if ($order->email) echo esc_attr($order->email) ?></span>
    <?php } ?>
    <?php if ($order->phone) { ?>
        <span class="scwatbwsr_orders_item_phone"><?php if ($order->phone) echo esc_attr($order->phone) ?></span>
    <?php } ?>
    <?php if ($order->note) { ?>
        <span class="scwatbwsr_orders_item_note"><?php if ($order->note) echo esc_attr($order->note) ?></span>
    <?php } ?>
    <?php if ($order->total) { ?>
        <span class="scwatbwsr_orders_item_total"><?php if ($order->total) echo esc_attr("$" . $order->total) ?></span>
    <?php } ?>
    <span class="scwatbwsr_orders_item_del"><i
            class="fa fa-trash-o"
            aria-hidden="true"></i> <?php echo esc_html__("Delete", "scwatbwsr-translate") ?></span>
</span>




