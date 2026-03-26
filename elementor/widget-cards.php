<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Cards extends Widget_Base {

<<<<<<< HEAD
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

=======
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
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

<<<<<<< HEAD
            $cidades = $wpdb->get_results($wpdb->prepare(
                "SELECT c.id, c.nome 
=======
            $cidades = $wpdb->get_col($wpdb->prepare(
                "SELECT c.nome 
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
                 FROM $rel_table rc
                 JOIN $cidades_table c ON c.id = rc.cidade_id
                 WHERE rc.representante_id = %d",
                $rep->id
            ));
<<<<<<< HEAD
            
            $cidades_nomes = array_column($cidades, 'nome');
            $cidades_ids = array_column($cidades, 'id');

            echo '<div class="rm-card" data-cidades="' . esc_attr(implode(',', $cidades_ids)) . '">';
            
            echo '<h3 class="rm-nome">' . esc_html($rep->nome) . '</h3>';

            echo '<p class="rm-cidades">' . esc_html(implode(', ', $cidades_nomes)) . '</p>';

            $telefones = $wpdb->get_col($wpdb->prepare(
                "SELECT telefone FROM {$wpdb->prefix}rm_telefones WHERE representante_id = %d",
                $rep->id
            ));
            
            if ($telefones) {
                foreach ($telefones as $tel) {
                    echo '<span class="rm-telefone">' . esc_html($tel) . '</span><br>';
                }
            }

            echo '<button class="rm-ver-cidades" data-id="'.$rep->id.'">🔍</button>';

            echo '</div>';

            echo '
            <div id="rm-modal" style="display:none;">
                <div class="rm-modal-content">
                    <span class="rm-close">×</span>
                    <div id="rm-modal-cidades"></div>
                </div>
            </div>
            ';
=======

            echo '<div class="rm-card" data-cidades="' . esc_attr(implode(',', $cidades)) . '">';
            
            echo '<h3>' . esc_html($rep->nome) . '</h3>';

            echo '<p class="rm-cidades">' . esc_html(implode(', ', $cidades)) . '</p>';

            if (!empty($rep->telefone)) {
                echo '<a href="tel:' . esc_attr($rep->telefone) . '" class="rm-btn">Contato</a>';
            }

            echo '</div>';
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
        }

        echo '</div>';
    }
<<<<<<< HEAD
}

=======
}
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
