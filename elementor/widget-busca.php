<?php
if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;

class RM_Widget_Busca extends Widget_Base {

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
}