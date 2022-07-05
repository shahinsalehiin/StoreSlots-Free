<div class="tab_body_title">
    <h1><?php echo __('Pickup Date Settings', 'store-slots'); ?></h1>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Pickup Date Label', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="text" id="storeslots_pickup_date_label" readonly>
            </div>
            <small class="storeslots-hints"><?php echo __('Pickup date input field.', 'store-slots'); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Pickup in Next Available Days', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="number" name="ssp_available_days"
                    id="storeslots_pickup_available_days"
                    value="<?php echo !empty($this->storeslot_settings) && !empty($this->storeslot_settings['ssp_available_days']) ? esc_attr($this->storeslot_settings['ssp_available_days']) : ''; ?>"
                    placeholder="">
            </div>
            <small class="storeslots-hints"><?php echo __('User can specify next available days.', 'store-slots');?></small>
        </div>
    </div>
</div>


<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Week Starts From', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <select class="storeslots_select_control storeslots_select2">
                    <option disabled>Select Day</option>
                    <option disabled>Saturday</option>
                    <option selected disabled>Sunday</option>
                    <option disabled>Monday</option>
                    <option disabled>Tuesday</option>
                    <option disabled>Wednesday</option>
                    <option disabled>Thursday</option>
                    <option disabled>Friday </option>
                </select>
            </div>
        </div>
        <small><?php echo __('Delivery dates will be start from the day that is selected.', 'store-slots'); ?></small>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Pickup Date Format', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                
                <select id="storeslots_date_formet"
                    class="storeslots_select_control storeslots_select2">
                    <option disabled>Select Date format</option>
                    <option selected disabled>Y-m-d (ex. <?php echo date( 'Y-m-d' ); ?>)</option>
                    <option disabled>F j, Y (ex. <?php echo date( 'F j, Y' ); ?>)</option>
                    <option disabled>d-m-Y (ex. <?php echo date( 'd-m-y' ); ?>)</option>
                    <option disabled>m/d/Y (ex. <?php echo date( 'm/d/Y' ); ?>)</option>
                    <option disabled>d.m.Y (ex. <?php echo date( 'd.m.Y' ); ?>)</option>
                </select>
            </div>
        </div>
        <small><?php echo __('Select delivery date format.', 'store-slots'); ?></small>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Auto Select 1st Available Date ?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="enable_pickup_autoselect_first_date" class=""
                        name="enable_pickup_autoselect_first_date" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['enable_pickup_autoselect_first_date']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small class="storeslots-hints"><?php echo __('Enable the option if you want to select the first available date.', 'store-slots');?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Pickup Days ?', 'store-slots'); ?></h4>
    </div>
    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <?php                                                                                 
                    $storeslots_pickup_days = !empty($this->storeslot_settings) && !empty($this->storeslot_settings['storeslots_pickup_days']) ? explode(',', esc_attr($this->storeslot_settings['storeslots_pickup_days'])) : array();
                ?>
                <div class="pickup_days_wrapper">
                    <input type="checkbox" name="storeslots_pickup_days" value="saturday"
                        <?php echo (!empty($storeslots_pickup_days) && in_array('saturday', $storeslots_pickup_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_pickup_days_label">Saturday</label><br>
                    <input type="checkbox" name="storeslots_pickup_days" value="sunday"
                        <?php echo (!empty($storeslots_pickup_days) && in_array('sunday', $storeslots_pickup_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_pickup_days_label">Sunday</label><br>
                    <input type="checkbox" name="storeslots_pickup_days" value="monday"
                        <?php echo (!empty($storeslots_pickup_days) && in_array('monday', $storeslots_pickup_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_pickup_days_label">Monday</label><br>
                    <input type="checkbox" name="storeslots_pickup_days" value="tuesday"
                        <?php echo (!empty($storeslots_pickup_days) && in_array('tuesday', $storeslots_pickup_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_pickup_days_label">Tuesday</label><br>
                    <input type="checkbox" name="storeslots_pickup_days" value="wednesday"
                        <?php echo (!empty($storeslots_pickup_days) && in_array('wednesday', $storeslots_pickup_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_pickup_days_label">Wednesday</label><br>
                    <input type="checkbox" name="storeslots_pickup_days" value="thursday"
                        <?php echo (!empty($storeslots_pickup_days) && in_array('thursday', $storeslots_pickup_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_pickup_days_label">Thursday</label><br>
                    <input type="checkbox" name="storeslots_pickup_days" value="friday"
                        <?php echo (!empty($storeslots_pickup_days) && in_array('friday', $storeslots_pickup_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_pickup_days_label">Friday</label><br>
                </div>
            </div>

            <small class="storeslots-hints"><?php echo __('Pickup is only available in those days that are checked.', 'store-slots'); ?></small>
        </div>
    </div>
</div>