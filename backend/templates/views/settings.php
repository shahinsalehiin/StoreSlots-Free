<div id="storeslots_dashboard">

    <form class="storeslots-settings-form" id="storeslots_settings_form">

        <div class="storeslots_content_wrapper">

            <div class="storeslots_bottom_form">
                <div class="content_wrapper">
                    <div class="storeslots_left_content">
                        <div class="storeslots_data_tabs">
                            <div class="tab_item tab_item_active" data-target="order_settings">
                                <h3> <?php _e('Order Settings', 'store-slots'); ?> </h3>
                            </div>
                            <div class="tab_item" data-target="delivery_date_settings">
                                <h3> <?php _e('Date of Delivery ', 'store-slots'); ?> </h3>
                            </div>
                            <div class="tab_item" data-target="pickup_date_settings">
                                <h3> <?php _e('Date of Pickup ', 'store-slots'); ?> </h3>
                            </div>
                            <div class="tab_item" data-target="delivery_time_settings">
                                <h3> <?php _e('Time of Delivery', 'store-slots'); ?> </h3>
                            </div>
                            <div class="tab_item" data-target="pickup_time_settings">
                                <h3> <?php _e('Time of Pickup', 'store-slots'); ?> </h3>
                            </div>
                        </div>
                    </div>

                    <div class="storeslots_right_content">
                        <div data-id="order_settings" class="storeslots_tab_body">
                            <?php include STORESLOTS_PATH . "backend/templates/views/order-settings.php"; ?>
                        </div>

                        <div data-id="delivery_date_settings" class="storeslots_tab_body">
                            <?php include STORESLOTS_PATH . "backend/templates/views/delivery-date-settings.php"; ?>
                        </div>

                        <div data-id="pickup_date_settings" class="storeslots_tab_body">
                           <?php include STORESLOTS_PATH . "backend/templates/views/pickup-date-settings.php"; ?>
                        </div>

                        <div data-id="delivery_time_settings" class="storeslots_tab_body">
                            <?php include STORESLOTS_PATH . "backend/templates/views/delivery-time-settings.php"; ?>
                        </div>

                        <div data-id="pickup_time_settings" class="storeslots_tab_body">
                            <?php include STORESLOTS_PATH . "backend/templates/views/pickup-time-settings.php"; ?>
                        </div>

                    </div>
                </div>

                <div class="storeslots_footer">

                    <button type="submit" class="storeslots-btn"> <?php echo __('Save Settings', 'store-slots'); ?>
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>