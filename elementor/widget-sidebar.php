<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Sidebar extends Widget_Base {

    public function get_name() {
        return 'rm_sidebar';
    }

    public function get_title() {
        return 'RM - Cidades Sidebar';
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function render() {

        global $wpdb;

        $cidades_table = $wpdb->prefix . 'rm_cidades';
        $rel_table = $wpdb->prefix . 'rm_representantes_cidades';

        $cidades = $wpdb->get_results("
            SELECT c.id, c.nome, COUNT(rc.representante_id) as total
            FROM $cidades_table c
            LEFT JOIN $rel_table rc ON rc.cidade_id = c.id
            GROUP BY c.id
            ORDER BY c.nome ASC
        ");

        if (!$cidades) return;

        echo '<div class="rm-sidebar">';

        foreach ($cidades as $cidade) {

            echo '<div class="rm-sidebar-item" data-id="' . esc_attr($cidade->id) . '">';
            echo '<span class="rm-cidade">' . esc_html($cidade->nome) . '</span>';
            echo '<span class="rm-total">' . intval($cidade->total) . '</span>';
            echo '</div>';
        }

        echo '</div>';
    }
}