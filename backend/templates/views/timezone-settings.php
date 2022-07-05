<div class="tab_body_title">
    <h1><?php echo __('Timezone Settings', 'store-slots'); ?></h1>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Store Location Timezone', 'store-slots'); ?></h4>
    </div>

    <div class="label_content">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <?php
                    $storeslots_time_timezone  = !empty($this->storeslot_settings) && !empty($this->storeslot_settings['storeslots_delivery_time_timezone']) ? esc_attr($this->storeslot_settings['storeslots_delivery_time_timezone']) : '';                                        
                ?>
                <select class="storeslots_select_control storeslots_select2" name="storeslots_delivery_time_timezone">
                    <option value=""><?php echo __('Select Timezone', 'store-slots'); ?></option>
                    <?php echo $this->utils->get_store_sloat_time_zones( $storeslots_time_timezone ); ?>

                </select>
            </div>
        </div>
    </div>
</div>