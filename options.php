<?php

function add_settings_page()
{
    add_options_page('Init Affiliate ID', 'Init Affiliate ID', 'manage_options', 'wp-init-affiliate-id', 'render_plugin_settings_page');
}

add_action('admin_menu', 'add_settings_page');

function render_plugin_settings_page()
{
    ?>
    <h2>Init Affiliate ID Settings</h2>
    <form action="options.php" method="post">
        <?php
        settings_fields('wp_init_affiliate_id_options');
        do_settings_sections('wp_init_affiliate_id'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>"/>
    </form>
    <?php
}

function register_settings()
{
    register_setting('wp_init_affiliate_id_options', 'wp_init_affiliate_id_options', 'wp_init_affiliate_id_options_validate');
    add_settings_section('api_settings', 'ID Settings', 'wp_init_affiliate_id_section_text', 'wp_init_affiliate_id');
    add_settings_field('wp_init_affiliate_idd_setting_aff_id', 'Affiliate ID', 'wp_init_affiliate_id_setting_aff_id', 'wp_init_affiliate_id', 'api_settings');
    add_settings_field('wp_init_affiliate_idd_setting_ref_id', 'Referrer ID', 'wp_init_affiliate_id_setting_ref_id', 'wp_init_affiliate_id', 'api_settings');
}

add_action('admin_init', 'register_settings');

function wp_init_affiliate_id_options_validate($input)
{
    $newinput['aff_id'] = trim($input['aff_id']);
    if (!preg_match('/^[0-9]+$/i', $newinput['aff_id'])) {
        $newinput['aff_id'] = '';
    }
    return $newinput;
}

function wp_init_affiliate_id_section_text()
{
    echo '<p>Here you can set all the options for using the Post Affiliate Pro</p>';
}

function wp_init_affiliate_id_setting_aff_id()
{
    $options = get_option('wp_init_affiliate_id_options');
    echo "<input id='wp_init_affiliate_id_setting_aff_id' name='wp_init_affiliate_id_options[aff_id]' type='text' value='" . esc_attr($options['aff_id']) . "' />";
}

function wp_init_affiliate_id_setting_ref_id()
{
    $options = get_option('wp_init_affiliate_id_options');
    echo 'https://' . $_SERVER['HTTP_HOST'] . '/?aid=' . esc_attr($options['aff_id']);
}
