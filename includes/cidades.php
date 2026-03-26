<?php
if (!defined('ABSPATH')) exit;

require_once RM_PATH . 'includes/db.php';

function rm_render_cidades_page() {

    if (!current_user_can('manage_options')) return;

    global $wpdb;
    $table = rm_get_table('cidades');
    $rel_table = rm_get_table('rel');

<<<<<<< HEAD
    $edit = null;

    // BUSCA
    $search = rm_sanitize_text($_GET['s'] ?? '');

    // RESET
    if (isset($_GET['novo'])) {
        echo '<script>window.location.href="' . admin_url('admin.php?page=rm-cidades') . '";</script>';
        exit;
    }

    // IMPORTADOR TXT
    if (isset($_POST['rm_import_cidades']) && check_admin_referer('rm_import_nonce')) {

        $texto = trim($_POST['import_texto'] ?? '');

        if ($texto) {

            $linhas = explode("\n", $texto);

            foreach ($linhas as $linha) {

                $linha = trim($linha);
                if (!$linha) continue;

                $partes = explode('-', $linha);

                $nome = rm_sanitize_text(trim($partes[0] ?? ''));
                $estado = rm_sanitize_text(trim($partes[1] ?? ''));

                if ($nome) {

                    $exists = $wpdb->get_var($wpdb->prepare(
                        "SELECT id FROM $table WHERE nome = %s",
                        $nome
                    ));

                    if (!$exists) {
                        $wpdb->insert($table, [
                            'nome' => $nome,
                            'estado' => $estado ?: 'RS'
                        ]);
                    }
                }
            }
        }

        echo '<script>window.location.href="' . admin_url('admin.php?page=rm-cidades') . '";</script>';
        exit;
=======
    // RESET (NOVO)
    if (isset($_GET['novo'])) {
        $edit = null;
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
    }

    // CREATE / UPDATE
    if (isset($_POST['rm_save_cidade']) && check_admin_referer('rm_cidade_nonce')) {

        $id = intval($_POST['id'] ?? 0);
<<<<<<< HEAD
        $nome = sanitize_text_field($_POST['nome'] ?? '');
        $estado = rm_sanitize_text($_POST['estado'] ?? '');
=======
        $nome = rm_sanitize_text($_POST['nome'] ?? '');
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432

        if ($nome) {

            if ($id > 0) {
<<<<<<< HEAD
                $wpdb->update($table, [
                    'nome' => $nome,
                    'estado' => $estado ?: 'RS'
                ], ['id' => $id]);
            } else {
                $wpdb->insert($table, [
                    'nome' => $nome,
                    'estado' => $estado ?: 'RS'
                ]);
            }
        }

        // 🔥 redirect LIMPO (sem edit)
        echo '<script>window.location.href="' . admin_url('admin.php?page=rm-cidades') . '";</script>';
        exit;
    }

    // DELETE
=======
                $wpdb->update($table, ['nome' => $nome], ['id' => $id]);
            } else {
                $wpdb->insert($table, ['nome' => $nome]);
            }
        }
    }

    // DELETE (com nonce)
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
    if (isset($_GET['delete']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'rm_delete_cidade')) {

        $id = intval($_GET['delete']);

        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $rel_table WHERE cidade_id = %d",
            $id
        ));

        if ($count == 0) {
            $wpdb->delete($table, ['id' => $id]);
        }
<<<<<<< HEAD

        echo '<script>window.location.href="' . admin_url('admin.php?page=rm-cidades') . '";</script>';
        exit;
    }

    // EDIT MODE
=======
    }

    // EDIT MODE
    $edit = null;
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
    if (isset($_GET['edit'])) {
        $edit_id = intval($_GET['edit']);
        $edit = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $edit_id));
    }

<<<<<<< HEAD
    // PAGINAÇÃO
    $per_page = intval($_GET['per_page'] ?? 25);
    if (!in_array($per_page, [25, 50, 100,500])) $per_page = 25;

    $page = max(1, intval($_GET['paged'] ?? 1));
    $offset = ($page - 1) * $per_page;

    // QUERY
    if ($search) {
        $total = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE nome LIKE %s",
            '%' . $wpdb->esc_like($search) . '%'
        ));
    
        $cidades = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE nome LIKE %s ORDER BY id DESC LIMIT %d OFFSET %d",
            '%' . $wpdb->esc_like($search) . '%',
            $per_page,
            $offset
        ));
    } else {
        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table");
    
        $cidades = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table ORDER BY id DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        ));
    }

    $total_pages = ceil($total / $per_page);

    $box_style = $edit
        ? 'background:linear-gradient(135deg,#e3f2fd,#bbdefb);border:1px solid #90caf9;'
        : 'background:#fff;border:1px solid #ddd;';

    echo '<div class="wrap"><h1 style="font-weight:700;font-size:42px;">Cidades</h1>';

    echo '<div style="display:flex;gap:20px;">';

    // LEFT
    echo '<div style="width:320px;display:flex;flex-direction:column;gap:15px;">';

    echo '<div style="display:flex;>';
    
    echo '<a href="?page=rm-cidades&novo=1" class="button">Novo</a>';

    echo '</div>';

    echo '<div style="' . $box_style . 'padding:15px;">';
    echo '<h3>' . ($edit ? 'Editando Cidade' : 'Adicionar Cidade') . '</h3>';

=======
    $cidades = $wpdb->get_results("SELECT * FROM $table ORDER BY id ASC");

    echo '<div class="wrap"><h1>Cidades</h1>';

    echo '<a href="?page=rm-cidades&novo=1" class="button">Novo</a>';

    echo '<div style="display:flex;gap:20px;margin-top:15px;">';

    // FORM (ESQUERDA)
    echo '<div style="width:300px;">';
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
    echo '<form method="POST">';
    wp_nonce_field('rm_cidade_nonce');

    echo '<input type="hidden" name="id" value="' . esc_attr($edit->id ?? '') . '">';
<<<<<<< HEAD

    echo '<input type="text" name="nome" placeholder="Cidade" value="' . esc_attr($edit->nome ?? '') . '" required style="width:100%;margin-bottom:10px;">';

    echo '<input type="text" name="estado" placeholder="Estado (RS)" value="' . esc_attr($edit->estado ?? '') . '" style="width:100%;margin-bottom:10px;">';

    echo '<button type="submit" name="rm_save_cidade" class="button button-primary" style="width:100%;">' . ($edit ? 'Atualizar' : 'Adicionar') . '</button>';
=======
    echo '<input type="text" name="nome" placeholder="Nome da cidade" value="' . esc_attr($edit->nome ?? '') . '" required style="width:100%;margin-bottom:10px;">';

    echo '<button type="submit" name="rm_save_cidade" class="button button-primary">Salvar</button>';
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432

    echo '</form>';
    echo '</div>';

<<<<<<< HEAD
    echo '<div style="background:#fff;padding:15px;border:1px solid #ddd;">';
    echo '<h3>Adicionar várias cidades</h3>';

    echo '<form method="POST">';
    wp_nonce_field('rm_import_nonce');

    echo '<textarea name="import_texto" placeholder="Exemplo:
Cidade - RS
Cidade 2 - RS" style="width:100%;height:120px;"></textarea>';

    echo '<button type="submit" name="rm_import_cidades" class="button" style="width:100%;margin-top:10px;">Adicionar todos</button>';

    echo '</form>';
    echo '</div>';

    echo '</div>';

    // RIGHT
    echo '<div style="flex:1;">';

    echo '<div style="display:flex;justify-content:space-between;margin-bottom:15px;">';

    echo '<form id="rm-filtro-form" method="GET" style="display:flex;gap:50px;align-items:center;justify-content:space-between;width:100%;">';
    echo '<input type="hidden" name="page" value="rm-cidades">';
    echo '<div>';
    echo '<input id="rm-search" type="text" style="width:300px;margin-right:20px;" name="s" value="' . esc_attr($search) . '" placeholder="Buscar cidade...">';
    echo '<strong>Total: ' . intval($total) . '</strong>';
    echo '</div>';
    echo '<select id="rm-per-page" name="per_page">';
    foreach ([25,50,100,500] as $opt) {
        echo '<option value="'.$opt.'" '.selected($per_page, $opt, false).'>'.$opt.'</option>';
    }
    echo '</select>';
    echo '</form>';    

    echo '</div>';

    echo '<table class="widefat striped">';
    echo '<thead><tr><th>Cidade</th><th>Estado</th><th>Ações</th></tr></thead><tbody>';
=======
    // LISTA (DIREITA)
    echo '<div style="flex:1;">';
    echo '<table class="widefat">';
    echo '<thead><tr><th>ID</th><th>Nome</th><th>Ações</th></tr></thead><tbody>';
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432

    foreach ($cidades as $cidade) {

        $edit_url = admin_url('admin.php?page=rm-cidades&edit=' . $cidade->id);

        $delete_url = wp_nonce_url(
            admin_url('admin.php?page=rm-cidades&delete=' . $cidade->id),
            'rm_delete_cidade'
        );

        echo '<tr>';
<<<<<<< HEAD
        echo '<td>' . esc_html($cidade->nome) . '</td>';
        echo '<td>' . esc_html($cidade->estado) . '</td>';
=======
        echo '<td>' . $cidade->id . '</td>';
        echo '<td>' . esc_html($cidade->nome) . '</td>';
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
        echo '<td>';
        echo '<a href="' . esc_url($edit_url) . '">Editar</a> | ';
        echo '<a href="' . esc_url($delete_url) . '" onclick="return confirm(\'Tem certeza?\')">Excluir</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
<<<<<<< HEAD

    // 🔥 PAGINAÇÃO AQUI
    echo '<div style="margin-top:15px;display:flex;gap:5px;flex-wrap:wrap;">';
    
    for ($p = 1; $p <= $total_pages; $p++) {
    
        $url = add_query_arg([
            'page' => 'rm-cidades',
            'paged' => $p,
            'per_page' => $per_page,
            's' => $search
        ], admin_url('admin.php'));
    
        $style = $p == $page ? 'font-weight:bold;background:#0073aa;color:#fff;' : '';
    
        echo '<a href="' . esc_url($url) . '" class="button" style="' . $style . '">' . $p . '</a>';
    }
    
    echo '</div>';

    echo '</div></div>';

    echo '
    <script>
    (function(){
        const form = document.getElementById("rm-filtro-form");
        const search = document.getElementById("rm-search");
        const perPage = document.getElementById("rm-per-page");
    
        let timeout = null;
    
        // 🔍 Busca automática (com debounce)
        if(search){
            search.addEventListener("keyup", function(){
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    form.submit();
                }, 250);
            });
        }
    
        // 🔢 Mudança de quantidade (instantâneo)
        if(perPage){
            perPage.addEventListener("change", function(){
                form.submit();
            });
        }
    
    })();
    </script>
    ';
=======
    echo '</div>';

    echo '</div></div>';
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
}