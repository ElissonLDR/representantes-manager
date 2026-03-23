<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Cards extends Widget_Base {

    public function get_name() {
        return 'rm_cards';
    }

    public function get_title() {
        return 'RM - Cards Representantes';
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function render() {

        global $wpdb;

        $rep_table = $wpdb->prefix . 'rm_representantes';
        $rel_table = $wpdb->prefix . 'rm_representantes_cidades';
        $cidades_table = $wpdb->prefix . 'rm_cidades';

        $representantes = $wpdb->get_results("
            SELECT r.*
            FROM $rep_table r
            ORDER BY r.nome ASC
        ");

        if (!$representantes) return;

        echo '<div class="rm-cards">';

        foreach ($representantes as $rep) {

            $cidades = $wpdb->get_col($wpdb->prepare(
                "SELECT c.nome 
                 FROM $rel_table rc
                 JOIN $cidades_table c ON c.id = rc.cidade_id
                 WHERE rc.representante_id = %d",
                $rep->id
            ));

            echo '<div class="rm-card" data-cidades="' . esc_attr(implode(',', $cidades)) . '">';
            
            echo '<h3>' . esc_html($rep->nome) . '</h3>';

            echo '<p class="rm-cidades">' . esc_html(implode(', ', $cidades)) . '</p>';

            if (!empty($rep->telefone)) {
                echo '<a href="tel:' . esc_attr($rep->telefone) . '" class="rm-btn">Contato</a>';
            }

            echo '</div>';
        }

        echo '</div>';
    }
}