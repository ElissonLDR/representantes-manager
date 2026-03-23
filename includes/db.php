<?php
if (!defined('ABSPATH')) exit;

/**
 * Helpers centralizados para acesso ao banco
 */

function rm_get_table($table) {
    global $wpdb;

    $map = [
        'cidades' => $wpdb->prefix . 'rm_cidades',
        'representantes' => $wpdb->prefix . 'rm_representantes',
        'rel' => $wpdb->prefix . 'rm_representantes_cidades'
    ];

    return $map[$table] ?? null;
}

/**
 * Sanitização padrão
 */
function rm_sanitize_text($value) {
    return sanitize_text_field($value ?? '');
}

function rm_sanitize_email($value) {
    return sanitize_email($value ?? '');
}

/**
 * Log seguro (debug)
 */
function rm_log($message) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('[RM] ' . print_r($message, true));
    }
}