<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Sidebar extends Widget_Base {

    protected function register_controls() {

        // LAYOUT
        $this->start_controls_section(
            'section_layout',
            [
                'label' => 'Layout',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $this->end_controls_section();
    
        // ESTILO
        $this->start_controls_section(
            'section_style',
            [
                'label' => 'Estilo',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // TIPOGRAFIA
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}}',
            ]
        );
    
        // COR TEXTO
        $this->add_control(
            'text_color',
            [
                'label' => 'Cor do texto',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    }

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

        echo '<div class="rm-sidebar-item active" data-id="all">';
        echo '<span class="rm-cidade">Todos</span>';
        echo '</div>';

        foreach ($cidades as $cidade) {

            echo '<div class="rm-sidebar-item" data-id="' . esc_attr($cidade->id) . '">';
            echo '<span class="rm-cidade">' . esc_html($cidade->nome) . '</span>';
            echo '<span class="rm-total">' . intval($cidade->total) . '</span>';
            echo '</div>';
        }

        echo '</div>';
    }
}

