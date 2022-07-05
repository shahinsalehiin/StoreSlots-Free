<div class="tab_body_title">
    <h1><?php echo __('Pickup Time Settings', 'store-slots'); ?></h1>
</div>


<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Pickup Time Label', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="text" id="storeslots_pickup_date_label">
            </div>
            <small
                class="storeslots-hints"><?php echo __('Pickup time select field label and placeholder.', 'store-slots'); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Time Slot Starts From', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="time" name="ssp_time_starts_from"
                    id="ssp_time_starts_from"
                    value="<?php echo !empty($this->storeslot_settings) && !empty($this->storeslot_settings['ssp_time_starts_from']) ? esc_attr($this->storeslot_settings['ssp_time_starts_from']) : ''; ?>"
                    placeholder="">
            </div>
            <small
                class="storeslots-hints"><?php __('Pickup time will start from the time that specified here.'. 'store-slots');?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Time Slot Ends At', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="time" name="ssp_time_ends_from" id="ssp_time_ends_from"
                    value="<?php echo !empty($this->storeslot_settings) && !empty($this->storeslot_settings['ssp_time_ends_from']) ? esc_attr($this->storeslot_settings['ssp_time_ends_from']) : ''; ?>"
                    placeholder="">
            </div>
            <small
                class="storeslots-hints"><?php echo __('Pickup time will ends from the time that specified here.', 'store-slots'); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Time Slot Duration', 'store-slots'); ?></h4>
    </div>

    <div class="label_content">
        <div class="storeslots_list_items">
            <div class="storeslots_item ss_slot_text_control">
                <input class="storeslots_text_control  h50" type="number" name="ssp_slot_duration_time"
                    id="ssp_time_ends_from"
                    value="<?php echo !empty($this->storeslot_settings) && !empty($this->storeslot_settings['ssp_slot_duration_time']) ? $this->storeslot_settings['ssp_slot_duration_time'] : ''; ?>"
                    placeholder="">
                <?php
                    $ssp_slot_duration_type  = !empty($this->storeslot_settings) && !empty($this->storeslot_settings['ssp_slot_duration_type']) ? esc_attr($this->storeslot_settings['ssp_slot_duration_type']) : '';                                        
                    ?>

                <select name="ssp_slot_duration_type" class="storeslots_select_control">
                    <option value="">Select </option>
                    <option value="minutes"
                        <?php echo 'minutes' == esc_attr($ssp_slot_duration_type) ? 'selected' : '' ; ?>>
                        Minutes</option>
                    <option value="hour" <?php echo 'hour' == esc_attr($ssp_slot_duration_type) ? 'selected' : '' ; ?>>
                        Hour
                    </option>
                </select>

            </div>
            <small
                class="storeslots-hints"><?php echo __('Pickup duration will specified from here.', 'store-slots');?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Maximum Pickup Per Time Slot ', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control  h50" type="number" id="ssp_time_maximum_order" readonly>
            </div>
            <small class="storeslots-hints"><?php echo __('Each time slot takes maximum number of orders that is specified
                here.', 'store-slots');?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Time Format', 'store-slots'); ?></h4>
    </div>

    <div class="label_content">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <?php
                    $ssp_time_format  = !empty($this->storeslot_settings) && !empty($this->storeslot_settings['ssp_time_format']) ? esc_attr($this->storeslot_settings['ssp_time_format']) : '';                                        
                ?>
                <select name="ssp_time_format" class="storeslots_select_control">
                    <option value="">Select Time Format</option>
                    <option value="12" <?php echo 12 == esc_attr($ssp_time_format) ? 'selected' : '' ;?>> 12 Hours
                    </option>
                    <option value="24" <?php echo 24 == esc_attr($ssp_time_format) ? 'selected' : '' ;?>> 24 Hours
                    </option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- <div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php //echo __('Auto Select 1st Available Time  ?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="ssp_auto_select_first_date" class="storeslots_default_checked"
                        name="ssp_auto_select_first_date" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['ssp_auto_select_first_date']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small class="storeslots-hints"><?php echo __('Enable if you want to auto select the first time slot.', 'store-slots');?></small>
        </div>
    </div>
</div> -->