<?php
/**
 * Plugin Name: Init Affiliate ID
 * Version: 1.0.0.
 * Description: Provides functionality for WordPress.
 * License: MIT
 */

require_once(__DIR__ . '/options.php');

function init_aff_cookie() {
    $refId = $_GET['aid'] ?? null;
    $affId = 65514;
    if (!isset($_COOKIE['aid'])) {
        $cid = $refId ?? $affId;
        setcookie('aid', $cid, time()+60*60*24*30, COOKIEPATH, COOKIE_DOMAIN, false);
    }
}
add_action( 'init', 'init_aff_cookie');