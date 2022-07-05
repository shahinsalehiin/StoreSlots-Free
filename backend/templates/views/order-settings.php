<div class="tab_body_title">
    <h1><?php echo __('Order Settings', 'store-slots'); ?></h1>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Enable Delivery or Pickup?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="storeslots_enable_delivery_or_pickup" class="storeslots_default_checked"
                        name="storeslots_enable_delivery_or_pickup" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['storeslots_enable_delivery_or_pickup']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small class="storeslots-hints"><?php echo __('Enable if you want home delivery or picks orderd product from a pickup
                location.', 'store-slots' ); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Enable Delivery Date?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="storeslots_enable_delivery_date" class="storeslots_default_checked"
                        name="storeslots_enable_delivery_date" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['storeslots_enable_delivery_date']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small
                class="storeslots-hints"><?php echo __('Enable delivery date in storecommerce order checkout page.', 'store-slots'); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Enable Delivery Time?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="storeslots_enable_delivery_time" class="storeslots_default_checked"
                        name="storeslots_enable_delivery_time" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['storeslots_enable_delivery_time']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small class="storeslots-hints"><?php echo __('Enable delivery time select field in woocommerce order checkout
                page.', 'store-slots' );?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Enable Pickup Date?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="storeslots_enable_pickup_date" class="storeslots_default_checked"
                        name="storeslots_enable_pickup_date" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['storeslots_enable_pickup_date']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small
                class="storeslots-hints"><?php echo __('Enable pickup date in storecommerce order checkout page.', 'store-slots');?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Enable Pickup Time?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="storeslots_enable_pickup_time" class="storeslots_default_checked"
                        name="storeslots_enable_pickup_time" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['storeslots_enable_pickup_time']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small
                class="storeslots-hints"><?php echo __('Enable pickup time select field in woocommerce order checkout page.', 'store-slots'); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Order Type Label', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="text" readonly>
            </div>
            <small class="storeslots-hints">Order type field label</small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Delivery Option Label', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="text" readonly>
            </div>
            <small
                class="storeslots-hints"><?php echo __("Order type's delivery option name.", 'store-slots' ); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Pickup Option Label', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="text" readonly>
            </div>
            <small
                class="storeslots-hints"><?php echo __("Order type's pickup option name." , 'store-slots'); ?></small>
        </div>
    </div>
</div>