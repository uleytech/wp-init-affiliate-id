<?php
/**
 * Plugin Name: Init Affiliate ID
 * Version: 1.0.1
 * Plugin URI: https://github.com/uleytech/wp-init-affiliate-id
 * Description: Provides functionality for WordPress.
 * Author: Oleksandr Krokhin
 * License: MIT
 */

require_once(__DIR__ . '/options.php');

function init_aff_cookie()
{
    $refId = $_GET['aid'] ?? null;
    $options = get_option('wp_init_affiliate_id_options');
    $affId = esc_attr($options['aff_id']) ?? 65514;
    $expiredAt = esc_attr($options['expired_at']) ?? 30;
    if (!isset($_COOKIE['aid'])) {
        $cid = $refId ?? $affId;
        setcookie('aid', $cid, time() + 60 * 60 * 24 * $expiredAt, COOKIEPATH, COOKIE_DOMAIN, false);
    }
}

add_action('init', 'init_aff_cookie');