<?php
/**
 * Plugin Name: Init Affiliate ID
 * Version: 1.0.0.
 * Description: Provides functionality for WordPress.
 * License: MIT
 */

require_once(__DIR__ . '/options.php');

function init_aff_cookie()
{
    $refId = $_GET['aid'] ?? null;
    $options = get_option('wp_init_affiliate_id_options');
    $affId = esc_attr($options['aff_id']) ?? 65514;
    $expired = esc_attr($options['expired']) ?? 30;
    if (!isset($_COOKIE['aid'])) {
        $cid = $refId ?? $affId;
        setcookie('aid', $cid, time() + 60 * 60 * 24 * $expired, COOKIEPATH, COOKIE_DOMAIN, false);
    }
}

add_action('init', 'init_aff_cookie');