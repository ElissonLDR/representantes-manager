<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Sidebar extends Widget_Base {

    protected function register_controls() {

        /* ======================================================
        =============== CONTEÚDO - LAYOUT =======================
        ====================================================== */
    
        $this->start_controls_section(
            'section_layout',
            [
                'label' => 'Layout',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        // Mostrar contador
        $this->add_control(
            'show_total',
            [
                'label' => 'Mostrar contador',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Sim',
                'label_off' => 'Não',
                'default' => 'yes',
            ]
        );
    
        // Mostrar "Todos"
        $this->add_control(
            'show_all',
            [
                'label' => 'Mostrar opção "Todos"',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
    
        // Texto "Todos"
        $this->add_control(
            'text_all',
            [
                'label' => 'Texto do "Todos"',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Todos',
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTILO - CONTAINER ======================
        ====================================================== */
    
        $this->start_controls_section(
            'section_container',
            [
                'label' => 'Container',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'bg_container',
            [
                'label' => 'Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar' => 'background: {{VALUE}};'
                ],
            ]
        );
    
        $this->add_responsive_control(
            'padding_container',
            [
                'label' => 'Padding',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border_container',
                'selector' => '{{WRAPPER}} .rm-sidebar',
            ]
        );
    
        $this->add_responsive_control(
            'radius_container',
            [
                'label' => 'Border Radius',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTILO - ITENS ==========================
        ====================================================== */
    
        $this->start_controls_section(
            'section_items',
            [
                'label' => 'Itens',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // Tipografia
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .rm-sidebar-item',
            ]
        );
    
        // Espaçamento
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => 'Padding',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    
        $this->add_responsive_control(
            'item_gap',
            [
                'label' => 'Espaçamento entre itens',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTILO - ESTADOS ========================
        ====================================================== */
    
        $this->start_controls_section(
            'section_states',
            [
                'label' => 'Estados (Normal / Hover / Ativo)',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // ABAS (Normal / Hover / Active)
        $this->start_controls_tabs('tabs_states');
    
        /* -------- NORMAL -------- */
        $this->start_controls_tab('tab_normal', ['label' => 'Normal']);
    
        $this->add_control(
            'color_normal',
            [
                'label' => 'Cor do texto',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'bg_normal',
            [
                'label' => 'Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
    
    
        /* -------- HOVER -------- */
        $this->start_controls_tab('tab_hover', ['label' => 'Hover']);
    
        $this->add_control(
            'color_hover',
            [
                'label' => 'Cor',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'bg_hover',
            [
                'label' => 'Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
    
    
        /* -------- ACTIVE -------- */
        $this->start_controls_tab('tab_active', ['label' => 'Ativo']);
    
        $this->add_control(
            'color_active',
            [
                'label' => 'Cor',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item.active' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'bg_active',
            [
                'label' => 'Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-sidebar-item.active' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
    
        $this->end_controls_tabs();
    
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

        $settings = $this->get_settings_for_display();

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

        if (!empty($settings['show_all']) && $settings['show_all'] === 'yes') {
            echo '<div class="rm-sidebar-item active" data-id="all">';
            echo '<span class="rm-cidade">' . esc_html($settings['text_all']) . '</span>';
            echo '</div>';
        }

        foreach ($cidades as $cidade) {

            echo '<div class="rm-sidebar-item" data-id="' . esc_attr($cidade->id) . '">';
            echo '<span class="rm-cidade">' . esc_html($cidade->nome) . '</span>';
            if (!empty($settings['show_total']) && $settings['show_total'] === 'yes') {
                echo '<span class="rm-total">' . intval($cidade->total) . '</span>';
            }
            echo '</div>';
        }

        echo '</div>';
    }
}

