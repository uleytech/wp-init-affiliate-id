<?php
/**
 * Plugin Name: Init Affiliate ID
 * Version: 1.1.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Plugin URI: https://github.com/uleytech/wp-init-affiliate-id
 * Description: Provides functionality with Affiliate for WordPress.
 * Text Domain: wp-init-affiliate-id
 * Domain Path: /languages/
 * Author: Oleksandr Krokhin
 * Author URI: https://www.krohin.com
 * License: MIT
 */

require_once __DIR__ . '/options.php';
require_once __DIR__ . '/update.php';

if (is_admin()) {
    new IaiUpdater(
        __FILE__,
        'uleytech',
        "wp-init-affiliate-id"
    );
}

function iaiSettingsLink($links)
{
    $url = esc_url(add_query_arg(
        'page',
        'wp-init-affiliate-id',
        get_admin_url() . 'options-general.php'
    ));
    $link[] = "<a href='$url'>" . __('Settings') . '</a>';


    return array_merge($link, $links);
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'iaiSettingsLink');

function init_aff_cookie()
{
    $refId = $_GET['aid'] ?? null;
    $options = get_option('wp_init_affiliate_id_options');
    $expiredAt = esc_attr($options['expired_at'] ?? 30);
    $affId = esc_attr($options['aff_id'] ?? null);
    if (!isset($_COOKIE['aid'])) {
        $cid = $refId ?? $affId;
        setcookie('aid', $cid, time() + 60 * 60 * 24 * $expiredAt, COOKIEPATH, COOKIE_DOMAIN, false);
    }
}
add_action('init', 'init_aff_cookie');