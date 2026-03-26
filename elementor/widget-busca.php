<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Busca extends Widget_Base {

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
        return 'rm_busca';
    }

    public function get_title() {
        return 'RM - Busca';
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function render() {

        echo '
        <div class="rm-busca">
            <input type="text" id="rm-search" placeholder="Buscar cidade ou representante..." />
        </div>
        ';
    }
<<<<<<< HEAD
}

=======
}
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
