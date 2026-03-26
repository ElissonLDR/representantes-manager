<?php
if (!defined('ABSPATH')) exit;

/**
 * Registro dos widgets no Elementor
 */
add_action('elementor/widgets/register', 'rm_register_elementor_widgets');

function rm_register_elementor_widgets($widgets_manager) {

    // Evita erro se Elementor não estiver ativo
    if (!did_action('elementor/loaded')) return;

    require_once RM_PATH . 'elementor/widget-sidebar.php';
    require_once RM_PATH . 'elementor/widget-cards.php';
    require_once RM_PATH . 'elementor/widget-busca.php';

    try {
        $widgets_manager->register(new \RM_Widget_Sidebar());
        $widgets_manager->register(new \RM_Widget_Cards());
        $widgets_manager->register(new \RM_Widget_Busca());
    } catch (Throwable $e) {
        error_log('RM Elementor Error: ' . $e->getMessage());
    }
}

add_action('elementor/frontend/after_enqueue_styles', function(){
    wp_enqueue_style('rm-style', RM_URL . 'assets/css/style.css', [], RM_VERSION);
});

add_action('elementor/frontend/after_enqueue_scripts', function(){
    wp_enqueue_script('rm-script', RM_URL . 'assets/js/script.js', [], RM_VERSION, true);
});