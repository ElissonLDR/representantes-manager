<?php
if (!defined('ABSPATH')) exit;

// Carrega dependências com segurança
if (file_exists(RM_PATH . 'includes/cidades.php')) {
    require_once RM_PATH . 'includes/cidades.php';
}

if (file_exists(RM_PATH . 'includes/representantes.php')) {
    require_once RM_PATH . 'includes/representantes.php';
}

add_action('admin_menu', 'rm_register_admin_menu');

function rm_register_admin_menu() {

    add_menu_page(
        'Representantes',
        'Representantes',
        'manage_options',
        'rm-dashboard',
        'rm_render_dashboard',
        'dashicons-groups',
        25
    );

    add_submenu_page(
        'rm-dashboard',
        'Cidades',
        'Cidades',
        'manage_options',
        'rm-cidades',
        'rm_render_cidades_page'
    );

    add_submenu_page(
        'rm-dashboard',
        'Representantes',
        'Representantes',
        'manage_options',
        'rm-representantes',
        'rm_render_representantes_page'
    );
}

function rm_render_dashboard() {
    ?>
    <div class="wrap">
        <h1>Representantes Manager</h1>
        <p>Sistema pronto para uso.</p>

        <div style="margin-top:20px; display:flex; gap:20px;">
            
            <a href="<?php echo admin_url('admin.php?page=rm-cidades'); ?>" 
               class="button button-primary" 
               style="padding:20px; font-size:16px;">
               Gerenciar Cidades
            </a>

            <a href="<?php echo admin_url('admin.php?page=rm-representantes'); ?>" 
               class="button button-primary" 
               style="padding:20px; font-size:16px;">
               Gerenciar Representantes
            </a>

        </div>
    </div>
    <?php
}