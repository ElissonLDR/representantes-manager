<?php
if (!defined('ABSPATH')) exit;

require_once RM_PATH . 'includes/db.php';
// Elementor (mantido)
require_once RM_PATH . 'elementor/widgets.php';

function rm_render_representantes_page() {

    if (!current_user_can('manage_options')) return;

    global $wpdb;

    $table = rm_get_table('representantes');
    $rel_table = rm_get_table('rel');
    $cidades_table = rm_get_table('cidades');

    $edit = null;
    $selected_cidades = [];

    // RESET (NOVO)
    if (isset($_GET['novo'])) {
        $edit = null;
        $selected_cidades = [];
    }

    // CREATE / UPDATE
    if (isset($_POST['rm_save_rep']) && check_admin_referer('rm_rep_nonce')) {

        $id = intval($_POST['id'] ?? 0);
        $nome = rm_sanitize_text($_POST['nome'] ?? '');
        $telefone = rm_sanitize_text($_POST['telefone'] ?? '');
        $email = rm_sanitize_email($_POST['email'] ?? '');
        $cidades = $_POST['cidades'] ?? [];

        if ($nome) {

            if ($id > 0) {
                $wpdb->update($table, [
                    'nome' => $nome,
                    'telefone' => $telefone,
                    'email' => $email
                ], ['id' => $id]);

                // limpa relações antigas
                $wpdb->delete($rel_table, ['representante_id' => $id]);

                $rep_id = $id;

            } else {
                $wpdb->insert($table, [
                    'nome' => $nome,
                    'telefone' => $telefone,
                    'email' => $email
                ]);

                $rep_id = $wpdb->insert_id;
            }

            // 🔥 evita duplicidade (já pensando no UNIQUE do DB)
            $cidades = array_unique(array_map('intval', $cidades));

            if (!empty($cidades)) {
                foreach ($cidades as $cidade_id) {

                    // evita duplicado manual também
                    $exists = $wpdb->get_var($wpdb->prepare(
                        "SELECT id FROM $rel_table WHERE representante_id = %d AND cidade_id = %d",
                        $rep_id,
                        $cidade_id
                    ));

                    if (!$exists) {
                        $wpdb->insert($rel_table, [
                            'representante_id' => $rep_id,
                            'cidade_id' => $cidade_id
                        ]);
                    }
                }
            }
        }
    }

    // DELETE
    if (isset($_GET['delete']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'rm_delete_rep')) {

        $id = intval($_GET['delete']);

        $wpdb->delete($table, ['id' => $id]);
        $wpdb->delete($rel_table, ['representante_id' => $id]);
    }

    // EDIT MODE
    if (isset($_GET['edit']) && !isset($_GET['novo'])) {

        $edit_id = intval($_GET['edit']);

        $edit = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table WHERE id = %d", $edit_id)
        );

        $selected_cidades = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT cidade_id FROM $rel_table WHERE representante_id = %d",
                $edit_id
            )
        );
    }

    $cidades = $wpdb->get_results("SELECT * FROM $cidades_table ORDER BY nome ASC");

    // QUERY OTIMIZADA
    $representantes = $wpdb->get_results("
        SELECT r.*, GROUP_CONCAT(c.nome) as cidades
        FROM $table r
        LEFT JOIN $rel_table rc ON rc.representante_id = r.id
        LEFT JOIN $cidades_table c ON c.id = rc.cidade_id
        GROUP BY r.id
        ORDER BY r.nome ASC
    ");

    echo '<div class="wrap"><h1>Representantes</h1>';

    echo '<a href="?page=rm-representantes&novo=1" class="button">Novo</a>';

    echo '<div style="display:flex;gap:20px;margin-top:15px;">';

    // FORM
    echo '<div style="width:300px;">';
    echo '<form method="POST">';
    wp_nonce_field('rm_rep_nonce');

    echo '<input type="hidden" name="id" value="' . esc_attr($edit->id ?? '') . '">';

    echo '<input type="text" name="nome" placeholder="Nome" value="' . esc_attr($edit->nome ?? '') . '" required style="width:100%;margin-bottom:10px;">';

    echo '<input type="text" name="telefone" placeholder="Telefone" value="' . esc_attr($edit->telefone ?? '') . '" style="width:100%;margin-bottom:10px;">';

    echo '<input type="email" name="email" placeholder="Email" value="' . esc_attr($edit->email ?? '') . '" style="width:100%;margin-bottom:10px;">';

    echo '<select name="cidades[]" multiple style="width:100%;height:120px;">';

    foreach ($cidades as $cidade) {

        $selected = (!empty($selected_cidades) && in_array($cidade->id, $selected_cidades)) ? 'selected' : '';

        echo '<option value="' . esc_attr($cidade->id) . '" ' . $selected . '>' . esc_html($cidade->nome) . '</option>';
    }

    echo '</select>';

    echo '<button type="submit" name="rm_save_rep" class="button button-primary" style="margin-top:10px;">Salvar</button>';

    echo '</form>';
    echo '</div>';

    // LISTA
    echo '<div style="flex:1;">';

    echo '<table class="widefat">';
    echo '<thead><tr><th>ID</th><th>Nome</th><th>Telefone</th><th>Email</th><th>Cidades</th><th>Ações</th></tr></thead><tbody>';

    foreach ($representantes as $rep) {

        $cidades_lista = $rep->cidades ? explode(',', $rep->cidades) : [];

        $edit_url = admin_url('admin.php?page=rm-representantes&edit=' . $rep->id);

        $delete_url = wp_nonce_url(
            admin_url('admin.php?page=rm-representantes&delete=' . $rep->id),
            'rm_delete_rep'
        );

        echo '<tr>';
        echo '<td>' . $rep->id . '</td>';
        echo '<td>' . esc_html($rep->nome) . '</td>';
        echo '<td>' . esc_html($rep->telefone) . '</td>';
        echo '<td>' . esc_html($rep->email) . '</td>';
        echo '<td>' . esc_html(implode(', ', $cidades_lista)) . '</td>';
        echo '<td>';
        echo '<a href="' . esc_url($edit_url) . '">Editar</a> | ';
        echo '<a href="' . esc_url($delete_url) . '" onclick="return confirm(\'Tem certeza?\')">Excluir</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';

    echo '</div></div>';
}

// Assets (mantido)
add_action('wp_enqueue_scripts', 'rm_enqueue_assets');

function rm_enqueue_assets() {

    wp_enqueue_style('rm-style', RM_URL . 'assets/css/style.css', [], RM_VERSION);
    wp_enqueue_script('rm-script', RM_URL . 'assets/js/script.js', [], RM_VERSION, true);
}