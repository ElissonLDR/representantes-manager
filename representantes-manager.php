<?php
/**
 * Plugin Name: Representantes Manager
 * Description: Gerenciamento de cidades e representantes (many-to-many)
 * Version: 1.0.0
 * Author: Elisson
 */

if (!defined('ABSPATH')) exit;

// Constantes
define('RM_PATH', plugin_dir_path(__FILE__));
define('RM_URL', plugin_dir_url(__FILE__));
define('RM_VERSION', '1.0.0');

// Includes principais
require_once RM_PATH . 'includes/install.php';
require_once RM_PATH . 'includes/db.php';
require_once RM_PATH . 'includes/admin-menu.php';

// Ativação segura
register_activation_hook(__FILE__, 'rm_install_safe');

function rm_install_safe() {
    if (!function_exists('rm_install')) return;

    try {
        rm_install();
    } catch (Throwable $e) {
        error_log('RM Install Error: ' . $e->getMessage());
    }
}