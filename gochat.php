<?php
/**
 * @package GoChat
 */
/*
Plugin Name: GoChat
Plugin URI: http://gochat.us/
Description: GoChat enables chatting with your site visitors
Version: 1.0.0
Author: GoChat, Inc.
Author URI: http://gochat.us/wordpress
License: BSD License
*/

define('GOCHAT_VERSION', 'WP-1.0.0');
define('GOCHAT_DIR', dirname(__FILE__));

// Make sure we don't expose any info if called directly
if (!function_exists( 'add_action' )) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

if (is_admin()) {
	require_once GOCHAT_DIR . '/admin.php';
}

function gochat_headers($headers) {
    $headers['GoChat'] = GOCHAT_VERSION;
    return $headers;
}

function gochat_get($name) {
    if (is_admin() && count($_POST) > 0 && isset($_POST[$name])) {
        return $_POST[$name] == 'true';
    }
    return get_option($name, 'true') == 'true';
}

function gochat_main() {
    if (is_admin() && !gochat_get('gochat_enable_admin'))  return;
    $opts = http_build_query(array(
        'video' => gochat_get('gochat_enable_video') ? 'yes' : 'no',
    )) . '&';
    wp_enqueue_script('wp-gochat', 'https://gochat.us/chat.js?' . $opts, false, false, true);
}

add_filter('wp_headers', 'gochat_headers');
add_filter('init', 'gochat_main');
