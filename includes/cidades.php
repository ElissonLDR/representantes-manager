<?php
if (!defined('ABSPATH')) exit;

require_once RM_PATH . 'includes/db.php';

function rm_render_cidades_page() {

    if (!current_user_can('manage_options')) return;

    global $wpdb;
    $table = rm_get_table('cidades');
    $rel_table = rm_get_table('rel');

    // RESET (NOVO)
    if (isset($_GET['novo'])) {
        $edit = null;
    }

    // CREATE / UPDATE
    if (isset($_POST['rm_save_cidade']) && check_admin_referer('rm_cidade_nonce')) {

        $id = intval($_POST['id'] ?? 0);
        $nome = rm_sanitize_text($_POST['nome'] ?? '');

        if ($nome) {

            if ($id > 0) {
                $wpdb->update($table, ['nome' => $nome], ['id' => $id]);
            } else {
                $wpdb->insert($table, ['nome' => $nome]);
            }
        }
    }

    // DELETE (com nonce)
    if (isset($_GET['delete']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'rm_delete_cidade')) {

        $id = intval($_GET['delete']);

        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $rel_table WHERE cidade_id = %d",
            $id
        ));

        if ($count == 0) {
            $wpdb->delete($table, ['id' => $id]);
        }
    }

    // EDIT MODE
    $edit = null;
    if (isset($_GET['edit'])) {
        $edit_id = intval($_GET['edit']);
        $edit = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $edit_id));
    }

    $cidades = $wpdb->get_results("SELECT * FROM $table ORDER BY id ASC");

    echo '<div class="wrap"><h1>Cidades</h1>';

    echo '<a href="?page=rm-cidades&novo=1" class="button">Novo</a>';

    echo '<div style="display:flex;gap:20px;margin-top:15px;">';

    // FORM (ESQUERDA)
    echo '<div style="width:300px;">';
    echo '<form method="POST">';
    wp_nonce_field('rm_cidade_nonce');

    echo '<input type="hidden" name="id" value="' . esc_attr($edit->id ?? '') . '">';
    echo '<input type="text" name="nome" placeholder="Nome da cidade" value="' . esc_attr($edit->nome ?? '') . '" required style="width:100%;margin-bottom:10px;">';

    echo '<button type="submit" name="rm_save_cidade" class="button button-primary">Salvar</button>';

    echo '</form>';
    echo '</div>';

    // LISTA (DIREITA)
    echo '<div style="flex:1;">';
    echo '<table class="widefat">';
    echo '<thead><tr><th>ID</th><th>Nome</th><th>Ações</th></tr></thead><tbody>';

    foreach ($cidades as $cidade) {

        $edit_url = admin_url('admin.php?page=rm-cidades&edit=' . $cidade->id);

        $delete_url = wp_nonce_url(
            admin_url('admin.php?page=rm-cidades&delete=' . $cidade->id),
            'rm_delete_cidade'
        );

        echo '<tr>';
        echo '<td>' . $cidade->id . '</td>';
        echo '<td>' . esc_html($cidade->nome) . '</td>';
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