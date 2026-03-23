<?php
if (!defined('ABSPATH')) exit;

function rm_install() {
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();

    $table_cidades = $wpdb->prefix . 'rm_cidades';
    $table_representantes = $wpdb->prefix . 'rm_representantes';
    $table_rel = $wpdb->prefix . 'rm_representantes_cidades';

    // CIDADES
    $sql_cidades = "CREATE TABLE $table_cidades (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        nome VARCHAR(120) NOT NULL,
        estado VARCHAR(2) DEFAULT 'RS',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // REPRESENTANTES
    $sql_representantes = "CREATE TABLE $table_representantes (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        nome VARCHAR(150) NOT NULL,
        telefone VARCHAR(20),
        email VARCHAR(150),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // RELACIONAMENTO (IMPORTANTE)
    $sql_rel = "CREATE TABLE $table_rel (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        representante_id BIGINT UNSIGNED NOT NULL,
        cidade_id BIGINT UNSIGNED NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY unique_rel (representante_id, cidade_id)
    ) $charset_collate;";

    dbDelta($sql_cidades);
    dbDelta($sql_representantes);
    dbDelta($sql_rel);
}