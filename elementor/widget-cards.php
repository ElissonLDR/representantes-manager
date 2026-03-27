<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Cards extends Widget_Base {

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
    
        // Colunas
        $this->add_responsive_control(
            'columns',
            [
                'label' => 'Colunas',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1 Coluna',
                    '2' => '2 Colunas',
                    '3' => '3 Colunas',
                    '4' => '4 Colunas',
                ],
                'selectors' => [
                    '{{WRAPPER}} .rm-cards' => 'display:grid; grid-template-columns: repeat({{VALUE}}, 1fr);'
                ]
            ]
        );
    
        // Gap
        $this->add_responsive_control(
            'gap',
            [
                'label' => 'Espaçamento entre cards',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .rm-cards' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
    
        // Mostrar elementos
        $this->add_control('show_nome', [
            'label' => 'Mostrar nome',
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
    
        $this->add_control('show_cidades', [
            'label' => 'Mostrar cidades',
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
    
        $this->add_control('show_telefones', [
            'label' => 'Mostrar telefones',
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
    
        $this->add_control('show_botao', [
            'label' => 'Mostrar botão',
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
    
        $this->end_controls_section();
    
        /* ======================================================
        =============== ESTILO - TÍTULO CONTEÚDO ================
        ====================================================== */

        $this->start_controls_section(
            'section_titulo',
            [
                'label' => 'Título Conteúdo',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'titulo_typo',
                'selector' => '{{WRAPPER}} .rm-titulo',
            ]
        );

        $this->add_control(
            'titulo_cor',
            [
                'label' => 'Cor do Título',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-titulo' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    
        /* ======================================================
        =============== ESTILO - CARD ===========================
        ====================================================== */
    
        $this->start_controls_section(
            'section_card',
            [
                'label' => 'Card',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'bg_card',
            [
                'label' => 'Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-card' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_responsive_control(
            'padding_card',
            [
                'label' => 'Padding',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rm-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_responsive_control(
            'radius_card',
            [
                'label' => 'Border Radius',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rm-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'shadow_card',
                'selector' => '{{WRAPPER}} .rm-card',
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTILO - NOME ===========================
        ====================================================== */
    
        $this->start_controls_section(
            'section_nome',
            [
                'label' => 'Nome',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'nome_typo',
                'selector' => '{{WRAPPER}} .rm-nome',
            ]
        );
    
        $this->add_control(
            'nome_color',
            [
                'label' => 'Cor',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-nome' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTILO - CIDADES ========================
        ====================================================== */
    
        $this->start_controls_section(
            'section_cidades',
            [
                'label' => 'Cidades',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cidades_typo',
                'selector' => '{{WRAPPER}} .rm-cidades',
            ]
        );
    
        $this->add_control(
            'cidades_color',
            [
                'label' => 'Cor',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-cidades' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTILO - TELEFONES ======================
        ====================================================== */
    
        $this->start_controls_section(
            'section_telefones',
            [
                'label' => 'Telefones',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tel_typo',
                'selector' => '{{WRAPPER}} .rm-telefone',
            ]
        );
    
        $this->add_control(
            'tel_color',
            [
                'label' => 'Cor',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-telefone' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTILO - BOTÃO ==========================
        ====================================================== */
    
        $this->start_controls_section(
            'section_botao',
            [
                'label' => 'Botão',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'btn_bg',
            [
                'label' => 'Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-ver-cidades' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'btn_color',
            [
                'label' => 'Cor do ícone',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-ver-cidades' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_responsive_control(
            'btn_radius',
            [
                'label' => 'Border Radius',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rm-ver-cidades' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    
    
        /* ======================================================
        =============== ESTADOS (HOVER) =========================
        ====================================================== */
    
        $this->start_controls_section(
            'section_hover',
            [
                'label' => 'Hover',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'hover_bg',
            [
                'label' => 'Background Hover',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rm-card:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'hover_shadow',
                'selector' => '{{WRAPPER}} .rm-card:hover',
            ]
        );
    
        $this->end_controls_section();
    }

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

        $settings = $this->get_settings_for_display();

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

        echo '<div class="rm-header" style="display:flex;align-items:center;gap:16px">';
        echo '<h2 class="rm-titulo">Todos</h2>';
        echo '<span class="rm-quantidade"></span>';
        echo '</div>';
        
        echo '<div class="rm-cards">';

        foreach ($representantes as $rep) {

            $cidades = $wpdb->get_results($wpdb->prepare(
                "SELECT c.id, c.nome, c.estado
                 FROM $rel_table rc
                 JOIN $cidades_table c ON c.id = rc.cidade_id
                 WHERE rc.representante_id = %d",
                $rep->id
            ));
            
            $cidades_nomes = array_map(fn($c) => $c->nome . ' - ' . $c->estado, $cidades);
            $cidades_ids = array_column($cidades, 'id');

            echo '<div class="rm-card" data-cidades="' . esc_attr(implode(',', $cidades_ids)) . '">';
            
            if (!empty($settings['show_nome']) && $settings['show_nome'] === 'yes') {
                echo '<h3 class="rm-nome">' . esc_html($rep->nome) . '</h3>';
            }

            echo '<p class="rm-cidades" style="display:' . 
            (!empty($settings['show_cidades']) && $settings['show_cidades'] === 'yes' ? 'block' : 'none') . '">' . esc_html(implode(', ', $cidades_nomes)) . '</p>';

            $telefones = $wpdb->get_col($wpdb->prepare(
                "SELECT telefone FROM {$wpdb->prefix}rm_telefones WHERE representante_id = %d",
                $rep->id
            ));
            
            if (!empty($settings['show_telefones']) && $settings['show_telefones'] === 'yes') {
                if ($telefones) {
                    foreach ($telefones as $tel) {
                        echo '<span class="rm-telefone">' . esc_html($tel) . '</span><br>';
                    }
                }
            }

            if (!empty($settings['show_botao']) && $settings['show_botao'] === 'yes') {
                echo '<button class="rm-ver-cidades" data-id="'.$rep->id.'">Ver todas cidades</button>';
            }
            
            echo '</div>';

        }

        echo '</div>';

        echo '
        <div id="rm-modal" style="display:none;">
            <div class="rm-modal-content">
                <span class="rm-close">×</span>
                <div id="rm-modal-cidades"></div>
            </div>
        </div>
        ';

    }
}