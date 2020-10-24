<?php

function iai_add_settings_page()
{
    add_options_page(__('Init Affiliate ID', 'wp-init-affiliate-id'), __('Init Affiliate ID', 'wp-init-affiliate-id'), 'manage_options', 'wp-init-affiliate-id', 'iai_render_plugin_settings_page');
}

add_action('admin_menu', 'iai_add_settings_page');

function iai_render_plugin_settings_page()
{
    ?>
    <h2><?php _e('Init Affiliate ID Settings', 'wp-init-affiliate-id') ?></h2>
    <form action="options.php" method="post">
        <?php
        settings_fields('wp_init_affiliate_id_options');
        do_settings_sections('wp_init_affiliate_id'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>"/>
    </form>
    <?php
}

function iai_register_settings()
{
    register_setting('wp_init_affiliate_id_options', 'wp_init_affiliate_id_options', 'wp_init_affiliate_id_options_validate');
    add_settings_section('api_settings', __('ID Settings', 'wp-init-affiliate-id'), 'wp_init_affiliate_id_section_text', 'wp_init_affiliate_id');
    add_settings_field('wp_init_affiliate_idd_setting_aff_id', __('Affiliate ID', 'wp-init-affiliate-id'), 'wp_init_affiliate_id_setting_aff_id', 'wp_init_affiliate_id', 'api_settings');
    add_settings_field('wp_init_affiliate_idd_setting_expired_at', __('Expired', 'wp-init-affiliate-id'), 'wp_init_affiliate_id_setting_expired_at', 'wp_init_affiliate_id', 'api_settings');
    add_settings_field('wp_init_affiliate_idd_setting_ref_id', __('Referrer ID', 'wp-init-affiliate-id'), 'wp_init_affiliate_id_setting_ref_id', 'wp_init_affiliate_id', 'api_settings');

}

add_action('admin_init', 'iai_register_settings');

function wp_init_affiliate_id_options_validate($input)
{
    $newinput['aff_id'] = trim($input['aff_id']);
    if (!preg_match('/^[0-9]+$/i', $newinput['aff_id'])) {
        $newinput['aff_id'] = '';
    }
    $newinput['expired_at'] = trim($input['expired_at']);
    if (!preg_match('/^[0-9]+$/i', $newinput['expired_at'])) {
        $newinput['expired_at'] = '';
    }
    return $newinput;
}

function wp_init_affiliate_id_section_text()
{
    echo '<p>' . __('Here you can set all the options for using the Post Affiliate Pro', 'wp-init-affiliate-id') . '</p>';
}

function wp_init_affiliate_id_setting_aff_id()
{
    $options = get_option('wp_init_affiliate_id_options');
    echo "<input id='wp_init_affiliate_id_setting_aff_id' name='wp_init_affiliate_id_options[aff_id]' type='text' class='' value='" . esc_attr($options['aff_id'] ?? '') . "' />";
}

function wp_init_affiliate_id_setting_ref_id()
{
    $options = get_option('wp_init_affiliate_id_options');
    echo 'https://' . $_SERVER['HTTP_HOST'] . '/?aid=' . esc_attr($options['aff_id'] ?? 'xxxxx');
}

function wp_init_affiliate_id_setting_expired_at()
{
    $options = get_option('wp_init_affiliate_id_options');
    echo "<input id='wp_init_affiliate_id_setting_expired_at' name='wp_init_affiliate_id_options[expired_at]' type='number' class='small-text'  value='" . esc_attr($options['expired_at'] ?? '') . "' />
        <span>" . __('day(s)', 'wp-init-affiliate-id') . "</span>";
}
