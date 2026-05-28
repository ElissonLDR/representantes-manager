<?php
/**
 * Plugin Name: Representantes Manager
 * Description: Gerenciamento de cidades e representantes (many-to-many)
 * Version: 1.0.3
 * Author: Elisson Rodrigues
 * Text Domain: representantes-manager
 */

if (!defined('ABSPATH')) exit;

define('RM_PATH', plugin_dir_path(__FILE__));
define('RM_URL', plugin_dir_url(__FILE__));
define('RM_VERSION', '1.0.3');

require_once RM_PATH . 'includes/capabilities.php';
require_once RM_PATH . 'includes/install.php';
require_once RM_PATH . 'includes/db.php';
require_once RM_PATH . 'includes/admin-menu.php';

if (file_exists(RM_PATH . 'elementor/widgets.php')) {
    require_once RM_PATH . 'elementor/widgets.php';
}

register_activation_hook(__FILE__, 'rm_on_activate');
add_action('plugins_loaded', 'rm_maybe_upgrade', 20);

function rm_on_activate() {
    rm_grant_default_caps();
    rm_run_install();
}

function rm_run_install() {
    if (!function_exists('rm_install')) {
        return;
    }

    try {
        rm_install();
        update_option('rm_db_version', RM_VERSION);
    } catch (Exception $e) {
        error_log('RM Install Error: ' . $e->getMessage());
    }
}

function rm_maybe_upgrade() {
    $installed = get_option('rm_db_version', '0');

    if (version_compare($installed, RM_VERSION, '>=')) {
        return;
    }

    rm_grant_default_caps();
    rm_run_install();
}
