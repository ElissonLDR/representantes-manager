<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'rm_register_admin_menu');
add_action('admin_enqueue_scripts', 'rm_admin_dashboard_assets');

function rm_register_admin_menu() {

    add_menu_page(
        'Visão Geral',
        'Representantes',
        RM_CAP,
        'rm-dashboard',
        'rm_render_dashboard',
        'dashicons-groups',
        25
    );

    // Substitui o submenu automático "Representantes" duplicado
    add_submenu_page(
        'rm-dashboard',
        'Visão Geral',
        'Visão Geral',
        RM_CAP,
        'rm-dashboard',
        'rm_render_dashboard'
    );

    add_submenu_page(
        'rm-dashboard',
        'Cidades',
        'Cidades',
        RM_CAP,
        'rm-cidades',
        'rm_admin_cidades_page'
    );

    add_submenu_page(
        'rm-dashboard',
        'Representantes',
        'Representantes',
        RM_CAP,
        'rm-representantes',
        'rm_admin_representantes_page'
    );
}

function rm_admin_dashboard_assets($hook) {
    if ($hook !== 'toplevel_page_rm-dashboard') {
        return;
    }

    wp_add_inline_style('wp-admin', '
        .rm-dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            margin: 24px 0;
        }
        .rm-dashboard-card {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .rm-dashboard-card h3 {
            margin: 0 0 8px;
            font-size: 13px;
            font-weight: 600;
            color: #646970;
            text-transform: uppercase;
            letter-spacing: .02em;
        }
        .rm-dashboard-card .rm-stat {
            font-size: 32px;
            font-weight: 600;
            line-height: 1.2;
            color: #1d2327;
        }
        .rm-dashboard-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 8px;
        }
    ');
}

function rm_get_dashboard_stats() {
    global $wpdb;

    $cidades_table = rm_get_table('cidades');
    $rep_table = rm_get_table('representantes');
    $rel_table = rm_get_table('rel');
    $tel_table = rm_get_table('telefones');

    $stats = [
        'cidades'          => 0,
        'representantes'   => 0,
        'vinculos'         => 0,
        'telefones'        => 0,
        'cidades_sem_rep'  => 0,
    ];

    if (!$cidades_table || !$rep_table || !$rel_table) {
        return $stats;
    }

    $stats['cidades'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$cidades_table}");
    $stats['representantes'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$rep_table}");
    $stats['vinculos'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$rel_table}");

    $stats['cidades_sem_rep'] = (int) $wpdb->get_var(
        "SELECT COUNT(*) FROM {$cidades_table} c
         WHERE NOT EXISTS (
            SELECT 1 FROM {$rel_table} r WHERE r.cidade_id = c.id
         )"
    );

    if ($tel_table && $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $tel_table)) === $tel_table) {
        $stats['telefones'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$tel_table}");
    }

    return $stats;
}

function rm_admin_cidades_page() {
    require_once RM_PATH . 'includes/cidades.php';
    rm_render_cidades_page();
}

function rm_admin_representantes_page() {
    require_once RM_PATH . 'includes/representantes.php';
    rm_render_representantes_page();
}

function rm_render_dashboard() {
    $stats = rm_get_dashboard_stats();
    $url_cidades = admin_url('admin.php?page=rm-cidades');
    $url_reps = admin_url('admin.php?page=rm-representantes');
    ?>
    <div class="wrap">
        <h1>Visão Geral</h1>
        <p>Resumo do cadastro de representantes e cidades.</p>

        <div class="rm-dashboard-cards">
            <div class="rm-dashboard-card">
                <h3>Cidades</h3>
                <div class="rm-stat"><?php echo esc_html(number_format_i18n($stats['cidades'])); ?></div>
            </div>
            <div class="rm-dashboard-card">
                <h3>Representantes</h3>
                <div class="rm-stat"><?php echo esc_html(number_format_i18n($stats['representantes'])); ?></div>
            </div>
            <div class="rm-dashboard-card">
                <h3>Vínculos cidade ↔ rep.</h3>
                <div class="rm-stat"><?php echo esc_html(number_format_i18n($stats['vinculos'])); ?></div>
            </div>
            <div class="rm-dashboard-card">
                <h3>Telefones cadastrados</h3>
                <div class="rm-stat"><?php echo esc_html(number_format_i18n($stats['telefones'])); ?></div>
            </div>
            <div class="rm-dashboard-card">
                <h3>Cidades sem representante</h3>
                <div class="rm-stat"><?php echo esc_html(number_format_i18n($stats['cidades_sem_rep'])); ?></div>
            </div>
        </div>

        <div class="rm-dashboard-actions">
            <a href="<?php echo esc_url($url_cidades); ?>" class="button button-primary button-hero">
                Gerenciar Cidades
            </a>
            <a href="<?php echo esc_url($url_reps); ?>" class="button button-secondary button-hero">
                Gerenciar Representantes
            </a>
        </div>
    </div>
    <?php
}
